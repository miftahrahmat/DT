<?php
namespace ElementPack\Modules\PostBlock\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Scheme_Typography;
use Elementor\Utils;

use ElementPack\Modules\QueryControl\Module;
use ElementPack\Modules\QueryControl\Controls\Group_Control_Posts;

use ElementPack\Modules\PostBlock\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_Block extends Widget_Base {

	public function get_name() {
		return 'bdt-post-block';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Post Block', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-post-block';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'block', 'blog', 'recent', 'news' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Genesis( $this ) );
		$this->add_skin( new Skins\Skin_Trinity( $this ) );
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
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
			'section_featured_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'featured_item',
			[
				'label'       => esc_html__( 'Featured Item', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => 'For good looking set it 1 for default skin and 2 for another skin',
				'options'     => [
					'1' => esc_html__( 'One', 'bdthemes-element-pack' ),
					'2' => esc_html__( 'Two', 'bdthemes-element-pack' ),
					'3' => esc_html__( 'Three', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'featured_show_tag',
			[
				'label'     => esc_html__( 'Tag', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => 'trinity',
				]
			]
		);

		$this->add_control(
			'featured_show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_date',
			[
				'label'   => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_category',
			[
				'label'   => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_show_read_more',
			[
				'label'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'       => esc_html__( 'Read More Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'condition'   => [
					'featured_show_read_more' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'condition'   => [
					'featured_show_read_more' => 'yes',
					'_skin'                   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
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
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-post-block .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'trinity_column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small'    => esc_html__( 'Small', 'bdthemes-element-pack' ),
					'medium'   => esc_html__( 'Medium', 'bdthemes-element-pack' ),
					'large'    => esc_html__( 'Large', 'bdthemes-element-pack' ),
					'collapse' => esc_html__( 'Collapse', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'_skin' => 'trinity',
				],
			]
		);

		$this->add_responsive_control(
			'featured_item_height',
			[
				'label' => esc_html__( 'Featured Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-item.featured-part .bdt-post-block-img-wrapper img' => 'height: {{SIZE}}px',
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-item.featured-part .bdt-post-block-thumbnail img' => 'height: {{SIZE}}px',
				]
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_layout',
			[
				'label'     => esc_html__( 'List Layout', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'list_show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_show_date',
			[
				'label'   => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_show_category',
			[
				'label' => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_list_divider',
			[
				'label'   => esc_html__( 'Divider', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_space_between',
			[
				'label'      => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block.bdt-post-block-skin-base .bdt-list > li:nth-child(n+2)'           => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',					
					'{{WRAPPER}} .bdt-post-block.bdt-post-block-skin-genesis .list-part ul li'       => 'margin-top: {{SIZE}}{{UNIT}};',					
					'{{WRAPPER}} .bdt-post-block.bdt-post-block-skin-genesis .list-part ul li > div' => 'padding-top: {{SIZE}}{{UNIT}};',					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name'  => 'posts',
				'label' => esc_html__( 'Posts', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => esc_html__( 'Advanced', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'posts_limit',
			[
				'label'   => esc_html__( 'Posts Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
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
			'section_featured_image_style',
			[
				'label'     => esc_html__( 'Featured Image Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => 'trinity',
				],
			]
		);

		$this->start_controls_tabs( 'featured_image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'featured_image_border',
				'selector' => '{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'featured_image_radius',
			[
				'label' => __( 'Radius', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'featured_image_shadow',
				'selector' => '{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img',
			]
		);

		$this->add_control(
			'opacity',
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
					'{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'opacity_hover',
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
					'{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .featured-part .bdt-post-block-img-wrapper img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_featured_style',
			[
				'label' => esc_html__( 'Featured Layout Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'featured_tag_heading',
			[
				'label'     => esc_html__( 'Tag', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
			]
		);

		$this->add_control(
			'tag_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-tag-wrap span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-tag-wrap span a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'tag_border',
				'label'     => __( 'Border', 'bdthemes-element-pack' ),
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selector' => '{{WRAPPER}} .bdt-post-block .bdt-post-block-tag-wrap span',
			]
		);

		$this->add_control(
			'tag_border_radius',
			[
				'label'     => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-tag-wrap span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tag_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selector' => '{{WRAPPER}} .bdt-post-block .bdt-post-block-tag-wrap span',
			]
		);

		$this->add_control(
			'featured_title_heading',
			[
				'label'     => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_title_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-title a',
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_date_heading',
			[
				'label'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_date_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-meta span',
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_category_heading',
			[
				'label'     => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_category_color',
			[
				'label'     => esc_html__( 'Category Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_category_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-meta a',
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_excerpt_category',
			[
				'label'     => esc_html__( 'Excerpt', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-excerpt' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_excerpt_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .featured-part .bdt-post-block-excerpt',
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'trinity_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .featured-part .bdt-overlay-primary' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'trinity',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_style',
			[
				'label'     => esc_html__( 'List Layout Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'list_layout_image_size',
			[
				'label' => esc_html__( 'Image Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 64,
						'max'  => 150,
						'step' => 10,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'list_layout_title_category',
			[
				'label' => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'list_layout_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-title .bdt-post-block-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_layout_title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-title .bdt-post-block-link',
			]
		);

		$this->add_control(
			'list_layout_date_heading',
			[
				'label'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'list_layout_date_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-meta span',
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_category_heading',
			[
				'label'     => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_category_color',
			[
				'label'     => esc_html__( 'Category Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'list_layout_category_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-block .list-part .bdt-post-block-meta a',
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block.bdt-post-block-skin-base .bdt-list > li:nth-child(n+2)' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-post-block .list-part .bdt-has-divider li > div' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_list_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_read_more',
			[
				'label'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'featured_show_read_more' => 'yes',
					'_skin'                   => ['', 'genesis'],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_read_more_style' );

		$this->start_controls_tab(
			'tab_read_more_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'read_more_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'read_more_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'read_more_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'read_more_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more',
			]
		);

		$this->add_control(
			'read_more_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_more_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read_more_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'read_more_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'read_more_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-block .bdt-post-block-read-more:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	public function get_posts_tags() {
		$taxonomy = $this->get_settings( 'taxonomy' );

		foreach ( $this->_query->posts as $post ) {
			if ( ! $taxonomy ) {
				$post->tags = [];

				continue;
			}

			$tags = wp_get_post_terms( $post->ID, $taxonomy );

			$tags_slugs = [];

			foreach ( $tags as $tag ) {
				$tags_slugs[ $tag->term_id ] = $tag;
			}

			$post->tags = $tags_slugs;
		}
	}

	public function query_posts($posts_per_page) {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $posts_per_page;

		$this->_query = new \WP_Query( $query_args );
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'featured_excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'featured_show_excerpt' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="bdt-post-block-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render() {
		$settings = $this->get_settings();
		$id       = uniqid('bdtpbm_');

		$animation        = ($settings['read_more_hover_animation']) ? ' elementor-animation-'.$settings['read_more_hover_animation'] : '';
		$bdt_list_divider = ( $settings['show_list_divider'] ) ? ' bdt-list-divider' : '';

		$this->query_posts($settings['posts_limit']);

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		if( $wp_query->have_posts() ) :

			$this->add_render_attribute(
				[
					'post-block' => [
						'id'    => esc_attr( $id ),
						'class' => [
							'bdt-post-block',
							'bdt-grid',
							'bdt-grid-match',
							'bdt-post-block-skin-base',
						],
						'bdt-grid' => ''
					]
				]
			);

			?>
			<div <?php echo $this->get_render_attribute_string( 'post-block' ); ?>>

				<?php $bdt_count = 0;
			
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$placeholder_image_src = Utils::get_placeholder_image_src();

					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

					if ( ! $image_src ) {
						$image_src = $placeholder_image_src;
					} else {
						$image_src = $image_src[0];
					}
					
			  		if( $bdt_count == 0) : ?>
			  			<div class="bdt-width-1-2@m">
			  		<?php endif; ?>

		  			<?php $bdt_count++; ?>
				  	<?php if( $bdt_count <= $settings['featured_item']) : ?>

			  			<div class="bdt-post-block-item featured-part bdt-width-1-1@m bdt-margin">
							<div class="bdt-post-block-img-wrapper bdt-margin-bottom">
								<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
				  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
				  				</a>
							</div>
					  		
					  		<div class="bdt-post-block-desc">

								<?php if ('yes' == $settings['featured_show_title']) : ?>
									<h4 class="bdt-post-block-title">
										<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
									</h4>
								<?php endif ?>

            	            	<?php if ($settings['featured_show_category'] or $settings['featured_show_date']) : ?>

            						<div class="bdt-post-block-meta bdt-subnav bdt-flex-middle">
            							<?php if ($settings['featured_show_date']) : ?>
            								<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
            							<?php endif ?>

            							<?php if ($settings['featured_show_category']) : ?>
            								<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
            							<?php endif ?>
            							
            						</div>

            					<?php endif ?>

								<?php $this->render_excerpt(); ?>

								<?php if ($settings['featured_show_read_more']) : ?>
									<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-post-block-read-more bdt-link-reset<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['read_more_text']); ?>
										
										<?php if ($settings['icon']) : ?>
											<span class="bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
												<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
											</span>
										<?php endif; ?>
									</a>
								<?php endif ?>
					  		</div>
						</div>

						<?php if( $bdt_count == $settings['featured_item']) : ?>

						</div>

				  		<div class="bdt-width-1-2@m" bdt-scrollspy="cls: bdt-animation-fade; target: > ul > .bdt-post-block-item; delay: 350;">
				  			<ul class="bdt-list bdt-list-large<?php echo esc_attr($bdt_list_divider); ?>">

			  			<?php endif; ?>

					<?php else :

						$placeholder_image_src = Utils::get_placeholder_image_src();

						$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );

						if ( ! $image_src ) {
							$image_src = $placeholder_image_src;
						} else {
							$image_src = $image_src[0];
						}
			  			
			  			?>
			  			<li class="bdt-post-block-item list-part">
				  			<div class="bdt-grid bdt-grid-small" bdt-grid>
				  				<div class="bdt-post-block-thumbnail bdt-width-auto">
				  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
					  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
					  				</a>
				  				</div>
						  		<div class="bdt-post-block-desc bdt-width-expand">
									<?php if ('yes' == $settings['list_show_title']) : ?>
										<h4 class="bdt-post-block-title">
											<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
										</h4>
									<?php endif ?>

					            	<?php if ($settings['list_show_category'] or $settings['list_show_date']) : ?>

										<div class="bdt-post-block-meta bdt-subnav bdt-flex-middle">
											<?php if ($settings['list_show_date']) : ?>
												<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
											<?php endif ?>

											<?php if ($settings['list_show_category']) : ?>
												<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
											<?php endif ?>
											
										</div>
									<?php endif ?>
						  		</div>
							</div>
						</li>
					<?php endif; endwhile; ?>
					</ul>
				</div>		
			</div>
		
		 	<?php 
			wp_reset_postdata(); 
		endif;
	}
}