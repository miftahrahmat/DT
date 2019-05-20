<?php
namespace ElementPack;

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main class for element pack
 */
class Element_Pack_Loader {

	/**
	 * @var Element_Pack_Loader
	 */
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	private $classes_aliases = [
		'ElementPack\Modules\PanelPostsControl\Module' => 'ElementPack\Modules\QueryControl\Module',
		'ElementPack\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'ElementPack\Modules\QueryControl\Controls\Group_Control_Posts',
		'ElementPack\Modules\PanelPostsControl\Controls\Query' => 'ElementPack\Modules\QueryControl\Controls\Query',
	];

	public $elements_data = [
		'sections' => [],
		'columns'  => [],
		'widgets'  => [],
	];

	/**
	 * @deprecated
	 *
	 * @return string
	 */
	public function get_version() {
		return BDTEP_VER;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bdthemes-element-pack' ), '1.6.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bdthemes-element-pack' ), '1.6.0' );
	}

	/**
	 * @return \Elementor\Element_Pack_Loader
	 */

	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}

	/**
	 * @return Element_Pack_Loader
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	

	/**
	 * we loaded module manager + admin php from here
	 * @return [type] [description]
	 */
	private function _includes() {
		require BDTEP_PATH . 'includes/modules-manager.php';
		if ( is_admin() ) {
			if(!defined('BDTEP_CH')) {
				require BDTEP_PATH . 'includes/admin.php';

				// Load admin class for admin related content process
				new Admin();
			}
		}

	}

	/**
	 * Autoloader function for all classes files
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$has_class_alias = isset( $this->classes_aliases[ $class ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded
		if ( $has_class_alias ) {
			$class_alias_name = $this->classes_aliases[ $class ];
			$class_to_load = $class_alias_name;
		} else {
			$class_to_load = $class;
		}

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = BDTEP_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}

		if ( $has_class_alias ) {
			class_alias( $class_alias_name, $class );
		}
	}

	/**
	 * Register all script that need for any specific widget on call basis.
	 * @return [type] [description]
	 */
	public function register_site_scripts() {

		$suffix   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$settings = get_option( 'element_pack_api_settings' );

		wp_register_script( 'bdt-uikit-icons', BDTEP_URL . 'assets/js/bdt-uikit-icons' . $suffix . '.js', ['jquery', 'bdt-uikit'], '3.0.3', true );
		wp_register_script( 'goodshare', BDTEP_URL . 'assets/vendor/js/goodshare' . $suffix . '.js', ['jquery'], '4.1.2', true );
		wp_register_script( 'twentytwenty', BDTEP_URL . 'assets/vendor/js/jquery.twentytwenty' . $suffix . '.js', ['jquery'], '0.1.0', true );
		wp_register_script( 'eventmove', BDTEP_URL . 'assets/vendor/js/jquery.event.move' . $suffix . '.js', ['jquery'], '2.0.0', true );
		wp_register_script( 'aspieprogress', BDTEP_URL . 'assets/vendor/js/jquery-asPieProgress' . $suffix . '.js', ['jquery'], '0.4.7', true );
		wp_register_script( 'morphext', BDTEP_URL . 'assets/vendor/js/morphext' . $suffix . '.js', ['jquery'], '2.4.7', true );
		wp_register_script( 'qrcode', BDTEP_URL . 'assets/vendor/js/jquery-qrcode' . $suffix . '.js', ['jquery'], '0.14.0', true );
		wp_register_script( 'jplayer', BDTEP_URL . 'assets/vendor/js/jquery.jplayer' . $suffix . '.js', ['jquery'], '2.9.2', true );
		wp_register_script( 'circle-menu', BDTEP_URL . 'assets/vendor/js/jQuery.circleMenu' . $suffix . '.js', ['jquery'], '0.1.1', true );
		wp_register_script( 'cookieconsent', BDTEP_URL . 'assets/vendor/js/cookieconsent' . $suffix . '.js', ['jquery'], '3.1.0', true );
		wp_register_script( 'gridtab', BDTEP_URL . 'assets/vendor/js/gridtab' . $suffix . '.js', ['jquery'], '2.1.1', true );
		
		if (!empty($settings['google_map_key'])) {
			wp_register_script( 'gmap-api', '//maps.googleapis.com/maps/api/js?key='.$settings['google_map_key'], ['jquery'], null, true );
		} else {
			wp_register_script( 'gmap-api', '//maps.google.com/maps/api/js?sensor=true', ['jquery'], null, true );
		}
		
		wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', ['jquery'], null, true );

		wp_register_script( 'chart', BDTEP_URL . 'assets/vendor/js/chart' . $suffix . '.js', ['jquery'], '2.7.3', true );
		wp_register_script( 'gmap', BDTEP_URL . 'assets/vendor/js/gmap' . $suffix . '.js', ['jquery', 'gmap-api'], null, true );
		wp_register_script( 'leaflet', BDTEP_URL . 'assets/vendor/js/leaflet' . $suffix . '.js', ['jquery'], '', true );
		wp_register_script( 'parallax', BDTEP_URL . 'assets/vendor/js/parallax' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'table-of-content', BDTEP_URL . 'assets/vendor/js/table-of-content' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'instagram-feed', BDTEP_URL . 'assets/vendor/js/jquery.instagramFeed' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'imagezoom', BDTEP_URL . 'assets/vendor/js/jquery.imagezoom' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'datatables', BDTEP_URL . 'assets/vendor/js/datatables' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'typed', BDTEP_URL . 'assets/vendor/js/typed' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'timeline', BDTEP_URL . 'assets/vendor/js/timeline' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'popper', BDTEP_URL . 'assets/vendor/js/popper' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'tippyjs', BDTEP_URL . 'assets/vendor/js/tippy.all' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'tilt', BDTEP_URL . 'assets/vendor/js/tilt.jquery' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'rvslider', BDTEP_URL . 'assets/vendor/js/rvslider' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'spritespin', BDTEP_URL . 'assets/vendor/js/spritespin' . $suffix . '.js', ['jquery'], '4.0.5', true );

		wp_register_script( 'particles', BDTEP_URL . 'assets/vendor/js/particles' . $suffix . '.js', ['jquery'], '2.0.0', true );
		wp_register_script( 'recliner', BDTEP_URL . 'assets/vendor/js/recliner' . $suffix . '.js', ['jquery'], '0.2.2', true );

		if (!empty($settings['disqus_user_name'])) {
			wp_register_script( 'disqus', '//'.$settings['disqus_user_name'].'.disqus.com/count.js', ['jquery'], null, true );
		}
	}

	public function register_site_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_register_style( 'bdt-video-gallery', BDTEP_URL . 'assets/css/video-gallery' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'bdt-social-share', BDTEP_URL . 'assets/css/social-share' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'twentytwenty', BDTEP_URL . 'assets/css/twentytwenty.css', [], BDTEP_VER );
		wp_register_style( 'bdt-advanced-button', BDTEP_URL . 'assets/css/advanced-button' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'bdt-audio-player', BDTEP_URL . 'assets/css/audio-player' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'bdt-video-player', BDTEP_URL . 'assets/css/video-player' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'weather', BDTEP_URL . 'assets/css/weather' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'cookieconsent', BDTEP_URL . 'assets/css/cookieconsent' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'bdt-post-grid-tab', BDTEP_URL . 'assets/css/post-grid-tab' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'imagezoom', BDTEP_URL . 'assets/css/imagezoom' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'datatables', BDTEP_URL . 'assets/css/datatables' . $direction_suffix . '.css', [], BDTEP_VER );
		wp_register_style( 'bdt-gravity-form', BDTEP_URL . 'assets/css/gravity-form' . $direction_suffix . '.css', [], BDTEP_VER );

	}

	/**
	 * Loading site related style from here.
	 * @return [type] [description]
	 */
	public function enqueue_site_styles() {

		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_enqueue_style( 'element-pack-site', BDTEP_URL . 'assets/css/element-pack-site' . $direction_suffix . '.css', [], BDTEP_VER );		
	}


	/**
	 * Loading site related script that needs all time such as uikit.
	 * @return [type] [description]
	 */
	public function enqueue_site_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'bdt-uikit', BDTEP_URL . 'assets/js/bdt-uikit' . $suffix . '.js', ['jquery'], BDTEP_VER );
		wp_enqueue_script( 'element-pack-site', BDTEP_URL . 'assets/js/element-pack-site' . $suffix . '.js', ['jquery', 'elementor-frontend'], BDTEP_VER );

		$script_config = [ 
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'element-pack-site' ),
			'data_table' => [
				'language'    => [
			        'lengthMenu' => sprintf(esc_html_x('Show %1s Entries', 'DataTable String', 'bdthemes-element-pack'), '_MENU_' ),
			        'info'       => sprintf(esc_html_x('Showing %1s to %2s of %3s entries', 'DataTable String', 'bdthemes-element-pack'), '_START_', '_END_', '_TOTAL_' ),
			        'search'     => esc_html_x('Search :', 'DataTable String', 'bdthemes-element-pack'),
			        'paginate'   => [
			            'previous' => esc_html_x('Previous', 'DataTable String', 'bdthemes-element-pack'),
			            'next'     => esc_html_x('Next', 'DataTable String', 'bdthemes-element-pack'),
			        ],
				],
			],
			'contact_form' => [
				'sending_msg' => esc_html_x('Sending message please wait...', 'Contact Form String', 'bdthemes-element-pack'),
				'captcha_nd' => esc_html_x('Invisible captcha not defined!', 'Contact Form String', 'bdthemes-element-pack'),
				'captcha_nr' => esc_html_x('Could not get invisible captcha response!', 'Contact Form String', 'bdthemes-element-pack'),

			],
			'elements_data' => $this->elements_data,
		];


		// localize for user login widget ajax login script
	    wp_localize_script( 'bdt-uikit', 'element_pack_ajax_login_config', array( 
			'ajaxurl'        => admin_url( 'admin-ajax.php' ),
			'loadingmessage' => esc_html__('Sending user info, please wait...', 'bdthemes-element-pack'),
	    ));

	    $script_config = apply_filters( 'element_pack/frontend/localize_settings', $script_config );

	    // TODO for editor script
		wp_localize_script( 'bdt-uikit', 'ElementPackConfig', $script_config );

	}

	public function enqueue_editor_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'bdt-uikit', BDTEP_URL . 'assets/js/element-pack-editor' . $suffix . '.js', ['backbone-marionette', 'elementor-common-modules', 'elementor-editor-modules'], BDTEP_VER, true );

		$locale_settings = [
			'i18n' => [],
			'urls' => [
				'modules' => BDTEP_MODULES_URL,
			],
		];

		$locale_settings = apply_filters( 'element_pack/editor/localize_settings', $locale_settings );

		wp_localize_script(
			'bdt-uikit',
			'ElementPackConfig',
			$locale_settings
		);
	}

	/**
	 * Load editor editor related style from here
	 * @return [type] [description]
	 */
	public function enqueue_preview_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_enqueue_style('element-pack-preview', BDTEP_URL . 'assets/css/element-pack-preview' . $direction_suffix . '.css', '', BDTEP_VER );
	}


	public function enqueue_editor_styles() {
		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_enqueue_style('element-pack-editor', BDTEP_URL . 'assets/css/element-pack-editor' . $direction_suffix . '.css', '', BDTEP_VER );
	}


	/**
	 * Add element_pack_ajax_login() function with wp_ajax_nopriv_ function 
	 * @return [type] [description]
	 */
	public function element_pack_ajax_login_init() {
	    // Enable the user with no privileges to run element_pack_ajax_login() in AJAX
	    add_action( 'wp_ajax_nopriv_element_pack_ajax_login', [ $this, "element_pack_ajax_login"] );
	}

	/**
	 * For ajax login
	 * @return [type] [description]
	 */
	public function element_pack_ajax_login(){
	    // First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-login-nonce', 'security' );

	    // Nonce is checked, get the POST data and sign user on
		$access_info                  = [];
		$access_info['user_login']    = !empty($_POST['username'])?$_POST['username'] : "";
		$access_info['user_password'] = !empty($_POST['password'])?$_POST['password'] : "";
		$access_info['rememberme']    = true;
		$user_signon                  = wp_signon( $access_info, false );

	    if ( !is_wp_error($user_signon) ){
	        echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'bdthemes-element-pack')] );
	    } else {
	        echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Wrong username or password!', 'bdthemes-element-pack')] );
	    }

	    die();
	}


	public function element_pack_ajax_search() {
	    global $wp_query;

	    $result = array('results' => array());
	    $query  = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

	    if (strlen($query) >= 3) {

			$wp_query->query_vars['posts_per_page'] = 5;
			$wp_query->query_vars['post_status']    = 'publish';
			$wp_query->query_vars['s']              = $query;
			$wp_query->is_search                    = true;

	        foreach ($wp_query->get_posts() as $post) {

	            $content = !empty($post->post_excerpt) ? strip_tags(strip_shortcodes($post->post_excerpt)) : strip_tags(strip_shortcodes($post->post_content));

	            if (strlen($content) > 180) {
	                $content = substr($content, 0, 179).'...';
	            }

	            $result['results'][] = array(
	                'title' => $post->post_title,
	                'text'  => $content,
	                'url'   => get_permalink($post->ID)
	            );
	        }
	    }

	    die(json_encode($result));
	}




	/**
	 * initialize the category
	 * @return [type] [description]
	 */
	public function element_pack_init() {
		$this->_modules_manager = new Manager();

		$elementor = \Elementor\Plugin::$instance;

		// Add element category in panel
		$elementor->elements_manager->add_category( BDTEP_SLUG, [ 'title' => BDTEP_TITLE, 'icon'  => 'font' ], 1 );
		
		do_action( 'bdthemes_element_pack/init' );
	}

	private function setup_hooks() {
		add_action( 'elementor/init', [ $this, 'element_pack_init' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

		add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_site_styles' ] );
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_site_scripts' ] );

		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
		//add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] ); //TODO

		add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_site_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_site_scripts' ] );

		// TODO AJAX SEARCH
		// add_action('wp_ajax_element_pack_search', [ $this, 'element_pack_ajax_search' ] );
		// add_action('wp_ajax_nopriv_element_pack_search', [ $this, 'element_pack_ajax_search' ] );
		
		
		
		// When user not login add this action
		if (!is_user_logged_in()) {
			add_action('elementor/init', [ $this, 'element_pack_ajax_login_init'] );
		}
	}

	/**
	 * Element_Pack_Loader constructor.
	 */
	private function __construct() {
		// Register class automatically
		spl_autoload_register( [ $this, 'autoload' ] );
		// Include some backend files
		$this->_includes();
		// Finally hooked up all things here
		$this->setup_hooks();
	}
}

if ( ! defined( 'BDTEP_TESTS' ) ) {
	// In tests we run the instance manually.
	Element_Pack_Loader::instance();
}

// handy fundtion for push data
function element_pack_config() {
	return Element_Pack_Loader::instance();
}