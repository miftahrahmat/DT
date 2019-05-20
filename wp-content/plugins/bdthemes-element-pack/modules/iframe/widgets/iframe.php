<?php
namespace ElementPack\Modules\Iframe\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Iframe extends Widget_Base {

	public function get_name() {
		return 'bdt-iframe';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Iframe', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-iframe';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'iframe', 'embed' ];
	}

	public function get_script_depends() {
		return [ 'recliner' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'         => esc_html__( 'Content Source', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'dynamic'       => [ 'active' => true ],
				'default'       => [ 'url' => 'https://example.com' ],
				'placeholder'   => esc_html__( 'https://example.com', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'You can put here any website url, youtube, vimeo, document or image embed url', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'show_external' => false,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Iframe Height', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'min'   => 100,
						'max'   => 1500,
						'step' => 10,
					],
					'vw' => [
						'min'   => 1,
						'max'   => 100,
					],
					'%' => [
						'min'   => 1,
						'max'   => 100,
					],
				],
				'size_units' => [ 'px', 'vw', '%' ],
				'default' => [
					'size' => 640,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-iframe iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'auto_height!' => 'yes',
				],
			]
		);

		$this->add_control(
			'auto_height',
			[
				'label'   => esc_html__( 'Auto Height', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'Auto height only works when cross origin properly set', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_iframe_settings',
			[
				'label' => esc_html__( 'Lazyload Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'   => esc_html__( 'Lazyload', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'throttle',
			[
				'label'       => esc_html__('Throttle', 'bdthemes-element-pack'),
				'description' => esc_html__('millisecond interval at which to process events', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 300,
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->add_control(
			'threshold',
			[
				'label'       => esc_html__('Threshold', 'bdthemes-element-pack'),
				'description' => esc_html__('scroll distance from element before its loaded', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'before',
				'default'     => 100,
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->add_control(
			'live',
			[
				'label'       => esc_html__( 'Live', 'bdthemes-element-pack' ),
				'description' => esc_html__('auto bind lazy loading to ajax loaded elements', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
				'default'     => 'yes',
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'allowfullscreen',
			[
				'label'       => esc_html__( 'Allow Fullscreen', 'bdthemes-element-pack' ),
				'description' => esc_html__('Maybe you need this when you use youtube or video embed link.', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes'
			]
		);

		$this->add_control(
			'scrolling',
			[
				'label'       => esc_html__( 'Show Scroll Bar', 'bdthemes-element-pack' ),
				'description' => esc_html__('Specifies whether or not to display scrollbars', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sandbox',
			[
				'label'       => esc_html__( 'Sandbox', 'bdthemes-element-pack' ),
				'description' => esc_html__('Enables an extra set of restrictions for the content', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'sandbox_allowed_attributes',
			[
				'label'       => esc_html__('Sandbox Allowed Attributes', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options'     => [
					'allow-forms'          => esc_html__('Forms', 'bdthemes-element-pack'),
					'allow-pointer-lock'   => esc_html__('Pointer Lock', 'bdthemes-element-pack'),
					'allow-popups'         => esc_html__('Popups', 'bdthemes-element-pack'),
					'allow-same-origin'    => esc_html__('Same Origin', 'bdthemes-element-pack'),
					'allow-scripts'        => esc_html__('Scripts', 'bdthemes-element-pack'),
					'allow-top-navigation' => esc_html__('Top Navigation', 'bdthemes-element-pack')
				],
				'condition' => [
					'sandbox' => 'yes'
				]
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'iframe-container', 'class', 'bdt-iframe' );
		if ('yes' == $settings['lazyload']) {
			$this->add_render_attribute( 'iframe', 'class', 'bdt-lazyload' );
			$this->add_render_attribute( 'iframe', 'data-throttle', esc_attr($settings['throttle']) );
			$this->add_render_attribute( 'iframe', 'data-threshold', esc_attr($settings['threshold']) );
			$this->add_render_attribute( 'iframe', 'data-live', $settings['live'] ? 'true' : 'false' );
			$this->add_render_attribute( 'iframe', 'data-src', esc_url($settings['source']['url']) );
		} else {
			$this->add_render_attribute( 'iframe', 'src', esc_url($settings['source']['url']) );
		}

		if (! $settings['scrolling']) {
			$this->add_render_attribute( 'iframe', 'scrolling', 'no' );
		}

		$this->add_render_attribute( 'iframe', 'data-auto_height', ($settings['auto_height']) ? true : false );

		
		if ('yes' == $settings['allowfullscreen']) {
			$this->add_render_attribute( 'iframe', 'allowfullscreen' );
		} else {
			$this->add_render_attribute( 'iframe', 'donotallowfullscreen' );
		}

		if ($settings['sandbox']) {
			$this->add_render_attribute( 'iframe', 'sandbox' );

			if ($settings['sandbox_allowed_attributes']) {
				$this->add_render_attribute( 'iframe', 'sandbox', $settings['sandbox_allowed_attributes'] );
			}
		}

		?>
        <div <?php echo $this->get_render_attribute_string('iframe-container'); ?>>
        	<iframe <?php echo $this->get_render_attribute_string('iframe'); ?>></iframe>
        </div>
		<?php
	}
}
