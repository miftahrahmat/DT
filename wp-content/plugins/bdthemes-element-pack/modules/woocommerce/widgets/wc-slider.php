<?php
namespace ElementPack\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

use ElementPack\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Slider extends Widget_Base {
	private $_query = null;

	public function get_name() {
		return 'bdt-wc-slider';
	}

	public function get_title() {
		return BDTEP . __( 'WC - Slider', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'slider', 'woocommerce' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'bdt-uikit-icons' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'services';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->_query;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'   => __( 'Text Align', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
			]
		);

		$this->add_control(
			'vertical_align',
			[
				'label'   => __( 'Vertical Align', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'middle',
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
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'label'   => __( 'Image Size', 'bdthemes-element-pack' ),
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);

		$this->add_control(
			'slider_fullscreen',
			[
				'label' => __( 'Slideshow Fullscreen', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'content_reverse',
			[
				'label' => __( 'Content Reverse', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[
				'label' => __( 'Slider Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => __( 'Autoplay Interval(ms)', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'     => __( 'Pause on Hover', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'   => __( 'Price', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => __( 'Show Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => __( 'Rating', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label' => __( 'Show Text', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => __( 'Add to Cart', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'   => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'   => __( 'Show Badge', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_readmore',
			[
				'label'     => __('Read More', 'bdthemes-element-pack'),
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Read More', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'readmore_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'readmore_icon!' => '',
				],
			]
		);

		$this->add_control(
			'readmore_icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'readmore_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'bdthemes-element-pack' ),
					'arrows' => __( 'Arrows', 'bdthemes-element-pack' ),
					'dots'   => __( 'Dots', 'bdthemes-element-pack' ),
					'none'   => __( 'None', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-right',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => element_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => __( 'Button', 'bdthemes-element-pack' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Read More', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::ICON,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => __( 'Before', 'bdthemes-element-pack' ),
					'right' => __( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-button-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __( 'Query', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => __( 'Show All', 'bdthemes-element-pack' ),
					'by_name' => __( 'Manual Selection', 'bdthemes-element-pack' ),
				],
				'label_block' => true,
			]
		);


		$product_categories = get_terms( 'product_cat' );

		$options = [];
		foreach ( $product_categories as $category ) {
			$options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'product_categories',
			[
				'label'       => __( 'Categories', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => __( 'Product Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'   => __( 'Meta Key', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'total_sales',
				'options' => [
					'total_sales'    => __( 'Total Sales', 'bdthemes-element-pack' ),
					'_regular_price' => __( 'Regular Price', 'bdthemes-element-pack' ),
					'_sale_price'    => __( 'Sale Price', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order by', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => __( 'Date', 'bdthemes-element-pack' ),
					'title'    => __( 'Title', 'bdthemes-element-pack' ),
					'category' => __( 'Category', 'bdthemes-element-pack' ),
					'rand'     => __( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __( 'Descending', 'bdthemes-element-pack' ),
					'ASC'  => __( 'Ascending', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __('Content Padding', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => __( 'Price', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_heading',
			[
				'label' => __( 'Old Price', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => __( 'Sale Price', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price, {{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price, {{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price, {{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => __( 'Title', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => __( 'Rating', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .star-rating:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => __( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label'      => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-rating' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => __( 'Text', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => __( 'Text Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-text',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label'      => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-slider-items .bdt-wc-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => __( 'Add to Cart Button', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cart' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_spacing',
			[
				'label'      => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label' => __( 'Background', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes',
 				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider-readmore' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider-readmore' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-slider-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-slider-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_space_between',
			[
				'label'     => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-readmore' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider-readmore:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'readmore_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider-readmore:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => __( 'Badge', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => __( 'Border Color', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-slider .bdt-wc-slider-badge .onsale',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => __( 'Arrows', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 44,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next:hover svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'arrows_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg',
				'condition'   => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-wc-slider .bdt-navigation-next svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'value'    => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_dots',
			[
				'label'     => __( 'Dots', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-dotnav li a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-dotnav li a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-dotnav li.bdt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'heading_position',
			[
				'label'     => __( 'Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'     => __( 'Arrows Horizontal Offset', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Arrows Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Arrows Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-wc-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-slider .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	public function render_query() {
		$settings = $this->get_settings();

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts'],
			'no_found_rows'       => true,
			'meta_key'            => $settings['meta_key'],
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $settings['product_categories'],
			);
		}

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	protected function render_navigation() {
		$settings = $this->get_settings();

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($settings['arrows_position']); ?>">
			<div class="bdt-arrows-container bdt-slidenav-container">
				<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slider-item="previous"></a>
				<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slider-item="next"></a>
			</div>
		</div>
		<?php
	}

	protected function render_dotnavs() {
		$settings = $this->get_settings();

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($settings['dots_position']); ?>">
			<div class="bdt-dotnav-wrapper bdt-dots-container">
				<ul class="bdt-dotnav bdt-flex-center">

				    <?php		
					$bdt_counter = 0;

					$wp_query = $this->render_query();
					      
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item=" ' . $bdt_counter . ' "><a href="#"></a></li>';
						$bdt_counter++;
					endwhile; wp_reset_postdata(); ?>

				</ul>
			</div>
		</div>
		<?php
	}

	protected function render_both_navigation() {
		$settings = $this->get_settings();
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
								      
								$wp_query = $this->render_query();

								while ( $wp_query->have_posts() ) : $wp_query->the_post();
									echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item="'.$bdt_counter.'"><a href="#"></a></li>';
									$bdt_counter++;
								endwhile; wp_reset_postdata(); ?>
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

	protected function render_item_image() {
		$settings = $this->get_settings();
		$image_src = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);

		if ($image_src) :
			echo '<img src="'.esc_url($image_src).'" alt="' . get_the_title() . '">';
		endif;

		return 0;
	}

	protected function render_header() {
		$settings        = $this->get_settings_for_display();
		$slides_settings = [];

		$slider_settings['bdt-slider'] = wp_json_encode(array_filter([
			"autoplay"          => $settings["autoplay"],
			"autoplay-interval" => $settings["autoplay_interval"],
			"pause-on-hover"    => ("yes" === $settings["pause_on_hover"]) ? true : false,
	    ]));

    	$slider_settings['class'][] = 'bdt-wc-slider';

	    if ('both' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-arrows-dots-align-'. $settings['both_position'];
		} elseif ('arrows' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-arrows-align-'. $settings['arrows_position'];
		} elseif ('dots' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-dots-align-'. $settings['dots_position'];
		}

	    $slider_fullscreen = ( $settings['slider_fullscreen'] ) ? ' bdt-height-viewport="offset-top: true"' : '';

		?>
		<div <?php echo \element_pack_helper::attrs($slider_settings); ?>>
			<div class="bdt-position-relative bdt-visible-toggle">
				<ul class="bdt-slider-items bdt-child-width-1-1"<?php echo $slider_fullscreen; ?>>
		<?php
	}

	protected function render_footer() {
		$settings = $this->get_settings_for_display();

				?>
				</ul>
				<?php if ('both' == $settings['navigation']) : ?>
					<?php $this->render_both_navigation(); ?>

					<?php if ( 'center' === $settings['both_position'] ) : ?>
						<?php $this->render_dotnavs(); ?>
					<?php endif; ?>

				<?php elseif ('arrows' == $settings['navigation']) : ?>			
					<?php $this->render_navigation(); ?>
				<?php elseif ('dots' == $settings['navigation']) : ?>			
					<?php $this->render_dotnavs(); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public function render_readmore() {
		
		$animation = ($this->get_settings('readmore_hover_animation')) ? ' elementor-animation-'.$this->get_settings('readmore_hover_animation') : '';

		echo 
			'<a href="' . esc_url(get_permalink()) . '" class="bdt-wc-slider-readmore' . esc_attr($animation) . '">
				' . esc_html($this->get_settings('readmore_text'));
				
				if ( $this->get_settings( 'readmore_icon' ) ) :
					echo
						'<span class="bdt-button-icon-align-' . esc_attr($this->get_settings('readmore_icon_align')) . '">
							<i class="' . esc_attr($this->get_settings('readmore_icon')) . '"></i>
						</span>';
				endif;
		echo
			'</a>';
	}

	protected function render_item_content() {
		$settings        = $this->get_settings_for_display();

		?>
        <div class="bdt-slider-content-wrapper bdt-padding bdt-text-<?php echo $settings['text_align']; ?>">

        	<?php if ($settings['show_price']) : ?>
       			<div class="bdt-wc-slider-price">
					<span class="wae-product-price"><?php woocommerce_template_single_price(); ?></span>
				</div>
            <?php endif; ?>

			<?php if ( $settings['show_title'] ) : ?>
				<h2 class="bdt-wc-slider-title"><?php the_title(); ?></h2>
			<?php endif; ?>

			<?php if ($settings['show_rating']) : ?>
	           	<div class="bdt-wc-rating bdt-flex bdt-flex-<?php echo $settings['text_align']; ?>">
	       			<?php woocommerce_template_loop_rating(); ?>
	   			</div>
	    	<?php endif; ?>

			<?php if ( $settings['show_text'] ): ?>
				<div class="bdt-wc-slider-text"><?php the_excerpt(); ?></div>
			<?php endif; ?>

			<?php if ($settings['show_cart']) : ?>
            	<div class="bdt-wc-add-to-cart-readmore bdt-flex bdt-flex-<?php echo $settings['text_align']; ?> bdt-flex-middle">
					<?php if ($settings['show_cart']) : ?>
                		<div class="bdt-wc-add-to-cart">
							<?php woocommerce_template_loop_add_to_cart();?>
						</div>
					<?php endif; ?>

					<?php if ($settings['show_readmore']) : ?>
						<?php $this->render_readmore(); ?>
					<?php endif; ?>

			<?php endif; ?>
				</div>

		</div>
		<?php
	}

	public function render() {
		$settings  = $this->get_settings_for_display();

		$content_reverse = $settings['content_reverse'] ? ' bdt-flex-first' : '';

		$this->render_header();

		$wp_query = $this->render_query();

		while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				    
	        <li class="bdt-slider-item">
		        <div class="bdt-slider-item-inner bdt-grid bdt-grid-collapse bdt-height-1-1" bdt-grid>
			        <div class="bdt-width-1-2@m bdt-flex bdt-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?>">
			            <?php $this->render_item_content(); ?>
			        </div>

			        <div class="bdt-width-1-2@m bdt-mobile-order<?php echo esc_attr( $content_reverse ); ?>">
				        <div class="bdt-position-relative bdt-wc-slider-image">
				            
			            	<?php $this->render_item_image(); ?>       

				  			<?php if ( $settings['show_badge'] ) : ?>

					           		<?php if ($settings['show_badge']) : ?>
							  			<div class="bdt-wc-slider-badge bdt-position-top-left bdt-position-small">
								  			<?php woocommerce_show_product_loop_sale_flash(); ?>
							  			</div>
						  			<?php endif; ?>
							      
					    	<?php endif; ?>

					    </div>
				    </div>

		        </div>
	        </li>

		<?php endwhile; wp_reset_postdata();

		$this->render_footer();
	}
}
