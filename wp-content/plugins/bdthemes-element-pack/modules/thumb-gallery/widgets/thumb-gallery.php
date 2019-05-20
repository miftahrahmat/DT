<?php
namespace ElementPack\Modules\ThumbGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

use ElementPack\Modules\QueryControl\Controls\Group_Control_Posts;
use ElementPack\Modules\QueryControl\Module;

use ElementPack\Modules\ThumbGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Thumb_Gallery extends Widget_Base {
	public $_query = null;

	public function get_name() {
		return 'bdt-thumb-gallery';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Thumb Gallery', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-thumb-gallery';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'thumb', 'gallery', 'image', 'photo' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'bdt-uikit-icons' ];
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

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Custom( $this ) );
	}

	public function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'     => esc_html__( 'Limit', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'   => esc_html__( 'Content Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => element_pack_position(),
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_title',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_text',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_button',
                            'value'    => 'yes',
                        ],
                    ],
                ],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_title',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_text',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_button',
                            'value'    => 'yes',
                        ],
                    ],
                ],
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label'   => esc_html__( 'Content Alignment', 'bdthemes-element-pack' ),
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_title',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_text',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_button',
                            'value'    => 'yes',
                        ],
                    ],
                ],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Show Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => element_pack_title_tags(),
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Text Length', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'   => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[
				'label'       => esc_html__( 'Size Ratio', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to widht and height, such as 16:9',
			]
		);

		$this->add_control(
			'slider_min_height',
			[
				'label' => esc_html__( 'Minimum Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_control(
			'slideshow_fullscreen',
			[
				'label' => esc_html__( 'Fullscreen', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label'     => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Read More', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::ICON,
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
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'thumbnavs',
				'options' => [
					'arrows'           => esc_html__( 'Arrows', 'bdthemes-element-pack' ),
					'thumbnavs'        => esc_html__( 'Thumbnavs', 'bdthemes-element-pack' ),
					'arrows-thumbnavs' => esc_html__( 'Arrows and Thumbnavs', 'bdthemes-element-pack' ),
					'none'             => esc_html__( 'None', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation!' => ['thumbnavs', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_position',
			[
				'label'     => esc_html__( 'Thumbnavs Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => element_pack_thumbnavs_position(),
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_outside',
			[
				'label'      => esc_html__( 'Thumbnavs Outside', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['thumbnavs', 'arrows-thumbnavs'],
						],
						[
							'name'     => 'thumbnavs_position',
							'operator' => 'in',
							'value'    => ['center-left', 'center-right'],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'thumbnavs_width',
			[
				'label' => esc_html__( 'Thumbnavs Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 110,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery-thumbnav a' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_responsive_control(
			'thumbnavs_height',
			[
				'label' => esc_html__( 'Thumbnavs Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery-thumbnav a' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->end_controls_section();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label'     => esc_html__( 'Query', 'bdthemes-element-pack' ),
				'condition' => [
					'_skin' => '',
				],
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
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_title',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_text',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_button',
                            'value'    => 'yes',
                        ],
                    ],
                ],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'content_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-content',
			]
		);

		$this->add_control(
			'content_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_transition',
			[
				'label'   => esc_html__( 'Content Transition', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => element_pack_transition_options(),
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
				]
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'text_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_space',
			[
				'label' => esc_html__( 'Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes'
				]
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
			'button_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_space',
			[
				'label' => esc_html__( 'Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button',
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
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumb-gallery-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
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
					'size' => 48,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next:hover svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev svg, {{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'thumbnavs', 'none' ],
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
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows', 'arrows-thumbnavs'],
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
			'heading_thumbnavs',
			[
				'label'     => esc_html__( 'Thumbnavs', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->start_controls_tabs('tabs_thumbnavs_style');

		$this->start_controls_tab(
			'tab_thumbnavs_normal',
			[
				'label'     => esc_html__( 'Normal', 'bdthemes-element-pack' ),
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery-thumbnav a' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'thumbnavs_shadow',
				'selector'  => '{{WRAPPER}} .bdt-thumb-gallery-thumbnav a',
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'thumbnavs_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-thumb-gallery-thumbnav a',
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumb-gallery-thumbnav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_spacing',
			[
				'label' => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-thumbnav:not(.bdt-thumbnav-vertical) > *' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-thumbnav:not(.bdt-thumbnav-vertical)'     => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-thumbnav-vertical > *'                    => 'padding-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-thumbnav-vertical'                        => 'margin-top: -{{SIZE}}{{UNIT}};',

				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnavs_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
				'condition' => [
					'navigation!' => ['arrows', 'both', 'none'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'thumbnavs_hover_shadow',
				'selector'  => '{{WRAPPER}} .bdt-thumb-gallery-thumbnav a:hover',
				'condition' => [
					'navigation!' => ['arrows', 'both', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'thumbnavs_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery-thumbnav a:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'navigation!' => ['arrows', 'both', 'none'],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_position',
			[
				'label'     => esc_html__( 'Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
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
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows', 'arrows-thumbnavs'],
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
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows', 'arrows-thumbnavs'],
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
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows', 'arrows-thumbnavs'],
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
			'thumbnavs_x_position',
			[
				'label'   => __( 'Thumbnavs Horizontal Offset', 'bdthemes-element-pack' ),
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
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->add_control(
			'thumbnavs_y_position',
			[
				'label'   => __( 'Thumbnavs Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-thumb-gallery .bdt-thumbnav-wrapper .bdt-thumbnav' => 'transform: translate({{thumbnavs_x_position.size}}px, {{SIZE}}px);',
				],
				'condition' => [
					'navigation!' => ['arrows', 'none'],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'bdthemes-element-pack' ),
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
				'label' => esc_html__( 'Pause on Hover', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Animation Speed', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'slide',
				'options'   => [
					'slide' => esc_html__( 'Slide', 'bdthemes-element-pack' ),
					'fade'  => esc_html__( 'Fade', 'bdthemes-element-pack' ),
					'scale' => esc_html__( 'Scale', 'bdthemes-element-pack' ),
					'push'  => esc_html__( 'Push', 'bdthemes-element-pack' ),
					'pull'  => esc_html__( 'Pull', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'kenburns_animation',
			[
				'label'     => esc_html__( 'Kenburns Animation', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'kenburns_reverse',
			[
				'label'     => esc_html__( 'Kenburn Reverse', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'kenburns_animation' => 'yes'
				]
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

	public function query_posts() {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $this->get_settings( 'posts_per_page' );

		$this->_query = new \WP_Query( $query_args );
	}

	public function render() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 15 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 15 );

		$this->render_header();

		$this->render_post();
		
		$this->render_footer();

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 15 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 15 );

		wp_reset_postdata();
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );
		$classes = ['bdt-thumb-gallery-title'];
		?>

		<<?php echo $tag ?> class="<?php echo implode(" ", $classes); ?>">
			<?php the_title(); ?>
		</<?php echo $tag; ?>>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="bdt-thumb-gallery-text bdt-text-small">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_button() {
		if ( ! $this->get_settings( 'show_button' ) ) {
			return;
		}

		$settings  = $this->get_settings();
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';
		
		?>
			<div class="bdt-thumb-gallery-button-wrapper">
				<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-thumb-gallery-button bdt-display-inline-block<?php echo esc_attr($animation); ?>">
					<?php echo esc_attr($settings['button_text']); ?>
				
					<?php if ($settings['icon']) : ?>
						<span class="bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
							<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
						</span>
					<?php endif; ?>
				</a>
			</div>
		<?php
	}

	public function render_header() {
		$id       = $this->get_id();
		$settings = $this->get_settings();

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '';

	    $this->add_render_attribute(
			[
				'slider-settings' => [
					'class'         => [
						'bdt-position-relative',
						'bdt-visible-toggle'
					],
					'bdt-slideshow' => [
						wp_json_encode(array_filter([
							"animation"         => $settings["slider_animations"],
							"ratio"             => $ratio,
							"min-height"        => $settings["slider_min_height"]["size"],
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"pause-on-hover"    => $settings["pause_on_hover"]
						]))
					]
				]
			]
		);

		?>
		<div id="bdt-thumb-gallery-<?php echo esc_attr($id); ?>" class="bdt-thumb-gallery">
			<div <?php echo ( $this->get_render_attribute_string( 'slider-settings' ) ) ?>>
		<?php
	}

	public function render_footer() {
		?>
			</div>
		</div>
		<?php
	}

	public function render_loop_items() {
		$settings         = $this->get_settings();
		$kenburns_reverse = $settings['kenburns_reverse'] ? ' bdt-animation-reverse' : '';
		
		$this->query_posts();

		$content_transition = $settings['content_transition'] ? ' bdt-transition-' . $settings['content_transition'] : '';

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$fullscreen = $settings['slideshow_fullscreen'] ? ' bdt-height-viewport="offset-top: true;"' : '';

		?>
		<ul class="bdt-slideshow-items"<?php echo $fullscreen; ?>>

		<?php
		
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();			

			$placeholder_image_src = Utils::get_placeholder_image_src();

			$gallery_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

			if ( ! $gallery_thumbnail ) {
				$gallery_thumbnail = $placeholder_image_src;
			} else {
				$gallery_thumbnail = $gallery_thumbnail[0];
			}

			?>
			<li class="bdt-slideshow-item">
				<?php if( $settings['kenburns_animation'] ) : ?>
					<div class="bdt-position-cover bdt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> bdt-transform-origin-center-left">
				<?php endif; ?>

					<img src="<?php echo esc_url($gallery_thumbnail); ?>" alt="<?php echo get_the_title(); ?>" bdt-cover>

				<?php if( $settings['kenburns_animation'] ) : ?>
		            </div>
		        <?php endif; ?>
				<div class="bdt-position-z-index bdt-position-<?php echo $settings['content_position']; ?> bdt-position-large">
					<?php if ( $settings['show_title'] || $settings['show_text'] || $settings['show_button'] ) : ?>
						<div class="bdt-text-<?php echo $settings['content_align']; ?>">
							<div class="bdt-thumb-gallery-content<?php echo esc_attr($content_transition); ?>">
					        	<?php $this->render_title(); ?>
					        	<?php $this->render_excerpt(); ?>
					        	<?php $this->render_button(); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</li>
			<?php
		}

		wp_reset_postdata();

		?>
    	</ul>
    	<?php
	}

	public function render_navigation() {
		$settings = $this->get_settings();

		if ( 'thumbnavs' == $settings['navigation'] || 'none' == $settings['navigation'] ) {
			return;
		}

		?>
		<div class="bdt-thumb-gallery-navigation-wrapper bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($settings['arrows_position']); ?>">
			<div class="bdt-arrows-container bdt-slidenav-container">
				<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slideshow-item="previous"></a>
				<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slideshow-item="next"></a>
			</div>
		</div>
    	<?php
	}

	public function render_thumbnavs() {
		$settings = $this->get_settings();

		if ( 'arrows' == $settings['navigation'] or 'none' == $settings['navigation'] ) {
			return;
		}
		$thumbnavs_outside = '';
		$vertical_thumbnav = '';
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
		if  ( 'center-left' == $settings['thumbnavs_position'] || 'center-right' == $settings['thumbnavs_position'] ) {
			if ($settings['thumbnavs_outside']) {
				$thumbnavs_outside = '-out';
			}
			$vertical_thumbnav = ' bdt-thumbnav-vertical';
		}

		?>
		<div class="bdt-thumbnav-wrapper bdt-position-<?php echo esc_attr($settings['thumbnavs_position'].$thumbnavs_outside); ?> bdt-position-small">
        	<ul class="bdt-thumbnav<?php echo esc_attr($vertical_thumbnav); ?>">

		<?php		
		$bdt_counter = 0;
		      
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();			

			$placeholder_image_src = Utils::get_placeholder_image_src();

			$gallery_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );

			if ( ! $gallery_thumbnail ) {
				$gallery_thumbnail = $placeholder_image_src;
			} else {
				$gallery_thumbnail = $gallery_thumbnail[0];
			}

			echo '<li class="bdt-thumb-gallery-thumbnav" bdt-slideshow-item="' . $bdt_counter . '"><a class="bdt-overflow-hidden bdt-background-cover" href="#" style="background-image: url(' . esc_url($gallery_thumbnail) . ')"></a></li>';
			$bdt_counter++;
		}

		wp_reset_postdata();
		
		?>
        	</ul>
		</div>
        	<?php
	}

	public function render_post() {
		$this->render_loop_items();
		$this->render_navigation();
		$this->render_thumbnavs();
	}
}
