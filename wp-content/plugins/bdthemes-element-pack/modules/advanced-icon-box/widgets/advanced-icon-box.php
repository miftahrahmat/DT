<?php
namespace ElementPack\Modules\AdvancedIconBox\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'bdt-advanced-icon-box';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Advanced Icon Box', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-advanced-icon-box';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'advanced', 'icon', 'features' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_icon_box',
			[
				'label' => __( 'Icon Box', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'        => esc_html__('Icon Type', 'bdthemes-element-pack'),
				'type'         => Controls_Manager::CHOOSE,
				'toggle'       => false,
				'default'      => 'icon',
				'prefix_class' => 'bdt-icon-type-',
				'render_type'  => 'template',
				'options'      => [
					'icon' => [
						'title' => esc_html__('Icon', 'bdthemes-element-pack'),
						'icon'  => 'fa fa-star'
					],
					'image' => [
						'title' => esc_html__('Image', 'bdthemes-element-pack'),
						'icon'  => 'fa fa-picture-o'
					]
				]
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => __( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'default'     => 'fa fa-star',
				'render_type' => 'template',
				'condition'   => [
					'icon_type' => 'icon',
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label'       => __( 'Image Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::MEDIA,
				'render_type' => 'template',
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image'
				]
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'   => __( 'Title & Description', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => __( 'Icon Box Heading', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Enter your title', 'bdthemes-element-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_link',
			[
				'label'        => __( 'Title Link', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-title-link-'
			]
		);

		$this->add_control(
			'title_link_url',
			[
				'label'       => __( 'Title Link URL', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'condition'   => [
					'title_link' => 'yes'
				]
			]
		);

		$this->add_control(
			'description_text',
			[
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default'     => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Enter your description', 'bdthemes-element-pack' ),
				'rows'        => 10,
				'separator'   => 'none',
				'show_label'  => false,
			]
		);

		$this->add_control(
			'position',
			[
				'label'     => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::CHOOSE,
				'separator' => 'before',
				'default'   => 'top',
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle'       => false,
				'condition'    => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_vertical_alignment',
			[
				'label'   => __( 'Icon Vertical Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top'   => [
						'title' => __( 'Top', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'      => 'top',
				'toggle'       => false,
				'prefix_class' => 'elementor-vertical-align-',
				'condition'    => [
					'position' => ['left', 'right']
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_readmore',
			[
				'label'     => __( 'Read More', 'bdthemes-element-pack' ),
				'condition' => [
					'readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => __( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Read More', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_link',
			[
				'label'     => __( 'Link to', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::URL,
				'separator' => 'before',
				'dynamic'   => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'bdthemes-element-pack' ),
				'default'     => [
					'url' => '#',
				],
				'condition' => [
					'readmore'       => 'yes',
					//'readmore_text!' => '',
				]
			]
		);

		$this->add_control(
			'onclick',
			[
				'label'     => esc_html__( 'OnClick', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'readmore'       => 'yes',
					//'readmore_text!' => '',
				]
			]
		);

		$this->add_control(
			'onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( esc_html__('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'readmore'       => 'yes',
					//'readmore_text!' => '',
					'onclick'        => 'yes'
				]
			]
		);

		$this->add_control(
			'readmore_icon',
			[
				'label'       => __( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'separator'   => 'before',
				'label_block' => true,
				'condition'   => [
					'readmore'       => 'yes'
				]
			]
		);

		$this->add_control(
			'readmore_icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'readmore_icon!' => '',
				],
			]
		);

		$this->add_control(
			'readmore_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 8,
				],
				'condition' => [
					'readmore_icon!' => '',
					'readmore_text!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'readmore_on_hover',
			[
				'label'        => __( 'Show on Hover', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-readmore-on-hover-',
			]
		);

		$this->add_responsive_control(
			'readmore_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => -50,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'condition' => [
					'readmore_on_hover' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'readmore_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.bdt-readmore-on-hover-yes .bdt-advanced-icon-box-readmore' => 'transform: translate({{readmore_horizontal_offset.SIZE}}%, {{SIZE}}%);',
					'(tablet){{WRAPPER}}.bdt-readmore-on-hover-yes .bdt-advanced-icon-box-readmore' => 'transform: translate({{readmore_horizontal_offset_tablet.SIZE}}%, {{SIZE}}%);',
					'(mobile){{WRAPPER}}.bdt-readmore-on-hover-yes .bdt-advanced-icon-box-readmore' => 'transform: translate({{readmore_horizontal_offset_mobile.SIZE}}%, {{SIZE}})%);',
				],
				'condition' => [
					'readmore_on_hover' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_indicator',
			[
				'label'     => __( 'Indicator', 'bdthemes-element-pack' ),
				'condition' => [
					'indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'indicator_width',
			[
				'label' => __( 'Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'step' => 2,
						'max'  => 300,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .bdt-indicator-svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'indicator_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'indicator_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'indicator_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .bdt-indicator-svg' => 'transform: translate({{indicator_horizontal_offset.SIZE}}px, {{indicator_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .bdt-indicator-svg' => 'transform: translate({{indicator_horizontal_offset_tablet.SIZE}}px, {{indicator_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .bdt-indicator-svg' => 'transform: translate({{indicator_horizontal_offset_mobile.SIZE}}px, {{indicator_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_badge',
			[
				'label'     => __( 'Badge', 'bdthemes-element-pack' ),
				'condition' => [
					'badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => __( 'Badge Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'POPULAR',
				'placeholder' => 'Type Badge Title',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'badge_position',
			[
				'label'   => esc_html__( 'Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top-right',
				'options' => element_pack_position(),
			]
		);

		$this->add_responsive_control(
			'badge_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'badge_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'badge_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .bdt-advanced-icon-box-badge' => 'transform: translate({{badge_horizontal_offset.SIZE}}px, {{badge_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .bdt-advanced-icon-box-badge' => 'transform: translate({{badge_horizontal_offset_tablet.SIZE}}px, {{badge_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .bdt-advanced-icon-box-badge' => 'transform: translate({{badge_horizontal_offset_mobile.SIZE}}px, {{badge_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional Options', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'top_icon_vertical_offset',
			[
				'label' => esc_html__('Icon Vertical Offset', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => [
					'position' => 'top',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-icon' => 'margin-top: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'top_icon_horizontal_offset',
			[
				'label' => esc_html__('Icon Horizontal Offset', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'position' => 'top',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-icon' => 'transform: translateX({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'left_icon_horizontal_offset',
			[
				'label' => esc_html__('Icon Horizontal Offset', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'position' => 'left',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-icon' => 'margin-left: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'right_icon_horizontal_offset',
			[
				'label' => esc_html__('Icon Horizontal Offset', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'position' => 'right',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-icon' => 'margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'left_right_icon_vertical_offset',
			[
				'label' => esc_html__('Icon Vertical Offset', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'condition' => [
					'position' => ['left', 'right'],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-icon' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'title_size',
			[
				'label'   => __( 'Title HTML Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'readmore',
			[
				'label'     => __( 'Read More Button', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'indicator',
			[
				'label' => __( 'Indicator', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'badge',
			[
				'label' => __( 'Badge', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'global_link',
			[
				'label'        => __( 'Global Link', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-global-link-',
				'description'  => __( 'Be aware! When Global Link activated then title link and read more link will not work', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'global_link_url',
			[
				'label'       => __( 'Global Link URL', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'condition'   => [
					'global_link' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon_box',
			[
				'label'      => __( 'Icon/Image', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'icon',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'image',
							'operator' => '!=',
							'value'    => ''
						],
					]
				]
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type!' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_background',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => esc_html__('Padding', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'placeholder' => '1px',
				'separator'   => 'before',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper'
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label'      => esc_html__('Radius', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
				'condition' => [
					'icon_radius_advanced_show!' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_radius_advanced_show',
			[
				'label' => __( 'Advanced Radius', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'icon_radius_advanced',
			[
				'label'       => esc_html__('Radius', 'bdthemes-element-pack'),
				'description' => sprintf(__('For example: <b>%1s</b> or Go <a href="%2s" target="_blank">this link</a> and copy and paste the radius value.', 'bdthemes-element-pack'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
				'type'        => Controls_Manager::TEXT,
				'size_units'  => [ 'px', '%' ],
				'separator'   => 'after',
				'default'     => '75% 25% 43% 57% / 46% 29% 71% 54%',
				'selectors'   => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper'     => 'border-radius: {{VALUE}}; overflow: hidden;',
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper img' => 'border-radius: {{VALUE}}; overflow: hidden;'
				],
				'condition' => [
					'icon_radius_advanced_show' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'icon_typography',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper',
				'condition' => [
					'icon_type!' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label'     => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .bdt-advanced-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .bdt-advanced-icon-box-icon'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .bdt-advanced-icon-box-icon'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .bdt-advanced-icon-box-icon'                  => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image_fullwidth!' => 'yes',
				],
			]
		);

		$this->add_control(
			'image_fullwidth',
			[
				'label' => __( 'Image Fullwidth', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'width: 100%;box-sizing: border-box;',
				],
				'condition' => [
					'icon_type' => 'image'
				]
			]
		);

		$this->add_control(
			'rotate',
			[
				'label'   => __( 'Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper i'   => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper img' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'icon_background_rotate',
			[
				'label'   => __( 'Background Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-icon-wrapper' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'image_icon_heading',
			[
				'label'     => __( 'Image Effect', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'css_filters',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box img',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box img' => 'transition-duration: {{SIZE}}s',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type!' => 'image',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_hover_background',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper:after',
			]
		);
		
		$this->add_control(
			'icon_effect',
			[
				'label'        => __( 'Effect', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SELECT,
				'prefix_class' => 'bdt-icon-effect-',
				'default'      => 'none',
				'options'      => [
					'none' => __( 'None', 'bdthemes-element-pack' ),
					'a'    => __( 'Effect A', 'bdthemes-element-pack' ),
					'b'    => __( 'Effect B', 'bdthemes-element-pack' ),
					'c'    => __( 'Effect C', 'bdthemes-element-pack' ),
					'd'    => __( 'Effect D', 'bdthemes-element-pack' ),
					'e'    => __( 'Effect E', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper'  => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'icon_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'icon_hover_radius',
			[
				'label'      => esc_html__('Radius', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper'
			]
		);

		$this->add_control(
			'icon_hover_rotate',
			[
				'label'   => __( 'Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper i'   => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper img' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'icon_hover_background_rotate',
			[
				'label'   => __( 'Background Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'image_icon_hover_heading',
			[
				'label'     => __( 'Image Effect', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'css_filters_hover',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper img',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => __( 'Opacity', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box:hover .bdt-icon-wrapper img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__('Padding', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box .bdt-advanced-icon-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label'     => __( 'Title', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-content .bdt-advanced-icon-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-content .bdt-advanced-icon-box-title',
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label'     => __( 'Description', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_bottom_space',
			[
				'label'     => esc_html__('Spacing', 'bdthemes-element-pack'),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-content .bdt-advanced-icon-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-content .bdt-advanced-icon-box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-content .bdt-advanced-icon-box-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => __( 'Read More', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'readmore'       => 'yes',
				],				
			]
		);

		$this->add_control(
			'readmore_attention',
			[
				'label' => __( 'Attention', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'readmore_background',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box-readmore', 
				'separator' => 'before', 
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'placeholder' => '1px',
				'separator'   => 'before',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-icon-box-readmore'
			]
		);

		$this->add_responsive_control(
			'readmore_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after', 
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_hover_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'readmore_hover_background',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box-readmore:hover',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-readmore:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'readmore_border_border!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-readmore:hover',
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => __( 'Hover Animation', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_indicator',
			[
				'label'     => __( 'Indicator', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'indicator' => 'yes',
				],
			]
		);

		$this->add_control(
			'indicator_style',
			[
				'label'   => __( 'Indicator Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'   => __( 'Style 1', 'bdthemes-element-pack' ),
					'2'   => __( 'Style 2', 'bdthemes-element-pack' ),
					'3'   => __( 'Style 3', 'bdthemes-element-pack' ),
					'4'   => __( 'Style 4', 'bdthemes-element-pack' ),
					'5'   => __( 'Style 5', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'indicator_fill_color',
			[
				'label'     => __( 'Fill Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-indicator-svg svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'indicator_stroke_color',
			[
				'label'     => __( 'Stroke Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-indicator-svg svg' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => __( 'Badge', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-icon-box-badge span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'badge_background',
				'selector'  => '{{WRAPPER}} .bdt-advanced-icon-box-badge span', 
				'separator' => 'before', 
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'placeholder' => '1px',
				'separator'   => 'before',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-icon-box-badge span'
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after', 
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box-badge span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-badge span',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-icon-box-badge span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .bdt-advanced-icon-box-badge span',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'icon', 'class', 'bdt-icon-wrapper' );

		$has_icon = ! empty( $settings['icon'] );

		$has_image = ! empty( $settings['image']['url'] );

		if ( $has_icon and 'icon' == $settings['icon_type'] ) {
			$this->add_render_attribute( 'i', 'class', $settings['icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );			
		} elseif ( $has_image and 'image' == $settings['icon_type'] ) {
			$this->add_render_attribute( 'img', 'src', $settings['image']['url'] );
			$this->add_render_attribute( 'img', 'alt', $settings['title_text'] );
		}

		$this->add_render_attribute( 'description_text', 'class', 'bdt-advanced-icon-box-description' );

		$this->add_inline_editing_attributes( 'title_text', 'none' );
		$this->add_inline_editing_attributes( 'description_text' );

		$this->add_render_attribute( 'readmore', 'class', ['bdt-advanced-icon-box-readmore', 'bdt-display-inline-block'] );
		
		if ( ! empty( $settings['readmore_link']['url'] ) ) {
			$this->add_render_attribute( 'readmore', 'href', $settings['readmore_link']['url'] );

			if ( $settings['readmore_link']['is_external'] ) {
				$this->add_render_attribute( 'readmore', 'target', '_blank' );
			}

			if ( $settings['readmore_link']['nofollow'] ) {
				$this->add_render_attribute( 'readmore', 'rel', 'nofollow' );
			}

		}

		if ($settings['readmore_attention']) {
			$this->add_render_attribute( 'readmore', 'class', 'bdt-ep-attention-button' );
		}		

		if ( $settings['readmore_hover_animation'] ) {
			$this->add_render_attribute( 'readmore', 'class', 'elementor-animation-' . $settings['readmore_hover_animation'] );
		}

		if ($settings['onclick']) {
			$this->add_render_attribute( 'readmore', 'onclick', $settings['onclick_event'] );
		}

		$this->add_render_attribute( 'advanced-icon-box-title', 'class', 'bdt-advanced-icon-box-title' );
		
		if ('yes' == $settings['title_link'] and $settings['title_link_url']['url']) {

			$target = $settings['title_link_url']['is_external'] ? '_blank' : '_self';

			$this->add_render_attribute( 'advanced-icon-box-title', 'onclick', "window.open('" . $settings['title_link_url']['url'] . "', '$target')" );
		}

		$this->add_render_attribute( 'advanced-icon-box', 'class', 'bdt-advanced-icon-box' );
		
		if ('yes' == $settings['global_link'] and $settings['global_link_url']['url']) {

			$target = $settings['global_link_url']['is_external'] ? '_blank' : '_self';

			$this->add_render_attribute( 'advanced-icon-box', 'onclick', "window.open('" . $settings['global_link_url']['url'] . "', '$target')" );
		}
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'advanced-icon-box' ); ?>>
			<?php if ( $has_icon or $has_image ) : ?>
				<div class="bdt-advanced-icon-box-icon">
					<span <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
						<?php if ( $has_icon and 'icon' == $settings['icon_type'] ) { ?>
							<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
						<?php } elseif ( $has_image and 'image' == $settings['icon_type'] ) { ?>
							<img <?php echo $this->get_render_attribute_string( 'img' ); ?>>
						<?php } ?>
					</span>
				</div>
			<?php endif; ?>

			<div class="bdt-advanced-icon-box-content">
				<?php if ( $settings['title_text'] ) : ?>
					<<?php echo $settings['title_size']; ?> <?php echo $this->get_render_attribute_string( 'advanced-icon-box-title' ); ?>>
						<span <?php echo $this->get_render_attribute_string( 'title_text' ); ?>>
							<?php echo $settings['title_text']; ?>
						</span>
					</<?php echo $settings['title_size']; ?>>
				<?php endif; ?>

				<?php if ( $settings['description_text'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?>>
						<?php echo $settings['description_text']; ?>
					</div>
				<?php endif; ?>

				<?php if ($settings['readmore']) : ?>
					<a <?php echo $this->get_render_attribute_string( 'readmore' ); ?>>
						<?php echo esc_html($settings['readmore_text']); ?>
						
						<?php if ($settings['readmore_icon']) : ?>
							<span class="bdt-button-icon-align-<?php echo esc_attr($settings['readmore_icon_align']); ?>">
								<i class="<?php echo esc_attr($settings['readmore_icon']); ?>"></i>
							</span>
						<?php endif; ?>
					</a>
				<?php endif ?>
			</div>
		</div>

		<?php if ( $settings['indicator'] ) : ?>
			<div class="bdt-indicator-svg bdt-svg-style-<?php echo esc_attr($settings['indicator_style']); ?>">
				<?php echo element_pack_svg_icon('arrow-' . $settings['indicator_style']); ?>
			</div>
		<?php endif; ?>

		<?php if ( $settings['badge'] and '' != $settings['badge_text'] ) : ?>
			<div class="bdt-advanced-icon-box-badge bdt-position-<?php echo esc_attr($settings['badge_position']); ?>">
				<span class="bdt-badge bdt-padding-small"><?php echo esc_html($settings['badge_text']); ?></span>
			</div>
		<?php endif; ?>

		<?php
	}

	protected function _content_template() {
		?>
		<#
		view.addRenderAttribute( 'description_text', 'class', 'bdt-advanced-icon-box-description' );

		view.addInlineEditingAttributes( 'title_text', 'none' );
		view.addInlineEditingAttributes( 'description_text' );

		view.addRenderAttribute( 'advanced-icon-box-title', 'class', 'bdt-advanced-icon-box-title' );
		view.addRenderAttribute( 'advanced-icon-box', 'class', 'bdt-advanced-icon-box' );

		#>

		<div {{{ view.getRenderAttributeString( 'advanced-icon-box' ) }}}>
			
			<div class="bdt-advanced-icon-box-icon">
				<# if (( settings.image.url && settings.icon_type == 'image' ) || ( settings.icon  && settings.icon_type == 'icon' )) { #>
					<span class="bdt-icon-wrapper">
						<# if ( settings.image.url && settings.icon_type == 'image' ) { #>
							<img src="{{{settings.image.url}}}" alt="{{{ settings.title_text }}}">
						<# } else if ( settings.icon  && settings.icon_type == 'icon' ) { #>
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						<# } #>
					</span>
				<# } #>
			</div>
			
			<div class="bdt-advanced-icon-box-content">
				<{{{ settings.title_size }}} {{{ view.getRenderAttributeString( 'advanced-icon-box-title' ) }}}>
					<span {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</span>
				</{{{ settings.title_size }}}>
				<div {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</div>

				<#
				var animation = (settings.readmore_hover_animation) ? ' elementor-animation-' + settings.readmore_hover_animation : '';
				var attention = (settings.attention_button) ? ' bdt-ep-attention-button' : '';
				var onclick = view.addRenderAttribute( 'button', 'onclick', settings.onclick_event );
				#>

				<# if ( settings.readmore == 'yes' ) { #>
					<a class="bdt-advanced-icon-box-readmore {{animation}}{{attention}}" href="{{ settings.readmore_link.url }}" {{onclick}}>
						{{{ settings.readmore_text }}}

						<# if ( settings.readmore_icon ) { #>
							<span class="bdt-button-icon-align-{{ settings.readmore_icon_align }}">
								<i class="{{ settings.readmore_icon }}" aria-hidden="true"></i>
							</span>
						<# } #>
					</a>
				<# } #>
			</div>
		</div>

		<# if ( settings.indicator === 'yes' ) { #>
			<div class="bdt-indicator-svg bdt-svg-style-{{{settings.indicator_style}}}">
				<# if (settings.indicator_style == '1') { #>
				        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M145.2,26.8c0.3,5.3,0.7,10.5,1.1,15.8c-10.5-10.1-19.1-22.4-31-30.9C104.7,4.1,91.9,0.9,79,1.4C48.2,2.5,22.3,22.7,0.4,42.5c-0.8,0.7,0.2,2,1.1,1.3c23.4-18.3,47.6-39.2,79-39.8c13.4-0.2,26,3.8,36.5,12.2c10,8.1,17.7,18.5,26.8,27.5C137,42,130.5,40,124,37.8c-1.1-0.4-1.7,1.2-0.6,1.7c7.8,3.4,15.9,5.9,24.2,7.9c0.1,0,0.1,0,0.2,0c0.1,0.1,0.2,0.2,0.2,0.2c1.3,1.2,2.9-1.1,1.6-2.2c-0.1-0.1-0.2-0.2-0.3-0.2c-0.4-6.3-0.8-12.6-1.4-18.9C147.7,24.6,145.1,25,145.2,26.8z"/></svg>
				<# } else if (settings.indicator_style == '2') { #>
				        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M137,10.3c2.7,5.7,4.5,12.2,6.5,18.2c0.4,1.3-1,2.6-2.2,2.2c-6.7-2.3-13.5-4.5-20.3-6.8c-1.8-0.6-1.1-3.4,0.7-2.8c3.2,0.9,6.5,1.9,9.7,2.9c0-0.1-0.1-0.1-0.1-0.2c-3.7-6.4-13.1-18.6-20.2-7.5c-2.3,3.7-2.6,8.7-3.8,12.8c-1.5,5-4.3,9.8-10,10.3c-6.2,0.5-10.7-4.9-13.6-9.6c-2.6-4.4-4.6-9.3-6.8-13.9c-0.7-1.6-1.5-3.2-2.3-4.8c-2.8-4.2-6.4-4.2-8.5-4.1c-4.3,0.2-8.4,5.4-10.7,8.6c-6.2,8.6-9.8,41.1-27.6,32.9C12.2,41.2,6.5,16.6,7.9,1.1c0.1-1.2,1.9-1.2,1.9,0c-0.1,11.7,2.5,23.1,8.8,33c3.8,6.1,9.8,14,18.2,11c5.3-1.9,7.1-11.7,8.6-16.3c3.1-9.7,16.7-35.6,30.3-23c6.8,6.4,7.8,17.8,13.8,25c11.8,14.2,14.5-6.5,17.4-13.9c2.1-5.2,5.9-9.1,11.9-8.7c7.9,0.4,12.6,7.3,15.8,13.7c0.6,1.1-0.1,2.1-1,2.5c1.8,0.5,3.6,1.1,5.3,1.6c-1.9-4.8-3.8-9.6-5-14.5C133.4,9.7,136.2,8.4,137,10.3z"/></svg>
				<# } else if (settings.indicator_style == '3') { #>
				        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M4.3,12.3c2.9,6.7,5.6,14.2,11.3,19.2c9.3,8.1,20.4,2,29-3.8c12.7-8.5,23.8-20,39-24c26.5-7.1,55,9.2,61.4,35.8c0.7-3.1,1.2-6.2,1.7-9.4c0.2-1.2,2-0.9,2.1,0.3c0.2,5.5-1.1,11.2-2.4,16.5c-0.3,1.2-2,1.7-2.8,0.7c-4-4.8-8.4-9.2-12.4-14c-1.4-1.7,0.7-3.7,2.4-2.4c3.6,2.8,6.8,6.5,9.7,10.3c-5.2-16.6-17.2-30.3-34.7-34.5c-19-4.6-34.8,3.5-49.5,14.7C49.1,29.1,35.7,41.7,22.2,39C10.7,36.7,4.3,23.8,1.4,13.5C0.9,11.9,3.5,10.6,4.3,12.3z"/></svg>
				<# } else if (settings.indicator_style == '4') { #>
				        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M128,27.9c-1.2,6.2-1.9,11.7-4.4,17.3c-0.6-0.7-1.1-1.4-1.7-2.1c2.6-21.9-14.6-42.5-37.3-40.7c-2.1,0.2-4.4,0.7-6.6,1.4C67-1.4,52.2-1,41.8,3.5c-9.7,4.3-17.6,12.1-22,21.8c-3.5,7.6-6.2,18.8,1.7,24.5c1,0.7,2.2-0.6,1.3-1.4c-10.1-8,0.1-25.4,6.5-32.4C36,8.7,45.3,4.1,55.2,3.1c6.1-0.6,12.7,0.1,18.5,2.5C61.2,11.5,51,25,61.5,37.7c12.3,14.9,33.9,1.1,30.4-16.3c-1.4-6.7-5.1-11.7-10.1-15.2c1.6-0.3,3.2-0.4,4.7-0.5c19.2-0.4,32.2,15.8,32.3,33.8c-2.8-3.4-5.6-6.8-8.5-10c-0.8-0.9-2.3,0.4-1.6,1.4c3.2,4.5,6.6,8.8,10,13.2c0.1,0.5,0.4,0.9,0.8,1.1c1,1.3,2,2.6,3,3.9c0.7,1,2.1,1,2.8-0.1c3.4-6,6.2-13.7,5.2-20.7C130.3,26.8,128.3,26.4,128,27.9z M80.1,39.5c-14.7,5.8-24.2-11.8-15.8-23.1c3.2-4.3,7.9-7.4,13-9.1c2.1,1.2,4,2.6,5.8,4.4C90.9,19.5,91.9,34.9,80.1,39.5z"/></svg>
				<# } else if (settings.indicator_style == '5') { #>
				        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><g><path class="st0" d="M5.7,40.9c-0.8-0.1-1.5,0.5-1.5,1.3c-0.1,0.8,0.5,1.5,1.3,1.5C6.3,43.8,7,43.2,7,42.5    C7.1,41.7,6.5,41,5.7,40.9z"/><circle class="st0" cx="10.4" cy="36.6" r="1.7"/><path class="st0" d="M15.8,29c-1.1-0.1-2,0.7-2.1,1.8c-0.1,1.1,0.7,2,1.8,2.1c1.1,0.1,2-0.7,2.1-1.8S16.8,29,15.8,29z"/><path class="st0" d="M21.8,22.9c-1.1-0.1-2.1,0.8-2.2,1.9c-0.1,1.1,0.8,2.1,1.9,2.2c1.1,0.1,2.1-0.8,2.2-1.9    C23.8,24,22.9,23,21.8,22.9z"/><circle class="st0" cx="28.3" cy="19.9" r="2"/><path class="st0" d="M36.2,12.7c-1.1-0.1-2.1,0.8-2.2,1.9c-0.1,1.1,0.8,2.1,1.9,2.2c1.1,0.1,2.1-0.8,2.2-1.9    C38.2,13.7,37.4,12.8,36.2,12.7z"/><path class="st0" d="M55.4,5.8c-1.2-0.1-2.2,0.8-2.3,2c-0.1,1.2,0.8,2.2,2,2.3c1.2,0.1,2.2-0.8,2.3-2C57.5,6.9,56.6,5.8,55.4,5.8z"    /><path class="st0" d="M45.5,8.8c-1.2-0.1-2.3,0.8-2.3,2c-0.1,1.2,0.8,2.3,2,2.3c1.2,0.1,2.3-0.8,2.3-2C47.6,9.9,46.7,8.9,45.5,8.8z"    /><circle class="st0" cx="65.9" cy="6" r="2.4"/><circle class="st0" cx="76.8" cy="4.8" r="2.4"/><circle class="st0" cx="88.7" cy="6.1" r="2.4"/><circle class="st0" cx="99.9" cy="9.4" r="2.4"/><circle class="st0" cx="109.7" cy="13.4" r="2.4"/><circle class="st0" cx="119.6" cy="19.1" r="2.4"/><circle class="st0" cx="128.5" cy="25.6" r="2.4"/><circle class="st0" cx="135.3" cy="32.5" r="2.4"/><circle class="st0" cx="142.6" cy="41.8" r="2.4"/><circle class="st0" cx="143.1" cy="34.7" r="2.4"/><circle class="st0" cx="143.6" cy="27.9" r="2.4"/><circle class="st0" cx="144.1" cy="21" r="2.4"/><circle class="st0" cx="120.9" cy="40.3" r="2.4"/><circle class="st0" cx="127.8" cy="40.8" r="2.4"/><circle class="st0" cx="134.6" cy="41.3" r="2.4"/></g></svg>
				<# } #>

			</div>
		<# } #>

		<# if ( settings.badge && settings.badge_text != '' ) { #>
			<div class="bdt-advanced-icon-box-badge bdt-position-{{{settings.badge_position}}}">
				<span class="bdt-badge bdt-padding-small">{{{settings.badge_text}}}</span>
			</div>
		<# } #>

		<?php
	}
}
