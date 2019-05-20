<?php
namespace Auxin\Plugin\CoreElements\Elementor\Modules;

use Elementor\Plugin;

class Templates_Types_Manager {
	private $docs_types = [];

	public function __construct() {
		if( ! defined( 'ELEMENTOR_PRO_VERSION' ) ){
			define( 'AUXIN_ELEMENTOR_TEMPLATE', true );
			add_action( 'elementor/documents/register', [ $this, 'register_documents' ] );
		}
	}

	public function register_documents() {
		$this->docs_types = [
			'header' => Documents\Header::get_class_full_name(),
			'footer' => Documents\Footer::get_class_full_name()
		];

		foreach ( $this->docs_types as $type => $class_name ) {
			Plugin::$instance->documents->register_document_type( $type, $class_name );
		}
	}
}