<?php
namespace ElementPack\Modules\Mailchimp;

use ElementPack\Base\Element_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

	public function __construct() {
		parent::__construct();

		add_action('wp_ajax_element_pack_mailchimp_subscribe', [$this, 'mailchimp_subscribe']);
		add_action('wp_ajax_nopriv_element_pack_mailchimp_subscribe', [$this, 'mailchimp_subscribe']);
	}

	public function get_name() {
		return 'mailchimp';
	}

	public function get_widgets() {

		$widgets = ['Mailchimp'];

		return $widgets;
	}


	public function mailchimp_subscribe(){
	    
	    $result  = json_decode( element_pack_mailchimp_subscriber_status($_POST['email'], 'subscribed' ) );

	    if( $result->status == 400 ){
	        echo '<div class="bdt-text-warning">' . esc_html__( 'Ops, You provide wrong email address!', 'bdthemes-element-pack' ) . '</div>';
	    } elseif( $result->status == 'subscribed' ){
	        echo '<span bdt-icon="icon: check" class="bdt-icon"></span> ' . esc_html__( "Thank you, You have subscribed successfully", 'bdthemes-element-pack' );
	    } else {
            echo '<div class="bdt-text-danger">' . esc_html__( 'Error: You did not set the API keys or List ID in admin settings!', 'bdthemes-element-pack' ) . '</div>';
	    }
	    die;
	}

	
}
