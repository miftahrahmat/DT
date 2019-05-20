<?php
namespace ElementPack\Modules\ImageCompare\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Image_Compare extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'bdt-image-compare';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Image Compare', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-image-compare';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'image', 'compare', 'comparison', 'difference' ];
	}

	public function get_style_depends() {
		return [ 'twentytwenty' ];
	}

	public function get_script_depends() {
		return [ 'eventmove', 'twentytwenty' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'before_image',
			[
				'label'   => esc_html__( 'Before Image', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Use same size image for before and after for better preview.', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => BDTEP_ASSETS_URL.'images/before.svg',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'after_image',
			[
				'label'   => esc_html__( 'After Image', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Use same size image for before and after for better preview.', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => BDTEP_ASSETS_URL.'images/after.svg',
				],
				'dynamic' => [ 'active' => true ],
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => __( 'Image Size', 'bdthemes-element-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'full',
			]
		);

		$this->add_control(
			'before_label',
			[
				'label'       => esc_html__( 'Before Label', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Before Label', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'Before', 'bdthemes-element-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'after_label',
			[
				'label'       => esc_html__( 'After Label', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'After Label', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'After', 'bdthemes-element-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional_settings',
			[
				'label' => esc_html__( 'Additional', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'orientation',
			[
				'label'   => esc_html__( 'Orientation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'bdthemes-element-pack' ),
					'vertical'   => esc_html__( 'Vertical', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'default_offset_pct',
			[
				'label'   => esc_html__( 'Before Image Visiblity', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.7,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.1,
						'step' => 0.1,
					],
				],
			]
		);

		$this->add_control(
			'no_overlay',
			[
				'label'       => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Do not show the overlay with before and after.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'move_slider_on_hover',
			[
				'label'       => esc_html__( 'Slide on Hover', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Move slider on mouse hover?', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'move_with_handle_only',
			[
				'label'       => esc_html__( 'Handle Only', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Allow a user to swipe anywhere on the image to control slider movement.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'click_to_move',
			[
				'label'       => esc_html__( 'Click to Move', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Allow a user to click (or tap) anywhere on the image to move the slider to that location.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_style',
			[
				'label' => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_image_compare_style' );

		$this->start_controls_tab(
			'tab_image_compare_before_style',
			[
				'label' => esc_html__( 'Before', 'bdthemes-element-pack' ),
			]
		);
		
		$this->add_control(
			'before_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-before-label:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'before_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-before-label:before' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();



		$this->start_controls_tab(
			'tab_image_compare_after_style',
			[
				'label' => esc_html__( 'After', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'after_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-after-label:before' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'after_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-after-label:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_image_compare_bar_style',
			[
				'label' => esc_html__( 'Bar', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label'     => esc_html__( 'Bar Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-handle' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-handle:before' => 'background-color: {{VALUE}}; box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-handle:after' => 'background-color: {{VALUE}}; box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-handle span.twentytwenty-left-arrow' => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-handle span.twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_responsive_control(
			'after_before_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-before-label:before, {{WRAPPER}} .bdt-image-compare .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'after_before_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-image-compare .twentytwenty-before-label:before, {{WRAPPER}} .bdt-image-compare .twentytwenty-after-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'after_before_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-image-compare .twentytwenty-before-label:before, {{WRAPPER}} .bdt-image-compare .twentytwenty-after-label:before',
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings     = $this->get_settings();

		$this->add_render_attribute(
			[
				'image-compare' => [
					'class'                      => [ 'twentytwenty-container' ],
					'data-default_offset_pct'    => $settings['default_offset_pct']['size'],
					'data-orientation'           => $settings['orientation'],
					'data-before_label'          => $settings['before_label'],
					'data-after_label'           => $settings['after_label'],
					'data-no_overlay'            => ('yes' == $settings['no_overlay']) ? 'false' : 'true', 
					'data-move_slider_on_hover'  => ('yes' == $settings['move_slider_on_hover']) ? 'true' : 'false',
					'data-move_with_handle_only' => ('yes' == $settings['move_with_handle_only']) ? 'true' : 'false',
					'data-click_to_move'         => ('yes' == $settings['click_to_move']) ? 'true' : 'false',
				]
			]
		);

		?>
		<div class="bdt-image-compare bdt-position-relative">
			<div <?php echo $this->get_render_attribute_string( 'image-compare' ); ?>>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size', 'before_image' ); ?>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size', 'after_image' ); ?>
			</div>
		</div>

		<?php
	}
}
