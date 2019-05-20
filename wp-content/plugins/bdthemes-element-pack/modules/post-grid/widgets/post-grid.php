<?php
namespace ElementPack\Modules\PostGrid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Utils;

use ElementPack\Modules\QueryControl\Module;
use ElementPack\Modules\QueryControl\Controls\Group_Control_Posts;

use ElementPack\Modules\PostGrid\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_Grid extends Widget_Base {

	public function get_name() {
		return 'bdt-post-grid';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Post Grid', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-post-grid';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'grid', 'blog', 'recent', 'news' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Modern( $this ) );
		$this->add_skin( new Skins\Skin_Elanza( $this ) );
		$this->add_skin( new Skins\Skin_Carmie( $this ) );
		$this->add_skin( new Skins\Skin_Trosia( $this ) );
		$this->add_skin( new Skins\Skin_Harold( $this ) );
		$this->add_skin( new Skins\Skin_Reverse( $this ) );
		$this->add_skin( new Skins\Skin_Alter( $this ) );
		$this->add_skin( new Skins\Skin_Paddle( $this ) );
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
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
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
				'frontend_available' => true,
				'condition' => [
					'_skin' => ['bdt-carmie', 'bdt-harold'],
				],
			]
		);

		$this->add_control(
			'carmie_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => ['bdt-carmie'],
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'harold_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => ['bdt-harold'],
				],
				'default' => [
					'size' => 3,
				],
			]
		);

		$this->add_control(
			'trosia_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => 'bdt-trosia',
				],
				'default' => [
					'size' => 9,
				],
			]
		);

		$this->add_control(
			'reverse_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'bdt-reverse',
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'alter_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'bdt-alter',
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'paddle_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'bdt-paddle',
				],
				'default' => [
					'size' => 8,
				],
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small'    => esc_html__( 'Small', 'bdthemes-element-pack' ),
					'medium'   => esc_html__( 'Medium', 'bdthemes-element-pack' ),
					'large'    => esc_html__( 'Large', 'bdthemes-element-pack' ),
					'collapse' => esc_html__( 'Collapse', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'_skin!' => ['bdt-reverse', 'bdt-alter']
				]
			]
		);

		$this->add_control(
			'odd_item_columns',
			[
				'label'          => esc_html__( 'Odd Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => 'bdt-paddle',
				],
			]
		);

		$this->add_control(
			'even_item_columns',
			[
				'label'          => esc_html__( 'Even Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => 'bdt-paddle',
				],
			]
		);

		$this->add_responsive_control(
			'primary_item_height',
			[
				'label' => esc_html__( 'Primary Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-primary .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => ['bdt-carmie', 'bdt-trosia', 'bdt-reverse', 'bdt-alter', 'bdt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'odd_item_height',
			[
				'label' => esc_html__( 'Odd Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-primary .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'bdt-paddle',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'primary_thumbnail',
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'condition' => [
					'_skin' => ['', 'bdt-harold', 'bdt-elanza', 'bdt-modern', 'bdt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'secondary_item_height',
			[
				'label' => esc_html__( 'Secondary Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-secondary .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => ['bdt-carmie', 'bdt-trosia', 'bdt-reverse', 'bdt-alter', 'bdt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'even_item_height',
			[
				'label' => esc_html__( 'Even Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-secondary .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'bdt-paddle',
				],
			]
		);

		$this->add_control(
			'secondary_grid_height',
			[
				'label'        => esc_html__('Secondary Grid Height', 'bdthemes-element-pack'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'         => esc_html__('None', 'bdthemes-element-pack'),
					'match-height' => esc_html__('Match Height', 'bdthemes-element-pack'),
				],
				'condition' => [
					'_skin' => 'bdt-harold'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'secondary_thumbnail',
				'default'   => 'medium',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'_skin' => ['', 'bdt-harold', 'bdt-elanza', 'bdt-modern', 'bdt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'carmie_item_height',
			[
				'label' => esc_html__( 'Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid.bdt-post-grid-skin-carmie .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'bdt-carmie',
				],
			]
		);

		$this->add_responsive_control(
			'trosia_item_height',
			[
				'label' => esc_html__( 'Item Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid.bdt-post-grid-skin-trosia .bdt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'bdt-trosia',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'_skin' => ['bdt-carmie', 'bdt-trosia', 'bdt-reverse', 'bdt-alter'],
				],
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_grid_query',
			[
				'label' => esc_html__( 'Query', 'bdthemes-element-pack' ),
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
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => esc_html__( 'Date', 'bdthemes-element-pack' ),
					'post_title' => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'menu_order' => esc_html__( 'Menu Order', 'bdthemes-element-pack' ),
					'rand'       => esc_html__( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'bdthemes-element-pack' ),
					'desc' => esc_html__( 'DESC', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional', 'bdthemes-element-pack' ),
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
			'show_author',
			[
				'label'   => esc_html__( 'Author', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'     => esc_html__( 'Comments', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => 'bdt-carmie',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'      => esc_html__( 'Excerpt Length', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 15,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'bdt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'primary_excerpt_length',
			[
				'label'      => esc_html__( 'Primary Excerpt Length', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 40,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'  => '_skin',
							'value' => 'bdt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'secondary_excerpt_length',
			[
				'label'      => esc_html__( 'Secondary Excerpt Length', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 15,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'  => '_skin',
							'value' => 'bdt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => 'bdt-carmie',
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
				'condition'   => [
					'show_readmore' => 'yes',
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
					'show_readmore' => 'yes',
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
					'{{WRAPPER}} .bdt-post-grid .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-post-grid .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_animation',
			[
				'label'   => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale-up',
				'options' => [
					'scale-up'   => esc_html__( 'Scale-Up', 'bdthemes-element-pack' ),
					'scale-down' => esc_html__( 'Scale-Down', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-item',
				'condition'   => [
					'_skin!' => ['bdt-reverse', 'bdt-alter'],
				],
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
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-title'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-post-grid .bdt-secondary .bdt-post-grid-title' => 'margin-bottom: 0;',
				],
				'condition' => [
					'_skin!' => 'bdt-carmie',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-title a',
				'condition' => [
					'_skin' => ['bdt-carmie', 'bdt-reverse', 'bdt-alter', 'bdt-trosia'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'        => 'primary_title_typography',
				'label'       => esc_html__( 'Primary Typography', 'bdthemes-element-pack' ),
				'selector'    => '{{WRAPPER}} .bdt-post-grid .bdt-primary .bdt-post-grid-title a',
				'condition'   => [
					'_skin!' => ['bdt-carmie', 'bdt-reverse', 'bdt-alter', 'bdt-trosia'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'        => 'secondary_title_typography',
				'label'       => esc_html__( 'Secondary Typography', 'bdthemes-element-pack' ),
				'selector'    => '{{WRAPPER}} .bdt-post-grid .bdt-secondary .bdt-post-grid-title a',
				'condition'   => [
					'_skin!' => ['bdt-carmie', 'bdt-reverse', 'bdt-alter', 'bdt-trosia'],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_author',
			[
				'label'     => esc_html__( 'Author', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'author_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-author a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-author a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-subnav span:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_comments',
			[
				'label'      => esc_html__( 'Comments', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_comments',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'bdt-carmie',
						],
					],
				],
			]
		);

		$this->add_control(
			'comments_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-comments *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comments_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-comments',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_category',
			[
				'label'     => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Category Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-category a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-category a',
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
				'label'     => esc_html__( 'Excerpt Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-excerpt',
			]
		);

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
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore',
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
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-readmore:hover' => 'border-color: {{VALUE}};',
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
			'section_style_skin',
			[
				'label'     => esc_html__( 'Skin', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ['bdt-carmie', 'bdt-trosia'],
				],
			]
		);

		$this->add_control(
			'carmie_desc_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'bdt-carmie',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-grid .bdt-custom-overlay' => 'background-color: {{VALUE}};',					
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-desc' => 'background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,{{VALUE)}} 70%);',
					'{{WRAPPER}} .bdt-post-grid .bdt-post-grid-desc' => 'background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,{{VALUE)}} 70%);',
				],
				'separator' => 'before',
				'condition' => [
					'_skin' => 'bdt-trosia',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);


		$this->start_controls_tabs( 'tabs_pagination_style' );

		$this->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a, {{WRAPPER}} ul.bdt-pagination li span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'pagination_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} ul.bdt-pagination li a',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pagination_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'selector'    => '{{WRAPPER}} ul.bdt-pagination li a',
			]
		);

		$this->add_responsive_control(
			'pagination_offset',
			[
				'label'     => esc_html__( 'Offset', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-pagination' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_space',
			[
				'label'     => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-pagination' => 'margin-left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-pagination > *' => 'padding-left: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_padding',
			[
				'label'     => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_radius',
			[
				'label'     => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
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
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ul.bdt-pagination li a, {{WRAPPER}} ul.bdt-pagination li span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'pagination_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} ul.bdt-pagination li a:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_active',
			[
				'label' => esc_html__( 'Active', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li.bdt-active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.bdt-pagination li.bdt-active a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'pagination_active_background',
				'selector' => '{{WRAPPER}} ul.bdt-pagination li.bdt-active a',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label'     => esc_html__( 'Description', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ['bdt-reverse', 'bdt-alter'],
				],
			]
		);

		$this->add_control(
			'description_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-reverse .bdt-post-grid-img-wrap:after'      => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-plane .bdt-post-grid-img-wrap:after'        => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-post-grid-skin-reverse .bdt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'bdt-reverse',
				],
			]
		);

		$this->add_control(
			'alter_description_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-alter .bdt-post-grid-img-wrap:after'      => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-plane .bdt-post-grid-img-wrap:after'      => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-post-grid-skin-alter .bdt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'bdt-alter',
				],
			]
		);

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

	public function render_image($image_id, $size) {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		$image_src = wp_get_attachment_image_src( $image_id, $size );

		if ( ! $image_src ) {
			$image_src = $placeholder_image_src;
		} else {
			$image_src = $image_src[0];
		}

		echo 
			'<div class="bdt-post-grid-img-wrap bdt-overflow-hidden">
				<a href="' . esc_url(get_permalink()) . '" class="bdt-transition-' . esc_attr($this->get_settings('image_animation')) . ' bdt-background-cover bdt-transition-opaque bdt-flex" title="' . esc_attr(get_the_title()) . '" style="background-image: url(' . esc_url($image_src) . ')">
  				</a>
			</div>';
	}

	public function render_title() {

		if ( ! $this->get_settings('show_title') ) {
			return;
		}
		
		echo 
			'<h4 class="bdt-post-grid-title">
				<a href="' . esc_url(get_permalink()) . '" class="bdt-post-grid-link" title="' . esc_attr(get_the_title()) . '">
					' . esc_html(get_the_title())  . '
				</a>
			</h4>';
	}

	public function render_author() {

		if ( ! $this->get_settings('show_author') ) {
			return;
		}
		
		echo 
			'<span class="bdt-post-grid-author"><a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author().'</a></span>';		
	}

	public function render_date() {

		if ( ! $this->get_settings('show_date') ) {
			return;
		}
		
		echo 
			'<span class="bdt-post-grid-date">'.esc_attr(get_the_date('M d, Y')).'</span>';		
	}

	public function render_comments() {

		if ( ! $this->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<div class="bdt-post-grid-comments bdt-position-medium bdt-position-bottom-right"><span><i class="fa fa-comments-o" aria-hidden="true"></i> '.get_comments_number().'</span></div>';
	}

	public function render_category() {

		if ( ! $this->get_settings( 'show_category' ) ) { return; }
		?>
		<div class="bdt-post-grid-category bdt-position-small bdt-position-top-left">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_excerpt($excerpt_length ) {

		if ( ! $this->get_settings('show_excerpt') ) {
			return;
		}
		
		echo 
			'<div class="bdt-post-grid-excerpt">' . \element_pack_helper::custom_excerpt( $excerpt_length) . '</div>';
	}

	public function render_readmore() {

		if ( ! $this->get_settings('show_readmore') ) {
			return;
		}
		
		$animation = ($this->get_settings('readmore_hover_animation')) ? ' elementor-animation-'.$this->get_settings('readmore_hover_animation') : '';

		echo 
			'<a href="' . esc_url(get_permalink()) . '" class="bdt-post-grid-readmore bdt-display-inline-block' . esc_attr($animation) . '">
				' . esc_html($this->get_settings('readmore_text'));
				
				if ($this->get_settings('icon')) :
					echo
						'<span class="bdt-button-icon-align-' . esc_attr($this->get_settings('icon_align')) . '">
							<i class="' . esc_attr($this->get_settings('icon')) . '"></i>
						</span>';
				endif;
		echo
			'</a>';
	}

	public function render_post_grid_item( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->get_settings();

		?>
		<div class="bdt-post-grid-item bdt-transition-toggle bdt-position-relative">
								
			<?php $this->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>

			<div class="bdt-custom-overlay bdt-position-cover"></div>
	  		
	  		<div class="bdt-post-grid-desc bdt-position-medium bdt-position-bottom-left">

				<?php $this->render_title(); ?>

            	<?php if ($settings['show_author'] or $settings['show_date']) : ?>
					<div class="bdt-post-grid-meta bdt-subnav bdt-flex-middle">
						<?php $this->render_author(); ?>
						<?php $this->render_date(); ?>
					</div>
				<?php endif; ?>

				<?php $this->render_excerpt($excerpt_length); ?>
				<?php $this->render_readmore(); ?>

			</div>

			<?php $this->render_category(); ?>
			<?php $this->render_comments(); ?>

		</div>
		<?php
	}


	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->query_posts(5);
		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		?> 
		<div id="bdt-post-grid-<?php echo esc_attr($id); ?>" class="bdt-post-grid bdt-post-grid-skin-default">
	  		<div class="bdt-grid bdt-grid-<?php echo esc_attr($settings['column_gap']); ?>" bdt-grid>

				<?php $bdt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
						
		  			$bdt_count++;

		  			if ( $bdt_count <= 2) {
		  				$bdt_grid_raw = 2;
		  				$bdt_post_class = ' bdt-primary';
		  				$thumbnail_size = $settings['primary_thumbnail_size'];
		  			} else {
		  				$bdt_grid_raw = 3;
		  				$bdt_post_class = ' bdt-secondary';
		  				$thumbnail_size = $settings['secondary_thumbnail_size'];
		  			}

		  			$bdt_grid_raw = ( $bdt_count <= 2) ? 2 : 3;
		  			$bdt_post_class = ( $bdt_count <= 2) ? ' bdt-primary' : ' bdt-secondary';
		  			?>

		  			<div class="bdt-width-1-<?php echo esc_attr($bdt_grid_raw); ?>@m<?php echo esc_attr($bdt_post_class); ?>">
						<?php $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	
 		<?php 

 		if ($settings['show_pagination']) {
 			element_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}