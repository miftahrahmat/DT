<?php
namespace ElementPack;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists('is_plugin_active')) { include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

final class Manager {
	private $_modules = [];

	private function is_module_active( $module_id ) {

		$module_data = $this->get_module_data( $module_id );
		$options     = get_option( 'element_pack_active_modules', [] );
		
		if ( ! isset( $options[ $module_id ] ) ) {
			return $module_data['default_activation'];
		} else {
			if($options[ $module_id ] == "on"){
				return true;
			} else {
				return false;
			}
		}

		return 'true' === $options[ $module_id ];
	}

	private function get_module_data( $module_id ) {
		return isset( $this->_modules[ $module_id ] ) ? $this->_modules[ $module_id ] : false;
	}

	public function __construct() {
		$modules = [
			'query-control',
			//all widgets here
			'audio-player',
			'accordion',
			'business-hours',
			'advanced-button',
			'animated-heading',
			'advanced-heading',
			'advanced-icon-box',
			'advanced-gmap',
			'advanced-image-gallery',
			'chart',
			'call-out',
			'carousel',
			'countdown',
			'contact-form',
			'comment',
			'custom-gallery',
			'custom-carousel',
			'circle-menu',
			'cookie-consent',
			'dual-button',
			'device-slider',
			'document-viewer',
			'dropbar',
			'flip-box',
			'helpdesk',
			'image-compare',
			'image-magnifier',
			'instagram',
			'iconnav',
			'iframe',
			'marker',
			'member',
			'mailchimp',
			'modal',
			'navbar',
			'news-ticker',
			'lightbox',
			'offcanvas',
			'open-street-map',
			'panel-slider',
			'post-card',
			'post-block',
			'single-post',
			'post-grid',
			'post-grid-tab',
			'post-block-modern',
			'post-gallery',
			'post-slider',
			'price-list',
			'price-table',
			'progress-pie',
			'post-list',
			'protected-content',
			'qrcode',
			'scrollnav',
			'search',
			'slider',
			'slideshow',
			'social-share',
			'scroll-image',
			'scroll-button',
			'switcher',
			'tabs',
			'timeline',
			'table',
			'table-of-content',
			'toggle',
			'trailer-box',
			'thumb-gallery',
			'threesixty-product-viewer',
			'user-login',
			'user-register',
			'video-player',
			'elementor',
			'twitter-slider',
			'twitter-carousel',
			'video-gallery',
			'weather',
		];

		$faq              = element_pack_option('faq', 'element_pack_third_party_widget', 'on' );
		$cf_seven         = element_pack_option('contact-form-seven', 'element_pack_third_party_widget', 'on' );
		$rev_slider       = element_pack_option('revolution-slider', 'element_pack_third_party_widget', 'on' );
		$instagram_feed   = element_pack_option('instagram-feed', 'element_pack_third_party_widget', 'on' );
		$wp_forms         = element_pack_option('wp-forms', 'element_pack_third_party_widget', 'on' );
		$mailchimp_for_wp = element_pack_option('mailchimp-for-wp', 'element_pack_third_party_widget', 'on' );
		$tm_grid          = element_pack_option('testimonial-grid', 'element_pack_third_party_widget', 'on' );
		$tm_carousel      = element_pack_option('testimonial-carousel', 'element_pack_third_party_widget', 'on' );
		$tm_slider        = element_pack_option('testimonial-slider', 'element_pack_third_party_widget', 'on' );
		$woocommerce      = element_pack_option('woocommerce', 'element_pack_third_party_widget', 'on' );
		$booked_calendar  = element_pack_option('booked-calendar', 'element_pack_third_party_widget', 'on' );
		$bbpress          = element_pack_option('bbpress', 'element_pack_third_party_widget', 'on' );
		$layerslider      = element_pack_option('layerslider', 'element_pack_third_party_widget', 'on' );
		$downloadmonitor  = element_pack_option('download-monitor', 'element_pack_third_party_widget', 'on' );
		$quform           = element_pack_option('quform', 'element_pack_third_party_widget', 'on' );
		$ninja_forms      = element_pack_option('ninja-forms', 'element_pack_third_party_widget', 'on' );
		$caldera_forms    = element_pack_option('caldera-forms', 'element_pack_third_party_widget', 'on' );
		$gravity_forms    = element_pack_option('gravity-forms', 'element_pack_third_party_widget', 'on' );
		$buddypress       = element_pack_option('buddypress', 'element_pack_third_party_widget', 'on' );
		$ed_downloads     = element_pack_option('easy-digital-downloads', 'element_pack_third_party_widget', 'on' );
		$tablepress       = element_pack_option('tablepress', 'element_pack_third_party_widget', 'on' );

		if( is_plugin_active('contact-form-7/wp-contact-form-7.php') and 'on' === $cf_seven ) {
			$modules[] = 'contact-form-seven';
		}

		if( is_plugin_active( 'bdthemes-faq/bdthemes-faq.php' ) and 'on' === $faq ) {
			$modules[] = 'faq';
		}
		if( is_plugin_active('revslider/revslider.php') and 'on' === $rev_slider ) {
			$modules[] = 'revolution-slider';
		}
		if( is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') and 'on' === $mailchimp_for_wp ) {
			$modules[] = 'mailchimp-for-wp';
		}
		if( is_plugin_active('instagram-feed/instagram-feed.php') and 'on' === $instagram_feed) {
			$modules[] = 'instagram-feed';
		}

		if( is_plugin_active('woocommerce/woocommerce.php') and 'on' === $woocommerce ) {
			$modules[] = 'woocommerce';
		}
		if( is_plugin_active('booked/booked.php') and 'on' === $booked_calendar ) {
			$modules[] = 'booked-calendar';
		}
		if( is_plugin_active('bbpress/bbpress.php') and 'on' === $bbpress ) {
			$modules[] = 'bbpress';
		}
		if( is_plugin_active('LayerSlider/layerslider.php') and 'on' === $layerslider ) {
			$modules[] = 'layer-slider';
		}
		if( is_plugin_active('download-monitor/download-monitor.php') and 'on' === $downloadmonitor ) {
			$modules[] = 'download-monitor';
		}
		if( is_plugin_active('quform/quform.php') and 'on' === $quform ) {
			$modules[] = 'quform';
		}
		if( is_plugin_active('ninja-forms/ninja-forms.php') and 'on' === $ninja_forms ) {
			$modules[] = 'ninja-forms';
		}
		if( is_plugin_active('caldera-forms/caldera-core.php') and 'on' === $caldera_forms ) {
			$modules[] = 'caldera-forms';
		}
		if( is_plugin_active('gravityforms/gravityforms.php') and 'on' === $gravity_forms ) {
			$modules[] = 'gravity-forms';
		}
		if( is_plugin_active('buddypress/bp-loader.php') and 'on' === $buddypress ) {
			$modules[] = 'buddypress';
		}
		if( is_plugin_active('easy-digital-downloads/easy-digital-downloads.php') and 'on' === $ed_downloads ) {
			$modules[] = 'easy-digital-downloads';
		}
		if( is_plugin_active('tablepress/tablepress.php') and 'on' === $tablepress ) {
			$modules[] = 'tablepress';
		}
        if( is_plugin_active( 'bdthemes-testimonials/bdthemes-testimonials.php' ) and 'on' === $tm_carousel ) {
            $modules[] = 'testimonial-carousel';
        }
        if( is_plugin_active( 'bdthemes-testimonials/bdthemes-testimonials.php' ) and 'on' === $tm_grid ) {
            $modules[] = 'testimonial-grid';
        }
        if( is_plugin_active( 'bdthemes-testimonials/bdthemes-testimonials.php' ) and 'on' === $tm_slider ) {
            $modules[] = 'testimonial-slider';
        }
        if( ( is_plugin_active('wpforms-lite/wpforms.php') or is_plugin_active('wpforms/wpforms.php') ) and 'on' === $wp_forms ) {
            $modules[] = 'wp-forms';
        }

		// Fetch all modules data
		foreach ( $modules as $module ) {
			$this->_modules[ $module ] = require BDTEP_MODULES_PATH . $module . '/module.info.php';
		}

		foreach ( $this->_modules as $module_id => $module_data ) {
			if ( ! $this->is_module_active( $module_id ) ) {
				continue;
			}

			$class_name = str_replace( '-', ' ', $module_id );
			$class_name = str_replace( ' ', '', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

			$class_name::instance();

			// error_log( $class_name );
			// error_log(	ep_memory_usage_check() );
		}
	}

}
