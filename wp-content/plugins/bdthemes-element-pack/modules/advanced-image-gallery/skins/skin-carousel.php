<?php
namespace ElementPack\Modules\AdvancedImageGallery\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Carousel extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-carousel';
	}

	public function get_title() {
		return __( 'Carousel', 'bdthemes-element-pack' );
	}

	public function render_header() {

		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		$this->parent->add_render_attribute('advanced-image-gallery', 'id', 'bdt-avdg-' . esc_attr($id) );
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', ['bdt-advanced-image-gallery', 'bdt-skin-carousel'] );
		$this->parent->add_render_attribute('advanced-image-gallery', 'bdt-grid', '');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', ['bdt-grid', 'bdt-grid-small'] );
		
		if ($settings['masonry']) {
			$this->parent->add_render_attribute('advanced-image-gallery', 'bdt-grid', 'masonry: true');
		}
		if ($settings['show_lightbox']) {
			$this->parent->add_render_attribute('advanced-image-gallery', 'bdt-lightbox', 'animation: slide');
		}

		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'bdt-slider-items');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns_mobile']));
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns_tablet']) .'@s');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns']) .'@m');

		$this->parent->add_render_attribute(
			[
				'slider-settings' => [
					'class' => [
						( 'both' == $settings['navigation'] ) ? 'bdt-arrows-dots-align-' . $settings['both_position'] : '',
						( 'arrows' == $settings['navigation'] or 'arrows-thumbnavs' == $settings['navigation'] ) ? 'bdt-arrows-align-' . $settings['arrows_position'] : '',
						( 'dots' == $settings['navigation'] ) ? 'bdt-dots-align-'. $settings['dots_position'] : '',
					],
					'bdt-slider' => [
						wp_json_encode(array_filter([
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"finite"            => $settings["loop"] ? false : true,
							"pause-on-hover"    => $settings["pause_on_hover"] ? true : false,
							"center"            => $settings["center_slide"] ? true : false
						]))
					]
				]
			]
		);

		?>
		<div <?php echo ( $this->parent->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
		<?php
	}

	public function render_footer($settings) {

		?>
		</div>
		<?php if ('both' == $settings['navigation']) : ?>
			<?php $this->render_both_navigation($settings); ?>

			<?php if ( 'center' === $settings['both_position'] ) : ?>
				<?php $this->render_dotnavs($settings); ?>
			<?php endif; ?>

		<?php elseif ('arrows' == $settings['navigation']) : ?>
			<?php $this->render_navigation($settings); ?>
		<?php elseif ('dots' == $settings['navigation']) : ?>
			<?php $this->render_dotnavs($settings); ?>
		<?php endif; ?>
	</div>
	<?php
	}

	public function render_navigation($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$arrows_position = 'center';
		} else {
			$arrows_position = $settings['arrows_position'];
		}

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($arrows_position); ?>">
			<div class="bdt-arrows-container bdt-slidenav-container">
				<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slider-item="previous"></a>
				<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slider-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$dots_position = 'bottom-center';
		} else {
			$dots_position = $settings['dots_position'];
		}

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($dots_position); ?>">
			<div class="bdt-dotnav-wrapper bdt-dots-container">
				<ul class="bdt-dotnav bdt-flex-center">

				    <?php		
					$bdt_counter = 0;

					foreach ( $settings['avd_gallery_images'] as $index => $item ) :
					      
						echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item="' . esc_attr($bdt_counter) . '"><a href="#"></a></li>';
						$bdt_counter++;

					endforeach; ?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation($settings) {
		?>
		<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div>
						<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slider-item="previous"></a>						
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="bdt-dotnav-wrapper bdt-dots-container">
							<ul class="bdt-dotnav">
							    <?php		
								$bdt_counter = 0;

								foreach ( $settings['avd_gallery_images'] as $index => $item ) :								      
									echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item="' . esc_attr($bdt_counter) . '"><a href="#"></a></li>';
									$bdt_counter++;
								endforeach; ?>

							</ul>
						</div>
					<?php endif; ?>
					
					<div>
						<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slider-item="next"></a>						
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render_loop_item($settings) {

		$this->parent->add_render_attribute('advanced-image-gallery-item', 'class', ['bdt-gallery-item', 'bdt-transition-toggle']);

		$this->parent->add_render_attribute('advanced-image-gallery-inner', 'class', 'bdt-advanced-image-gallery-inner');
		
		if ($settings['tilt_show']) {
			$this->parent->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
		}

		foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>
				
			<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery-item' ); ?>>
				<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery-inner' ); ?>>
					<?php
					$this->parent->render_thumbnail($item);
					if ($settings['show_lightbox'] or $settings['show_caption'] )  :
						$this->parent->render_overlay($item);
					endif;
					?>
				</div>

				<?php if ($settings['show_caption'] and 'yes' == $settings['caption_all_time'])  : ?>
					<?php $this->parent->render_caption($item); ?>
				<?php endif; ?>
			</div>

		<?php endforeach;
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->render_header();
		$this->render_loop_item($settings);
		$this->render_footer($settings);
	}
}

