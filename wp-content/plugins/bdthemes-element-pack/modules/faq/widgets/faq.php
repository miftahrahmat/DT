<?php
namespace ElementPack\Modules\Faq\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

use ElementPack\Modules\QueryControl\Module;
use ElementPack\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class FAQ extends Widget_Base {
	private $_query = null;


	public function get_name() {
		return 'bdt-faq';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'FAQ', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-faq';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'faq', 'accordion', 'tabs', 'toggle' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'faq';
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
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'collapsible',
			[
				'label'   => __( 'Collapsible All Item', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'multiple',
			[
				'label' => __( 'Multiple Open', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Show Icon', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);


		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Filter Bar', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 50,
			]
		);
		
		$this->add_control(
			'show_read_more',
			[
				'label'   => __( 'Read More', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'active_item',
			[
				'label' => __( 'Active Item No', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 20,
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

		

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => element_pack_get_category('faq_filter'),
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
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
			'section_content_button',
			[
				'label'     => esc_html__( 'Read More Button', 'bdthemes-element-pack' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'more_button_button_text',
			[
				'label'       => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'more_button_icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'more_button_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => esc_html__( 'Before', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'more_button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'more_button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'more_button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Item', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-title'   => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => __( 'Item Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item + .bdt-faq-item' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => __( 'Title', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-accordion .bdt-accordion-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-accordion-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => __( 'Active', 'bdthemes-element-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'active_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-title',
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'active_title_shadow',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'active_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-title',
			]
		);

		$this->add_control(
			'active_title_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hover_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title:hover',
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hover_title_shadow',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'hover_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title:hover',
			]
		);

		$this->add_control(
			'hover_title_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item .bdt-accordion-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label'     => __( 'Icon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Start', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'End', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => is_rtl() ? 'right' : 'left',
				'toggle'      => false,
				'label_block' => false,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-title .bdt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => __( 'Spacing', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-icon.bdt-accordion-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-icon.bdt-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_active',
			[
				'label' => __( 'Active', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item.bdt-open .bdt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-faq-item:hover .bdt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_content',
			[
				'label'     => __( 'Content', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'content_background_color',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-accordion-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-content' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_shadow',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-accordion-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'content_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-accordion .bdt-accordion-content',
			]
		);

		$this->add_control(
			'content_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
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
					'{{WRAPPER}} .bdt-accordion .bdt-accordion-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .bdt-accordion .bdt-accordion-content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
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

		$this->start_controls_section(
			'section_style_more_button',
			[
				'label'     => esc_html__( 'Read More Button', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_more_button_style' );

		$this->start_controls_tab(
			'tab_more_button_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'more_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_more_button_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'more_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'more_button_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'more_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'more_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button',
			]
		);

		$this->add_control(
			'more_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'more_button_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button',
			]
		);

		$this->add_control(
			'more_button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'more_button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 35,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-faq .bdt-faq-item .bdt-faq-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		
	}

	public function query_posts() {
		$settings = $this->get_settings();

		$args = array(
			'post_type'      => 'faq',
			'posts_per_page' => $settings['limit'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);
		
		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'faq_filter',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}		

		$query = new \WP_Query( $args );

		return $query;
	}

	public function render_title() {
		$settings = $this->get_settings();
		$faq_icon = get_post_meta( get_the_ID(), 'bdthemes_faq_icon', true);
		$faq_icon = (!empty($faq_icon)) ? $faq_icon : 'fa fa-question';

		?>
		<div class="bdt-accordion-title">
			<?php if ( $settings['icon'] ) : ?>
				<span class="bdt-accordion-icon bdt-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">
					<i class="bdt-accordion-icon-closed <?php echo esc_attr($faq_icon); ?>"></i>
					<i class="bdt-accordion-icon-opened fa fa-check"></i>
				</span>
			<?php endif; ?>
			<?php echo esc_html(get_the_title()) ; ?>
		</div>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="bdt-faq-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_more_button_button($post) {
		$settings = $this->get_settings();
		$animation = ($settings['more_button_hover_animation']) ? ' elementor-animation-'.$settings['more_button_hover_animation'] : '';

		if ('yes' == $settings['show_read_more']) : ?>
			<div class="bdt-clearfix"></div>
			<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="bdt-faq-button<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['more_button_button_text']); ?>

				<?php if ($settings['more_button_icon']) : ?>
					<span class="bdt-button-icon-align-<?php echo esc_attr($settings['more_button_icon_align']); ?>">
						<i class="<?php echo esc_attr($settings['more_button_icon']); ?>"></i>
					</span>
				<?php endif; ?>

			</a>
		<?php endif;
	}

	public function render_filter_menu() {
		$settings       = $this->get_settings();
		$faq_categories = [];

		$wp_query = $this->query_posts();

		if ( 'by_name' === $settings['source'] and !empty($settings['faq_categories'] ) ) {
			$faq_categories = $settings['faq_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'faq_filter' );
				if (is_array($terms)) {
					foreach ($terms as $term) {
						$faq_categories[] = esc_attr($term->slug);
					};
				}
			endwhile;

			$faq_categories = array_unique($faq_categories);

			wp_reset_postdata();

		}
		
		?>

		<div class="bdt-ep-grid-filters-wrapper">
			
			<button class="bdt-button bdt-button-default bdt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'bdthemes-element-pack' ); ?></button>
			<div bdt-dropdown="mode: click;" class="bdt-dropdown bdt-margin-remove-top bdt-margin-remove-bottom">
			    <ul class="bdt-nav bdt-dropdown-nav">

					<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All', 'bdthemes-element-pack' ); ?></li>
					
					<?php foreach($faq_categories as $faq_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'faq_filter'); ?>
						<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo $filter_name->name; ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="bdt-ep-grid-filters bdt-visible@m" bdt-margin>
				<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All', 'bdthemes-element-pack' ); ?></li>
		
				<?php foreach($faq_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'faq_filter'); ?>
					<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_header($settings, $id) {

		$this->add_render_attribute(
			[
				'accordion-settings' => [
					'id'            => $id,
					'class'         => 'bdt-accordion',
					'bdt-accordion' => [
						wp_json_encode([
							"collapsible" => $settings["collapsible"] ? true : false,
							"multiple"    => $settings["multiple"] ? true : false,
							"transition"  => "ease-in-out",
							"active"      => ( "" !== $settings["active_item"] ) ? $settings["active_item"]-1 : false,
						]),
					],
				],
			]
		);

		$this->add_render_attribute('faq-wrapper', 'class', 'bdt-faq-wrapper');
		
		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute('faq-wrapper', 'bdt-filter', 'target: #bdt-accordion-' . $this->get_id());
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'faq-wrapper' ); ?>>

			<?php if ( $settings['show_filter_bar'] ) {
				$this->render_filter_menu();
			}

			?>
			<div class="bdt-faq">
				<div <?php echo $this->get_render_attribute_string( 'accordion-settings' ); ?>>
		<?php
	}

	public function render_footer() {

		?>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_post($settings) {
		global $post;
		$item_filters = get_the_terms( $post->ID, 'faq_filter' ); 

		$this->add_render_attribute('faq-item', 'class', 'bdt-faq-item');

		if( $settings['show_filter_bar'] and is_array($item_filters) ) {
			foreach ($item_filters as $item_filter) {
				$this->add_render_attribute('faq-item', 'data-filter', 'bdtf-' . $item_filter->slug, true);
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'faq-item' ); ?>>				
			<?php $this->render_title(); ?>

			<div class="bdt-accordion-content">
				<?php 
				$this->render_excerpt();
				$this->render_more_button_button($post);
				?>
			</div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-accordion-' . $this->get_id();
		
		$wp_query = $this->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header($settings, $id);

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post($settings);
		}

		$this->render_footer();

		wp_reset_postdata();
	}
}
