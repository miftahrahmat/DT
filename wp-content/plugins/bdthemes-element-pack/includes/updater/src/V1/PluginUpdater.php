<?php 

namespace ElementPack\V1;

if (!class_exists('\\ElementPack\\V1\\Plugin_Updater', false)) :

class PluginUpdater {
	private $plugin_path;
	private $plugin_file;
	private $plugin_slug;
	private $updater_url;

	public function __construct($name, $updater_url, $plugin_slug, $plugin_path, $plugin_version = '0.0.0') {
		$this->version        = '1.2.3';
		$this->name           = $name;
		$this->updater_url    = untrailingslashit($updater_url);
		$this->plugin_slug    = $plugin_slug;
		$this->plugin_path    = $plugin_path;
		$this->plugin_file    = plugin_basename($plugin_path);
		$this->plugin_version = $plugin_version;
		//add_filter('plugin_action_links_' . $this->plugin_file, array($this, 'display_credential_ui'));

		add_action('admin_print_scripts-plugins.php', array($this, 'print_scripts'));
		add_action('after_plugin_row_' . $this->plugin_file, array($this, 'after_plugin_row'), 10, 2);
		add_action('wp_ajax_mpu_save_license_' . $this->plugin_slug, array($this, 'save_license'));
		add_action('wp_ajax_mpu_validate_license_' . $this->plugin_slug, array($this, 'ajax_validate_license'));
		add_action('wp_ajax_mpu_hide_notice_' . $this->plugin_slug, array($this, 'hide_notice'));
		add_action('admin_notices', array($this, 'admin_notices'));
		add_filter('plugin_action_links_' . $this->plugin_file, array($this, 'filter_action_links'));

		$this->includes();
		$update_checker = $this->setup_updater();
	}

	public function print_scripts() {
		wp_register_script(
			'mateffy-plugin-updater-v1', 
			plugin_dir_url(dirname(__DIR__)) . 'assets/js/credentials.js', 
			array('jquery'),
			$this->version
		);

		wp_enqueue_script('mateffy-plugin-updater-v1');
	}

	public function after_plugin_row($plugin_file, $plugin_data) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				mateffyPluginUpdater100.setupLicenseUI({
					slug: '<?php echo $this->plugin_slug; ?>',
					url: '<?php echo $this->updater_url; ?>',
					license: '<?php echo $this->get_license(); ?>'
				});
			});
		</script>

		<?php
	}

	public function save_license() {
		$license = sanitize_text_field($_POST['license_key']);

		$this->set_license($license);

		wp_send_json(array(
			'success' => true
		));
		wp_die();
	}

	public function ajax_validate_license() {
		$license = sanitize_text_field($_GET['license_key']);
		$valid   = $this->validate_license($license);

		wp_send_json(array(
			'valid' => $valid
		));
		wp_die();
	}

	public function filter_action_links($actions) {
		$license = $this->get_license();
		if (!empty($license)) {
			$actions['enter-license'] = '<a href="#" id="enter-license-' . $this->plugin_slug . '">License Settings</a>';
		}
		else {
			$actions['enter-license'] = '<a style="color: #3db634;" href="#" id="enter-license-' . $this->plugin_slug . '">Enter License</a>';
		}

		return $actions;
	}

	private function setup_updater() {
		$update_checker = \Puc_v4_Factory::buildUpdateChecker(
			$this->updater_url . '/?action=get_metadata&slug=' . $this->plugin_slug,
			$this->plugin_path,
			$this->plugin_slug
		);

		$update_checker->addQueryArgFilter(array($this, 'update_check_filter'));

		return $update_checker;
	}

	private function includes() {
		include_once dirname(__DIR__) . '../../plugin-update-checker-4.5/plugin-update-checker.php';
	}

	public function admin_notices() {
		if ($this->has_license())
			return;

		$timeToShow = intval(get_option($this->plugin_slug . '_license_notice_hidden', 0));

		if (time() < $timeToShow)
			return;

		$activate_url = admin_url('plugins.php#enter-license-' . $this->plugin_slug);
		$hide_url     = admin_url('admin-ajax.php?action=mpu_hide_notice_' . $this->plugin_slug);
		$help_url     = 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-';

		?>
			<div class="wp-core-ui">
				<div class="notice notice-info is-dismissible">
					<form method="post" action="<?php echo $hide_url; ?>">
						<h3><?php esc_html_e('Activate Element Pack with your Envato Purchase Code', 'bdthemes-element-pack'); ?></h3>
						<p><?php printf( __('To completely utilize your copy of <i>Element Pack</i>, please 
							<a href="%1s">activate</a> it using the <strong>Envato Purchase Code</strong>.<br>
							If you don\'t know how to find your Purchase Code, please get help from <a href="%2s">here</a>.', 'bdthemes-element-pack'), $activate_url, $help_url ); ?></p>

						<button type="submit" class="notice-dismiss">
							<span class="screen-reader-text"><?php esc_html_e('Dismiss Notice', 'bdthemes-element-pack'); ?></span>
						</button>
					</form>
				</div>
			</div>
		<?php
	}

	public function hide_notice() {
		$two_weeks = 1 * 60 * 60 * 24 * 14;
		update_option($this->plugin_slug . '_license_notice_hidden', intval(time()) + $two_weeks);

		wp_redirect(admin_url('plugins.php'));
		exit;
	}

	public function update_check_filter($query_args) {
		$license_key = $this->get_license();
		if (!empty($license_key)) {
			$query_args['license_key'] = $license_key;
		}

		$query_args['m'] = $this->get_wp_metadata();

		return $query_args;
	}

	private function has_license() {
		$license_key = $this->get_license();
		$has_license = !empty($license_key);
		return $has_license;
	}

	private function get_license() {
		$get_license = get_option('mpu_license_' . $this->plugin_slug);
		return $get_license;
	}

	private function set_license($license) {
		update_option('mpu_license_' . $this->plugin_slug, $license);
	}

	private function validate_license($license_key) {
		try {
			$metadata = $this->get_wp_metadata();
			$response = @wp_remote_get(
				$this->updater_url . '/?action=verify&license_key=' . $license_key . '&slug=' . $this->plugin_slug . '&m=' . $metadata
			);

			if(is_wp_error($response)) {
				return false;
			}

			$data = json_decode($response['body']);
			$output = property_exists($data, 'valid') && $data->valid === true;
			return $output;
		} catch (Exception $e) {
			return false;
		}
	}

	private function get_wp_metadata() {
		$data = json_encode(array(
			'url'     => get_site_url(),
			'version' => $this->plugin_version
		));

		$output = base64_encode($data);

		return $output;
	}
}

endif;