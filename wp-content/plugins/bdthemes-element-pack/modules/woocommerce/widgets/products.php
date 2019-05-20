<?php
namespace ElementPack\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

use ElementPack\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products extends Widget_Base {

	public function get_name() {
		return 'bdt-wc-products';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'WC - Products', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'product', 'woocommerce', 'table' ];
	}

	public function get_script_depends() {
		return [ 'datatables' ];
	}

	public function get_style_depends() {
		return [ 'datatables' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Table( $this ) );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_woocommerce_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-products-wrapper.bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-products-wrapper.bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-products-wrapper.bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-products-wrapper.bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
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
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .star-rating' => 'text-align: {{VALUE}}; display: inline-block !important',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'table_header_alignment',
			[
				'label'   => esc_html__( 'Header Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table th' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'table_data_alignment',
			[
				'label'   => esc_html__( 'Data Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table td' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'label'     => esc_html__( 'Image Size', 'bdthemes-element-pack' ),
				'exclude'   => [ 'custom' ],
				'default'   => 'medium',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Show Filter', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'condition'    => [
					'_skin'      => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_info',
			[
				'label'   => esc_html__( 'Footer Info', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition'    => [
					'_skin'           => 'bdt-table',
					'show_pagination' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => esc_html__( 'Query', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'bdthemes-element-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'bdthemes-element-pack' ),
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
				'label'       => esc_html__( 'Categories', 'bdthemes-element-pack' ),
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
			'exclude_products',
			[
				'label'       => esc_html__( 'Exclude Product(s)', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder'     => 'product_id',
				'label_block' => true,
				'description' => __( 'Write product id here, if you want to exclude multiple products so use comma as separator. Such as 1 , 2', '' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Product Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'   => esc_html__( 'Meta Key', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'total_sales',
				'options' => [
					'total_sales'    => esc_html__( 'Total Sales', 'bdthemes-element-pack' ),
					'_regular_price' => esc_html__( 'Regular Price', 'bdthemes-element-pack' ),
					'_sale_price'    => esc_html__( 'Sale Price', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
					'title'    => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'category' => esc_html__( 'Category', 'bdthemes-element-pack' ),
					'rand'     => esc_html__( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'bdthemes-element-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_woocommerce_additional',
			[
				'label' => esc_html__( 'Additional', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'     => esc_html__( 'Show Badge', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_thumb',
			[
				'label'   => esc_html__( 'Show Thumbnail', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'open_thumb_in_lightbox',
			[
				'label'      => esc_html__( 'Open Thumb in Lightbox', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_thumb',
							'value'    => 'yes',
						],
						[
							'name'  => '_skin',
							'value' => 'bdt-table',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_limit',
			[
				'label'      => esc_html__( 'Excerpt Limit', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 10,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'show_price',
			[
				'label'   => esc_html__( 'Price', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label'     => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => 'bdt-table',
				],
			]
		);


		$this->add_control(
			'show_tags',
			[
				'label'     => esc_html__( 'Tags', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => 'bdt-table',
				],
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => esc_html__( 'Add to Cart', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_searching',
			[
				'label'   => esc_html__( 'Search', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_ordering',
			[
				'label'   => esc_html__( 'Ordering', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

	

		$this->add_control(
			'thumb_hide_on_mobile',
			[
				'label'        => esc_html__( 'Thumb Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-thumb-hide-on-mobile-',
				'condition'    => [
					'show_thumb' => 'yes',
					'_skin'      => 'bdt-table',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_hide_on_mobile',
			[
				'label'        => esc_html__( 'Title Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-title-hide-on-mobile-',
				'condition'    => [
					'show_title' => 'yes',
					'_skin'      => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'excerpt_hide_on_mobile',
			[
				'label'        => esc_html__( 'Description Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-excerpt-hide-on-mobile-',
				'condition'    => [
					'show_excerpt' => 'yes',
					'_skin'        => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'price_hide_on_mobile',
			[
				'label'        => esc_html__( 'Price Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-price-hide-on-mobile-',
				'condition'    => [
					'show_price' => 'yes',
					'_skin'      => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'categories_hide_on_mobile',
			[
				'label'        => esc_html__( 'Categories Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-categories-hide-on-mobile-',
				'condition'    => [
					'show_categories' => 'yes',
					'_skin'           => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'tags_hide_on_mobile',
			[
				'label'        => esc_html__( 'Tags Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-tags-hide-on-mobile-',
				'condition'    => [
					'show_tags' => 'yes',
					'_skin'     => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'rating_hide_on_mobile',
			[
				'label'        => esc_html__( 'Rating Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-rating-hide-on-mobile-',
				'condition'    => [
					'show_rating' => 'yes',
					'_skin'       => 'bdt-table',
				]
			]
		);

		$this->add_control(
			'cart_hide_on_mobile',
			[
				'label'        => esc_html__( 'Cart Hide on mobile ?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-cart-hide-on-mobile-',
				'condition'    => [
					'show_cart' => 'yes',
					'_skin'     => 'bdt-table',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label'     => esc_html__( 'Item', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Item Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label'      => esc_html__( 'Description Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product .bdt-wc-product-inner:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table',
			[
				'label'     => esc_html__( 'Table', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_table_style' );

		$this->start_controls_tab(
			'tab_table_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'table_header_typography',
				'label'    => esc_html__( 'Header Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-products table th',
			]
		);

		$this->add_control(
			'table_heading_background',
			[
				'label'     => esc_html__( 'Heading Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table td'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wc-products table th'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wc-products table.dataTable.no-footer' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_odd_row_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table.dataTable.stripe tbody tr.odd' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_even_row_background',
			[
				'label'     => esc_html__( 'Even Row Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table.dataTable.stripe tbody tr.even' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border',
				[
				'label'     => esc_html__( 'Cell Border', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'stripe',
				[
				'label'     => esc_html__( 'stripe', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'hover_effect',
				[
				'label'     => esc_html__( 'Hover Effect', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'table_cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products table.bdt-wc-product td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_table_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'table_odd_row_hover_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products table.dataTable.stripe tbody tr:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_field_style',
			[
				'label' => esc_html__( 'Search Field', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_searching' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_search_field_style' );

		$this->start_controls_tab(
			'tab_search_field_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'search_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'search_field_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-products input[type*="search"], {{WRAPPER}} .bdt-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'search_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'search_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .dataTables_filter label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_filter' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'search_text_typography',
				'label'     => esc_html__( 'Text Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-wc-products .dataTables_filter label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_search_field_focus',
			[
				'label' => esc_html__( 'Focus', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'search_field_focus_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_width',
			[
				'label'   => __( 'Border Width', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]:focus' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_radius',
			[
				'label'   => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products input[type*="search"]:focus' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_select_field_style',
			[
				'label'     => esc_html__( 'Select Field', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_select_field_style' );

		$this->start_controls_tab(
			'tab_select_field_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'select_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products select'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'select_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'select_field_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'select_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'select_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'select_text_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .dataTables_length label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'select_text_typography',
				'label'     => esc_html__( 'Text Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-wc-products .dataTables_length label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_select_field_focus',
			[
				'label' => esc_html__( 'Focus', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'select_field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products select:focus'   => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'label'    => esc_html__( 'Image Border', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-image',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => esc_html__( 'Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .star-rating:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .star-rating span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => esc_html__( 'Price', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => esc_html__( 'Sale Price', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price, {{WRAPPER}} .bdt-wc-products .bdt-wc-product-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price, {{WRAPPER}} .bdt-wc-products .bdt-wc-product-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product-price, {{WRAPPER}} .bdt-wc-products .bdt-wc-product-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'bdthemes-element-pack' ),
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
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_fullwidth',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a' => 'width: 100%;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_shadow',
				'selector' => '{{WRAPPER}} .bdt-wc-products .bdt-wc-product .onsale',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Footer', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_datatable_footer_style' );

		$this->start_controls_tab(
			'tab_datatable_info',
			[
				'label' => __( 'Page Info', 'bdthemes-element-pack' )
			]
		);

		$this->add_responsive_control(
			'info_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'info_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .dataTables_info',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_datatable_pagination',
			[
				'label' => esc_html__( 'Pagination', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination'    => 'margin-top: {{SIZE}}px;',
					'{{WRAPPER}} .dataTables_paginate' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a'    => 'color: {{VALUE}};',
					'{{WRAPPER}} ul.bdt-pagination li span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'active_pagination_color',
			[
				'label'     => esc_html__( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li.bdt-active a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button.current'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_margin',
			[
				'label'     => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a'    => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} ul.bdt-pagination li span' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .paginate_button'          => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_arrow_size',
			[
				'label'     => esc_html__( 'Arrow Size', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a svg' => 'height: {{SIZE}}px; width: auto;',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ul.bdt-pagination li a, {{WRAPPER}} ul.bdt-pagination li span, {{WRAPPER}} .dataTables_paginate',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_categories',
			[
				'label'      => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => 'bdt-table',
						],
						[
							'name'  => 'show_categories',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'categories_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-product-categories a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wc-product-categories'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'categories_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-product-categories, {{WRAPPER}} .bdt-wc-product-categories a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tags',
			[
				'label'      => esc_html__( 'Tags', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => 'bdt-table',
						],
						[
							'name'  => 'show_tags',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'tags_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-wc-product-tags'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wc-product-tags a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tags_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-wc-product-tags, {{WRAPPER}} .bdt-wc-product-tags a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
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
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_desktop' );

		$this->start_controls_tab(
			'filter_tab_desktop',
			[
				'label' => __( 'Desktop', 'bdthemes-element-pack' )
			]
		);

		$this->add_control(
			'desktop_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_filter_padding',
			[
				'label'      => __('Padding', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-ep-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters > li.bdt-ep-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .bdt-ep-grid-filters > li.bdt-ep-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'desktop_filter_active',
			[
				'label' => esc_html__( 'Active', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_radius',
			[
				'label'      => __('Radius', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'filter_tab_mobile',
			[
				'label' => __( 'Mobile', 'bdthemes-element-pack' )
			]
		);

		$this->add_control(
			'filter_mbtn_width',
			[
				'label' => __('Button Width(%)', 'bdthemes-element-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_color',
			[
				'label'     => __( 'Button Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_background',
			[
				'label'     => __( 'Button Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dropdown-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_background',
			[
				'label'     => __( 'Dropdown Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dropdown' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_mbtn_dropdown_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-dropdown-nav li',
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_image() {
		$settings = $this->get_settings();
		?>
		<div class="bdt-wc-product-image bdt-background-cover">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>">
			</a>
		</div>
		<?php
	}

	public function render_header() {

		$settings = $this->get_settings();

		$this->add_render_attribute('wc-products', 'class', ['bdt-wc-products', 'bdt-wc-products-skin-default']);

		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute( 'wc-products', 'bdt-filter', 'target: #bdt-wc-product-' . $this->get_id() );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wc-products' ); ?>>

		<?php if ( $settings['show_filter_bar'] ) {
			$this->render_filter_menu();
		}
	}

	public function render_footer() {
		?>
		</div>
		<?php
	}

	public function render_query() {
		$settings = $this->get_settings();

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } 
		elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
		else { $paged = 1; }

		$exclude_products = ($settings['exclude_products']) ? explode(',', $settings['exclude_products']) : [];

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts_per_page'],
			'meta_key'            => $settings['meta_key'],
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
			'paged'               => $paged,
			'post__not_in'        => $exclude_products,
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy'           => 'product_cat',
				'field'              => 'slug',
				'terms'              => $settings['product_categories'],
				'post__not_in'       => $exclude_products,
			);
		}

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	public function render_filter_menu() {
		$settings           = $this->get_settings();
		$product_categories = [];

		$wp_query = $this->render_query();

		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories'] ) ) {
			$product_categories = $settings['product_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'product_cat' );
    			foreach ($terms as $term) {
    				$product_categories[] = esc_attr($term->slug);
    			};
			endwhile;

            wp_reset_postdata();

			$product_categories = array_unique($product_categories);

		}
		
		?>

		<div class="bdt-ep-grid-filters-wrapper">
			
			<button class="bdt-button bdt-button-default bdt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'bdthemes-element-pack' ); ?></button>
			<div bdt-dropdown="mode: click;" class="bdt-dropdown bdt-margin-remove-top bdt-margin-remove-bottom">
			    <ul class="bdt-nav bdt-dropdown-nav">

					<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All Products', 'bdthemes-element-pack' ); ?></li>
					
					<?php foreach($product_categories as $product_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'product_cat'); ?>
						<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo $filter_name->name; ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="bdt-ep-grid-filters bdt-visible@m" bdt-margin>
				<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All Products', 'bdthemes-element-pack' ); ?></li>
		
				<?php foreach($product_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'product_cat'); ?>
					<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_loop_item() {
		$settings = $this->get_settings();
		$id       = 'bdt-wc-product-' . $this->get_id();

		$wp_query = $this->render_query();

		if($wp_query->have_posts()) {

			$this->add_render_attribute('wc-products-wrapper', 'bdt-grid', '');

			$this->add_render_attribute(
				[
					'wc-products-wrapper' => [
						'class' => [
							'bdt-wc-products-wrapper',
							'bdt-grid',
							'bdt-grid-medium',
							'bdt-child-width-1-'. $settings['columns_mobile'],
							'bdt-child-width-1-'. $settings['columns_tablet'] .'@s',
							'bdt-child-width-1-'. $settings['columns'] .'@m',
						],
						'id' => esc_attr( $id ),
					],
				]
			);

			?>
			<div <?php echo $this->get_render_attribute_string( 'wc-products-wrapper' ); ?>>
			<?php			

			$this->add_render_attribute( 'wc-product', 'class', 'bdt-wc-product' );

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				
				<?php if( $settings['show_filter_bar'] ) {
			 		$terms = get_the_terms( get_the_ID(), 'product_cat' );
			 		$product_filter_cat = [];
	    			foreach ($terms as $term) {
	    				$product_filter_cat[] = 'bdtf-' . esc_attr($term->slug);
	    			};
	    			$this->add_render_attribute( 'wc-product', 'data-filter', implode(' ', $product_filter_cat), true );
    			} ?>

		  		<div <?php echo $this->get_render_attribute_string( 'wc-product' ); ?>>
		  			<div class="bdt-wc-product-inner">
		  				<?php if ('yes' == $settings['show_badge']) : ?>
				  			<div class="bdt-wc-products-badge">
					  			<?php woocommerce_show_product_loop_sale_flash(); ?>
				  			</div>
			  			<?php endif; ?>

		               <?php $this->render_image(); ?>

	           			<div class="bdt-wc-product-desc">
		               		<?php if ( 'yes' == $settings['show_title']) : ?>
			           			<h2 class="bdt-wc-product-title">
			           				<a href="<?php the_permalink(); ?>" class="bdt-link-reset">
						               <?php the_title(); ?>
						           </a>
				               </h2>
				            <?php endif; ?>

		           			<?php if (('yes' == $settings['show_price']) or ('yes' == $settings['show_rating'])) : ?>
			               		<?php if ( 'yes' == $settings['show_price']) : ?>
				           			<span class="bdt-wc-product-price">
										<?php woocommerce_template_single_price(); ?>
									</span>
					            <?php endif; ?>
						               
				               <?php if ('yes' == $settings['show_rating']) : ?>
					               	<div class="bdt-wc-rating">
					           			<?php woocommerce_template_loop_rating(); ?>
				           			</div>
			                	<?php endif; ?>
		                	<?php endif; ?>
						</div>

	                	<?php if ('yes' == $settings['show_cart']) : ?>
		                	<div class="bdt-wc-add-to-cart">
								<?php woocommerce_template_loop_add_to_cart();?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endwhile;	?>
			</div>
			<?php

			if ($settings['show_pagination']) {
				element_pack_post_pagination($wp_query);
			}

			wp_reset_postdata();
			
		} else {
			echo '<div class="bdt-alert-warning" bdt-alert>' . esc_html__( 'Ops! There is no product.', 'bdthemes-element-pack' ) .'<div>';
		}
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->render_footer();
	}
		
}
