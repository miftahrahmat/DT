<?php
namespace ElementPack\Modules\PriceTable\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;

use ElementPack\Modules\PriceTable\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_Table extends Widget_Base {

	public function get_name() {
		return 'bdt-price-table';
	}

	public function get_title() {
		return BDTEP . __( 'Price Table', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-pricing-table';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'price', 'table', 'rate', 'cost', 'value' ];
	}

	public function get_script_depends() {
		return [ 'popper', 'tippyjs' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Partait( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Default', 'bdthemes-element-pack' ),
					'2' => __( 'Two (Features and Price interchange)', 'bdthemes-element-pack' ),
					'3' => __( 'Three (Features in at Last)', 'bdthemes-element-pack' ),
					'4' => __( 'Four (Header in at Middle)', 'bdthemes-element-pack' ),
					'5' => __( 'Five (No Features List)', 'bdthemes-element-pack' ),
					'6' => __( 'Six (Image Under Header)', 'bdthemes-element-pack' ),
					'7' => __( 'Seven (Image Under Features)', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_image',
			[
				'label' => __( 'Image', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$this->add_responsive_control(
			'align',
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
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table .bdt-price-table-image' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_header',
			[
				'label' => __( 'Header', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => __( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Service Name', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'HTML Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => element_pack_title_tags(),
				'default' => 'h3',
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'     => __( 'Subtitle', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Service sub title', 'bdthemes-element-pack' ),
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_pricing',
			[
				'label' => __( 'Pricing', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'   => __( 'Currency Symbol', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => __( 'None', 'bdthemes-element-pack' ),
					'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'bdthemes-element-pack' ),
					'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'bdthemes-element-pack' ),
					'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'bdthemes-element-pack' ),
					'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'bdthemes-element-pack' ),
					'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'bdthemes-element-pack' ),
					'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'bdthemes-element-pack' ),
					'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'bdthemes-element-pack' ),
					'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'bdthemes-element-pack' ),
					'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'bdthemes-element-pack' ),
					'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'bdthemes-element-pack' ),
					'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'bdthemes-element-pack' ),
					'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'bdthemes-element-pack' ),
					'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'bdthemes-element-pack' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'bdthemes-element-pack' ),
					'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'bdthemes-element-pack' ),
					'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'bdthemes-element-pack' ),
					'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'bdthemes-element-pack' ),
					'custom'       => __( 'Custom', 'bdthemes-element-pack' ),
				],
				'default' => 'dollar',
			]
		);

		$this->add_control(
			'currency_symbol_custom',
			[
				'label'     => __( 'Custom Symbol', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'currency_symbol' => 'custom',
				],
			]
		);

		$this->add_control(
			'price',
			[
				'label'   => __( 'Price', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '49.99',
			]
		);

		$this->add_control(
			'sale',
			[
				'label' => __( 'Sale', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'original_price',
			[
				'label'     => __( 'Original Price', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '79',
				'condition' => [
					'sale' => 'yes',
				],
			]
		);

		$this->add_control(
			'period',
			[
				'label'   => __( 'Period', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Monthly', 'bdthemes-element-pack' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_features',
			[
				'label'     => __( 'Features', 'bdthemes-element-pack' ),
				'condition' => [
					'layout!' => '5',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'features_list_tabs' );

		$repeater->start_controls_tab( 'features_list_tab_normal_text',
			[
				'label' => __( 'Normal Text', 'bdthemes-element-pack' )
			]
		);

		$repeater->add_control(
			'item_text',
			[
				'label'   => __( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'bdthemes-element-pack' ),
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'   => __( 'Icon', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fa fa-check',
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label'     => __( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'features_list_tab_tooltip_text',
			[
				'label' => __( 'Tooltip Text', 'bdthemes-element-pack' )
			]
		);

		$repeater->add_control(
			'tooltip_text',
			[
				'label' => __( 'Text', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'tooltip_placement',
			[
				'label'   => __( 'Placement', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'top'    => __( 'Top', 'bdthemes-element-pack' ),
					'bottom' => __( 'Bottom', 'bdthemes-element-pack' ),
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
				],
				'condition'   => [
					'tooltip_text!' => '',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'features_list',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'item_text' => __( 'List Item #1', 'bdthemes-element-pack' ),
						'item_icon' => 'fa fa-check',
					],
					[
						'item_text' => __( 'List Item #2', 'bdthemes-element-pack' ),
						'item_icon' => 'fa fa-check',
					],
					[
						'item_text' => __( 'List Item #3', 'bdthemes-element-pack' ),
						'item_icon' => 'fa fa-check',
					],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_footer',
			[
				'label' => __( 'Footer', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => __( 'Button Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Select Plan', 'bdthemes-element-pack' ),
			]
		);

		if (class_exists('Easy_Digital_Downloads')) {
			$edd_posts = get_posts( ['numberposts' => 10, 'post_type'   => 'download'] );
			$options = ['0' => __( 'Select EDD', 'bdthemes-element-pack' )];
			foreach ( $edd_posts as $edd_post ) {
				$options[ $edd_post->ID ] = $edd_post->post_title;
			}
			
		} else {
			$options = ['0' => __( 'Not found', 'bdthemes-element-pack' )];
		}

		$this->add_control(
			'edd_as_button',
			[
				'label' => __( 'Easy Digital Download Integration', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'edd_id',
			[
				'label'       => __( 'Easy Digital Download Item', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $options,
				'label_block' => true,
				'condition'   => [
					'edd_as_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'condition' => [
					'edd_as_button' => '',
				],
			]
		);

		$this->add_control(
			'footer_additional_info',
			[
				'label'     => __( 'Additional Info', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'This is footer text', 'bdthemes-element-pack' ),
				'rows'      => 2,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_ribbon',
			[
				'label' => __( 'Ribbon', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'show_ribbon',
			[
				'label'     => __( 'Show', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ribbon_title',
				[
				'label'     => __( 'Title', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Popular', 'bdthemes-element-pack' ),
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_control(
			'ribbon_align',
			[
				'label'   => __( 'Align', 'bdthemes-element-pack' ),
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
						'title' => __( 'Justify', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'left',
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_vertical_position',
			[
				'label' => __( 'Vertical Position', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_rotate',
			[
				'label'   => __( 'Rotate', 'bdthemes-element-pack' ),
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
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .bdt-price-table-ribbon-inner' => 'transform: translate({{ribbon_horizontal_position.SIZE}}{{UNIT}}, {{ribbon_vertical_position.SIZE}}{{UNIT}}) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .bdt-price-table-ribbon-inner' => 'transform: translate({{ribbon_horizontal_position_tablet.SIZE}}{{UNIT}}, {{ribbon_vertical_position_tablet.SIZE}}{{UNIT}}) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .bdt-price-table-ribbon-inner' => 'transform: translate({{ribbon_horizontal_position_mobile.SIZE}}{{UNIT}}, {{ribbon_vertical_position_mobile.SIZE}}{{UNIT}}) rotate({{SIZE}}deg);',
				],
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => __( 'Image', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
				]
			]
		);

		$this->add_control(
			'image_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-image' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'   => __( 'Size (%)', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'   => __( 'Opacity (%)', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'label'     => __( 'Image Border', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-price-table img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-price-table img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => __( 'Header', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_heading_style',
			[
				'label'     => __( 'Title', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .bdt-price-table-heading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_sub_heading_style',
			[
				'label'     => __( 'Sub Title', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_heading_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-subheading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_heading_typography',
				'selector' => '{{WRAPPER}} .bdt-price-table-subheading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pricing',
			[
				'label' => __( 'Pricing', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_element_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-price' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_element_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-currency, {{WRAPPER}} .bdt-price-table-integer-part, {{WRAPPER}} .bdt-price-table-fractional-part' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .bdt-price-table-price',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_currency_style',
			[
				'label'     => __( 'Currency Symbol', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-currency' => 'font-size: calc({{SIZE}}em/100)',
				],
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_vertical_position',
			[
				'label'   => __( 'Vertical Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
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
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-currency' => 'align-self: {{VALUE}}',
				],
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'fractional_part_style',
			[
				'label'     => __( 'Fractional Part', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'fractional-part_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-fractional-part' => 'font-size: calc({{SIZE}}em/100)',
				],
			]
		);

		$this->add_control(
			'fractional_part_vertical_position',
			[
				'label'   => __( 'Vertical Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
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
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-after-price' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_original_price_style',
			[
				'label'     => __( 'Original Price', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-original-price' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'original_price_typography',
				'selector'  => '{{WRAPPER}} .bdt-price-table-original-price',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_vertical_position',
			[
				'label'   => __( 'Vertical Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
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
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'   => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-original-price' => 'align-self: {{VALUE}}',
				],
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'heading_period_style',
			[
				'label'     => __( 'Period', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-period' => 'color: {{VALUE}}',
				],
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'period_typography',
				'selector'  => '{{WRAPPER}} .bdt-price-table-period',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_control(
			'period_position',
			[
				'label'   => __( 'Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'below'  => 'Below',
					'beside' => 'Beside',
				],
				'default'   => 'below',
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_features',
			[
				'label'     => __( 'Features', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => '5',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_features' );

		$this->start_controls_tab( 'tab_features_normal_text',
			[
				'label' => __( 'Normal Text', 'bdthemes-element-pack' )
			]
		);

		$this->add_control(
			'features_list_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'features_list_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_list_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list, {{WRAPPER}} .edd_price_options li span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'features_list_typography',
				'selector' => '{{WRAPPER}} .bdt-price-table-features-list li, {{WRAPPER}} .edd_price_options li span',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'features_list_alignment',
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
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label' => __( 'Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-feature-inner' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'list_divider',
			[
				'label'     => __( 'Divider', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label'   => __( 'Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'solid'  => __( 'Solid', 'bdthemes-element-pack' ),
					'double' => __( 'Double', 'bdthemes-element-pack' ),
					'dotted' => __( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => __( 'Dashed', 'bdthemes-element-pack' ),
				],
				'default'   => 'solid',
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list li:before' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list li:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label'   => __( 'Weight', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label'     => __( 'Width', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'divider_gap',
			[
				'label'   => __( 'Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-features-list li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_features_tooltip_text',
			[ 
				'label' => __( 'Tooltip Text', 'bdthemes-element-pack' )
			]
		);

		$this->add_responsive_control(
			'features_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'features_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
			]
		);

		$this->add_control(
			'features_tooltip_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'features_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'features_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
			]
		);

		$this->add_control(
			'features_tooltip_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'features_tooltip_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'features_tooltip_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'features_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'features_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_footer',
			[
				'label' => __( 'Footer', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'footer_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-footer' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label'     => __( 'Button', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'md' => __( 'Default', 'bdthemes-element-pack' ),
					'sm' => __( 'Small', 'bdthemes-element-pack' ),
					'xs' => __( 'Extra Small', 'bdthemes-element-pack' ),
					'lg' => __( 'Large', 'bdthemes-element-pack' ),
					'xl' => __( 'Extra Large', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => __( 'Normal', 'bdthemes-element-pack' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#14ABF4',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-price-table-button',
				'condition'   => [
					'button_text!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-price-table-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => __( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-price-table-button',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => __( 'Hover', 'bdthemes-element-pack' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'     => __( 'Animation', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_additional_info',
			[
				'label'     => __( 'Additional Info', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-additional_info' => 'color: {{VALUE}}',
				],
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'additional_info_typography',
				'selector'  => '{{WRAPPER}} .bdt-price-table-additional_info',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 15,
					'right'  => 30,
					'bottom' => 0,
					'left'   => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-additional_info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_ribbon',
			[
				'label'     => __( 'Ribbon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_control(
			'ribbon_bg_color',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#14ABF4',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-ribbon-inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-price-table-ribbon-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-ribbon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ribbon_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-price-table-ribbon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'shadow',
				'selector' => '{{WRAPPER}} .bdt-price-table-ribbon-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ribbon_typography',
				'selector' => '{{WRAPPER}} .bdt-price-table-ribbon-inner',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
	}

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'       => '&#36;',
			'baht'         => '&#3647;',
			'euro'         => '&#128;',
			'franc'        => '&#8355;',
			'guilder'      => '&fnof;',
			'indian_rupee' => '&#8377;',
			'krona'        => 'kr',
			'lira'         => '&#8356;',
			'peseta'       => '&#8359',
			'peso'         => '&#8369;',
			'pound'        => '&#163;',
			'real'         => 'R$',
			'ruble'        => '&#8381;',
			'rupee'        => '&#8360;',
			'shekel'       => '&#8362;',
			'won'          => '&#8361;',
			'yen'          => '&#165;',
		];
		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	public function render_image() {

		$settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-price-table-image' );

		 ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
		</div>
		<?php
	}

	public function render_header() {
		$settings = $this->get_settings();

		if ( $settings['heading'] || $settings['sub_heading'] ) : ?>
			<div class="bdt-price-table-header">					
				<?php if ( ! empty( $settings['heading'] ) ) : ?>
					<<?php echo esc_attr($settings['heading_tag']); ?> class="bdt-price-table-heading">
						<?php echo esc_html($settings['heading']); ?>
					</<?php echo esc_attr($settings['heading_tag']); ?>>
				<?php endif; ?>

				<?php if ( ! empty($settings['sub_heading']) and '' == $settings['_skin'] ) : ?>
					<span class="bdt-price-table-subheading">
						<?php echo esc_html($settings['sub_heading']); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endif;
	}

	public function render_price() {
		$settings = $this->get_settings();

		$symbol   = '';
		$image    = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

		$price    = explode( '.', $settings['price'] );
		$intpart  = $price[0];
		$fraction = '';

		if ( 2 === sizeof( $price ) ) {
			$fraction = $price[1];
		}

		$period_position = $settings['period_position'];
		$period_class    = ($period_position == 'below') ? ' bdt-price-table-period-position-below' : ' bdt-price-table-period-position-beside';
		$period_element  = '<span class="bdt-price-table-period elementor-typo-excluded'.$period_class.'">' . $settings['period'] . '</span>';

		?>
		<div class="bdt-price-table-price">
			<?php if ( $settings['sale'] && ! empty( $settings['original_price'] ) ) : ?>
				<div class="bdt-price-table-original-price elementor-typo-excluded">
					<?php echo esc_html($symbol . $settings['original_price']); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $symbol ) && is_numeric( $intpart ) ) : ?>
				<span class="bdt-price-table-currency">
					<?php echo esc_attr($symbol); ?>
				</span>
			<?php endif; ?>

			<?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
				<span class="bdt-price-table-integer-part">
					<?php echo esc_attr($intpart); ?>
				</span>
			<?php endif; ?>

			<?php if ( 0 < $fraction || ( ! empty( $settings['period'] ) && 'beside' === $period_position ) ) : ?>
				<div class="bdt-price-table-after-price">
					<span class="bdt-price-table-fractional-part">
						<?php echo esc_attr($fraction); ?>
					</span>
					<?php if ( ! empty( $settings['period'] ) && 'beside' === $period_position ) : ?>
						<?php echo wp_kses_post($period_element); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['period'] ) && 'below' === $period_position ) : ?>
				<?php echo wp_kses_post($period_element); ?>
			<?php endif; ?>
		</div>
		<?php
	}

	public function render_features_list() {

		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['features_list'] ) ) : ?>
			<ul class="bdt-price-table-features-list">
				<?php foreach ( $settings['features_list'] as $item ) :

					$this->add_render_attribute( 'features', 'class', 'bdt-price-table-feature-text bdt-display-inline-block', true );
					
					if ( $item['tooltip_text'] ) {
						// Tooltip settings
						$this->add_render_attribute( 'features', 'class', 'bdt-tippy-tooltip' );
						$this->add_render_attribute( 'features', 'data-tippy', '', true );
						$this->add_render_attribute( 'features', 'data-tippy-arrow', 'true', true );
						$this->add_render_attribute( 'features', 'data-tippy-placement', $item['tooltip_placement'], true );
						$this->add_render_attribute( 'features', 'data-tippy-content', $item['tooltip_text'], true );
					}

					?>
					<li class="'elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
						<div class="bdt-price-table-feature-inner">
							<?php if ( ! empty( $item['item_icon'] ) ) : ?>
								<i class="<?php echo esc_attr( $item['item_icon'] ); ?>"></i>
							<?php endif; ?>
							<?php if ( ! empty( $item['item_text'] ) ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'features' ); ?>>
									<?php echo esc_html($item['item_text']); ?>
								</div>
							<?php else :
								echo '&nbsp;';
							endif;
							?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif;
	}

	public function render_footer() {
		$settings = $this->get_settings();

		if ( ! empty( $settings['button_text'] ) || ! empty( $settings['footer_additional_info'] ) ) : ?>
			<div class="bdt-price-table-footer">
				

				<?php $this->render_button(); ?>

				<?php if ( ! empty($settings['footer_additional_info']) and '' == $settings['_skin'] ) : ?>
					<div class="bdt-price-table-additional_info">
						<?php echo wp_kses_post($settings['footer_additional_info']); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif;
	}


	public function render_button() {
		$settings         = $this->get_settings();
		$button_size      = ($settings['button_size']) ? 'elementor-size-' . $settings['button_size'] : '';
		$button_animation = (! empty( $settings['button_hover_animation'] )) ? ' elementor-animation-' . $settings['button_hover_animation'] : '';

		$this->add_render_attribute( 'button', 'class', [
				'bdt-price-table-button',
				'elementor-button',
				$button_size,
			]
		);

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );

			if ( ! empty( $settings['link']['is_external'] ) ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		if ( ! empty( $settings['button_hover_animation'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		if ($settings['edd_as_button']) {
			echo edd_get_purchase_link( [
				'download_id' => $settings['edd_id'], 
				'price' => false, 
				'text' => esc_html($settings['button_text']),
				'class' => 'bdt-price-table-button elementor-button ' . $button_size . $button_animation, 
			] );
		} else {
			if ( ! empty( $settings['button_text'] ) ) : ?>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php echo esc_html($settings['button_text']); ?>
				</a>
			<?php endif; 
		}
	}

	public function render_ribbon() {
		$settings = $this->get_settings();

		if ( $settings['show_ribbon'] && ! empty( $settings['ribbon_title'] ) ) :
			$this->add_render_attribute( 'ribbon-wrapper', 'class', 'bdt-price-table-ribbon' );

			if ( ! empty( $settings['ribbon_align'] ) ) :
				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-ribbon-' . $settings['ribbon_align'] );
			endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); ?>>
				<div class="bdt-price-table-ribbon-inner">
					<?php echo esc_html($settings['ribbon_title']); ?>
				</div>
			</div>
		<?php endif;
	}

	protected function render() {
		$settings = $this->get_settings();

		?>
		<div class="bdt-price-table bdt-price-table-skin-default">
			<?php
			if ('1' == $settings['layout']) :
				$this->render_image();
				$this->render_header();
				$this->render_price();
				$this->render_features_list();
				$this->render_footer();			
			endif;

			if ('2' == $settings['layout']) :
				$this->render_image();
				$this->render_header();
				$this->render_features_list();
				$this->render_price();
				$this->render_footer();			
			endif;

			if ('3' == $settings['layout']) :
				$this->render_image();
				$this->render_header();
				$this->render_price();
				$this->render_footer();			
				$this->render_features_list();
			endif;

			if ('4' == $settings['layout']) :
				$this->render_image();
				$this->render_features_list();
				$this->render_header();
				$this->render_price();
				$this->render_footer();			
			endif;

			if ('5' == $settings['layout']) :
				$this->render_image();
				$this->render_header();
				$this->render_price();
				$this->render_footer();			
			endif;

			if ('6' == $settings['layout']) :
				$this->render_header();
				$this->render_image();
				$this->render_price();
				$this->render_features_list();
				$this->render_footer();			
			endif;

			if ('7' == $settings['layout']) :
				$this->render_header();
				$this->render_price();
				$this->render_features_list();
				$this->render_image();
				$this->render_footer();			
			endif;

		?>
		</div>
		<?php $this->render_ribbon();
	}

	protected function _content_template() {
		?>
		<#
			var symbols = {
				dollar: '&#36;',
				euro: '&#128;',
				franc: '&#8355;',
				pound: '&#163;',
				ruble: '&#8381;',
				shekel: '&#8362;',
				baht: '&#3647;',
				yen: '&#165;',
				won: '&#8361;',
				guilder: '&fnof;',
				peso: '&#8369;',
				peseta: '&#8359;',
				lira: '&#8356;',
				rupee: '&#8360;',
				indian_rupee: '&#8377;',
				real: 'R$',
				krona: 'kr'
			};

			var symbol = '';

			if ( settings.currency_symbol ) {
				if ( 'custom' !== settings.currency_symbol ) {
					symbol = symbols[ settings.currency_symbol ] || '';
				} else {
					symbol = settings.currency_symbol_custom;
				}
			}

			var price = settings.price.split( '.' ),
				intpart = price[0],
				fraction = price[1],
				buttonSize = (settings.button_size) ? ' elementor-size-' + settings.button_size : '',
				periodElement = '<span class="bdt-price-table-period elementor-typo-excluded">' + settings.period + '</span>',
				
				buttonClasses = 'bdt-price-table-button elementor-button' + buttonSize;

			if ( settings.button_hover_animation ) {
				buttonClasses += ' elementor-animation-' + settings.button_hover_animation;
			}

			if ( '' !== settings.image.url ) {
				var image = {
					url: settings.image.url,
				};

				var image_url = elementor.imagesManager.getImageUrl( image );

				if ( ! image_url ) {
					return;
				}

				var imgClass = '';

				if ( '' !== settings.hover_animation ) {
					imgClass = 'elementor-animation-' + settings.hover_animation;
				}
			}

		#>
		
		<# function render_image() { #>
			<# if ( image_url ) { #>
				<div class="bdt-price-table-image"><img src="{{ image_url }}" class="{{ imgClass }}" /></div>
			<# } #>
		<# } #>

		<# function render_header() { #>
			<# if ( settings.heading || settings.sub_heading ) { #>
				<div class="bdt-price-table-header">
					<# if ( settings.heading ) { #>
						<{{{settings.heading_tag}}} class="bdt-price-table-heading">{{{ settings.heading }}}</{{{settings.heading_tag}}}>
					<# } #>
					<# if ( settings.sub_heading && '' == settings._skin ) { #>
						<span class="bdt-price-table-subheading">{{{ settings.sub_heading }}}</span>
					<# } #>
				</div>
			<# } #>
		<# } #>

		<# function render_price() { #>
			<div class="bdt-price-table-price">
				<# if ( settings.sale && settings.original_price ) { #>
					<div class="bdt-price-table-original-price elementor-typo-excluded">{{{ symbol + settings.original_price }}}</div>
				<# } #>

				<# if (  ! _.isEmpty( symbol ) && isFinite( intpart ) ) { #>
					<span class="bdt-price-table-currency">{{{ symbol }}}</span>
				<# } #>
				<# if ( intpart ) { #>
					<span class="bdt-price-table-integer-part">{{{ intpart }}}</span>
				<# } #>
				<div class="bdt-price-table-after-price">
					<# if ( fraction ) { #>
						<span class="bdt-price-table-fractional-part">{{{ fraction }}}</span>
					<# } #>
					<# if ( settings.period && 'beside' === settings.period_position ) { #>
						{{{ periodElement }}}
					<# } #>
				</div>

				<# if ( settings.period && 'below' === settings.period_position ) { #>
					{{{ periodElement }}}
				<# } #>
			</div>
		<# } #>

		<# function render_features_list() { #>
			<# if ( settings.features_list ) { #>
				<ul class="bdt-price-table-features-list">
					<# _.each( settings.features_list, function( item ) {

						view.addRenderAttribute( 'features', 'class', 'bdt-price-table-feature-text bdt-display-inline-block', true );
						
						if ( item.tooltip_text ) {
							view.addRenderAttribute( 'features', 'class', 'bdt-tippy-tooltip' );
							view.addRenderAttribute( 'features', 'data-tippy', '', true );
							view.addRenderAttribute( 'features', 'data-tippy-arrow', 'true', true );
							view.addRenderAttribute( 'features', 'data-tippy-placement', item.tooltip_placement, true );
							view.addRenderAttribute( 'features', 'title', item.tooltip_text, true );
						}

						#>
						<li class="elementor-repeater-item-{{ item._id }}">
							<div class="bdt-price-table-feature-inner">
								<# if ( item.item_icon ) { #>
									<i class="{{ item.item_icon }}"></i>
								<# } #>
								<# if ( ! _.isEmpty( item.item_text.trim() ) ) { #>
									<div {{{view.getRenderAttributeString( 'features' )}}}>{{{ item.item_text }}}</div>
								<# } else { #>
									&nbsp;
								<# } #>

							</div>
						</li>
					<# } ); #>
				</ul>
			<# } #>
		<# } #>

		<# function render_footer() { #>
			<# if ( settings.button_text || settings.footer_additional_info ) { #>
				<div class="bdt-price-table-footer">
					<# if ( settings.button_text ) { #>
						<a href="#" class="{{ buttonClasses }}">{{{ settings.button_text }}}</a>
					<# } #>
					<# if ( settings.footer_additional_info  && '' == settings._skin ) { #>
						<p class="bdt-price-table-additional_info">{{{ settings.footer_additional_info }}}</p>
					<# } #>
				</div>
			<# } #>
		<# } #>

		<# function render_ribbon() { #>
			<# if ( 'yes' === settings.show_ribbon && settings.ribbon_title ) {
				var ribbonClasses = 'bdt-price-table-ribbon';
				if ( settings.ribbon_align ) {
					ribbonClasses += ' elementor-ribbon-' + settings.ribbon_align;
				} #>
				<div class="{{ ribbonClasses }}">
					<div class="bdt-price-table-ribbon-inner">{{{ settings.ribbon_title }}}</div>
				</div>
			<# } #>
		<# } #>

		<# if ('' == settings._skin) { #>
			<div class="bdt-price-table">
				<#
				if ('1' == settings.layout) {
					render_image();
					render_header();
					render_price();
					render_features_list();
					render_footer();			
				}
				
				if ('2' == settings.layout) {
					render_image();
					render_header();
					render_features_list();
					render_price();
					render_footer();			
				}

				if ('3' == settings.layout) {
					render_image();
					render_header();
					render_price();
					render_footer();			
					render_features_list();
				}

				if ('4' == settings.layout) {
					render_image();
					render_features_list();
					render_header();
					render_price();
					render_footer();			
				}

				if ('5' == settings.layout) {
					render_image();
					render_header();
					render_price();
					render_footer();			
				}

				if ('6' == settings.layout) {
					render_header();
					render_image();
					render_price();
					render_features_list();
					render_footer();			
				}

				if ('7' == settings.layout) {
					render_header();
					render_price();
					render_features_list();
					render_image();
					render_footer();			
				} 
				#>
			</div>
		<# } #>

		<# if ('bdt-partait' == settings._skin) { #>
			<div class="bdt-price-table bdt-price-table-skin-partait">

				<div class="bdt-grid bdt-grid-collapse bdt-child-width-1-2@m" bdt-grid bdt-height-match="target: > div > .bdt-pricing-column">
					<div>
						<div class="bdt-pricing-column">
							<#
							render_header();
							render_price();
							render_footer();
							#>
						</div>
					</div>

					<div>
						<div class="bdt-pricing-column bdt-price-table-features-list-wrap bdt-flex bdt-flex-middle bdt-price-table-features-list-wrap">
							<#
							render_features_list();
							#>
						</div>
					</div>
				</div>
			</div>
		<# } #>

		<# render_ribbon(); #>

		<?php
	}
}
