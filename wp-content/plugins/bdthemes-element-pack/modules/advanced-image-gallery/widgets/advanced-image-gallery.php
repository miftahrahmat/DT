<?php
namespace ElementPack\Modules\AdvancedImageGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

use ElementPack\Modules\AdvancedImageGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Image_Gallery extends Widget_Base {
	
	public $lightbox_slide_index;

	public function get_name() {
		return 'bdt-advanced-image-gallery';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Advanced Image Gallery', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-advanced-image-gallery';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'advanced', 'image', 'gallery', 'photo' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'bdt-uikit-icons', 'tilt' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Hidden( $this ) );
		$this->add_skin( new Skins\Skin_Carousel( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'avd_gallery_images',
			[
				'label'   => __( 'Add Images', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::GALLERY,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'exclude'   => [ 'custom' ],
				'condition' => ['_skin!' => 'bdt-hidden'],
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'     => esc_html__( 'Masonry', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => ['_skin!' => 'bdt-hidden'],
			]
		);

		$this->add_responsive_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Image Height', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 265,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'#bdt-avdg-{{ID}} .bdt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'bdt-hidden'
						],
						[
							'name'     => 'masonry',
							'operator' => '!=',
							'value'    => 'yes'
						],
					]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_gallery_layout',
			[
				'label'     => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '3',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => ['_skin!' => 'bdt-hidden'],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => 'bdt-hidden',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_lightbox',
			[
				'label'     => esc_html__( 'Show Lightbox', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__('Icon', 'bdthemes-element-pack'),
					'text' => esc_html__('Text', 'bdthemes-element-pack'),
				],
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link .bdt-icon'     => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-gallery-item-link .bdt-icon svg' => 'width: {{SIZE}}px; height: auto;',
				],
				'condition' => [
					'link_type' => 'icon',
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'       => esc_html__( 'Show Caption', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Make sure you set the caption in gallery images when you insert.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
				'condition' => ['_skin!' => 'bdt-hidden'],
			]
		);

		$this->add_control(
			'caption_all_time',
			[
				'label'     => esc_html__( 'Caption all Time', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_caption' => 'yes',
					'_skin!' => 'bdt-hidden',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label'     => esc_html__( 'Additional', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'overlay_content_alignment',
			[
				'label'   => __( 'Overlay Content Alignment', 'bdthemes-element-pack' ),
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'show_lightbox' => 'yes',
					'show_caption'  => 'yes',
				],
			]
		);



		$this->add_control(
			'overlay_content_position',
			[
				'label'       => __( 'Overlay Content Vertical Position', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
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
				'default'   => 'middle',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'justify-content: {{VALUE}}',
				],
				'condition' => [
					'show_lightbox' => 'yes',
					'show_caption'  => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'caption_position',
			[
				'label'     => esc_html__( 'Caption Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => element_pack_position(),
				'condition' => [
					'show_caption'     => 'yes',
					'caption_all_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'tilt_show',
			[
				'label' => esc_html__( 'Tilt Effect', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition' => [
					'_skin!'            => 'bdt-hidden',
					'caption_all_time!' => 'yes',
				],
			]
		);

		$this->add_control(
			'tilt_scale',
			[
				'label' => esc_html__( 'Tilt Scale', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 2,
						'step'=> 0.1,
					],
				],
				'condition' => [
					'tilt_show' => 'yes',
					'caption_all_time!' => 'yes',
				],
				'separator' => 'after',
			]
		);


		$this->add_control(
			'lightbox_link_type',
			[
				'label'   => esc_html__( 'Lightbox Link Type', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple_text',
				'options' => [
					'simple_text' => esc_html__('Text', 'bdthemes-element-pack'),
					'link_image'  => esc_html__('Image', 'bdthemes-element-pack'),
				],
				'condition' => ['_skin' => 'bdt-hidden'],
			]
		);

		$this->add_control(
			'link_image',
			[
				'label'   => __( 'Link Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],				
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'link_image_size',
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);
		
		$this->add_control(
			'gallery_link_text',
			[
				'label'       => esc_html__( 'Link Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Open Gallery', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Link Text', 'bdthemes-element-pack' ),				
				'condition'   => ['_skin' => 'bdt-hidden', 'lightbox_link_type' => 'simple_text'],
			]
		);

		$this->add_responsive_control(
			'gallery_link_align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
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
				'prefix_class' => 'elementor-align%s-',
				'condition' => ['_skin' => 'bdt-hidden'],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'bdthemes-element-pack' ),
					'fade'  => esc_html__( 'Fade', 'bdthemes-element-pack' ),
					'scale' => esc_html__( 'Scale', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_autoplay',
			[
				'label'   => __( 'Lightbox Autoplay', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_pause',
			[
				'label'   => __( 'Lightbox Pause on Hover', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
					'lightbox_autoplay' => 'yes'
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_carousel_settins',
			[
				'label'     => esc_html__( 'Carousel Settings', 'bdthemes-element-pack' ),
				'condition' => [
					'_skin' => 'bdt-carousel',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Auto Play', 'bdthemes-element-pack' ),
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
				'label'   => esc_html__( 'Pause on Hover', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'center_slide',
			[
				'label' => esc_html__( 'Center Slide', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'condition' => [
					'_skin' => 'bdt-carousel',
				],
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
				'prefix_class' => 'bdt-navigation-type-',
				'render_type'  => 'template',				
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
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
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
			'section_design_layout',
			[
				'label'     => esc_html__( 'Items', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['_skin!' => 'bdt-hidden'],
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'   => esc_html__( 'Overlay Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => element_pack_transition_options(),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-thumbnail',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-thumbnail, {{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_gap',
			[
				'label' => esc_html__( 'Overlay Gap', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-overlay' => 'margin: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => esc_html__( 'Caption', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,				
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'caption_background',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption'
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => __('Padding', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label'      => __('Margin', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'caption_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption'
			]
		);

		$this->add_control(
			'caption_radius',
			[
				'label'      => __('Radius', 'bdthemes-element-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'caption_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-gallery-item .bdt-gallery-item-caption',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Link Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_lightbox' => 'yes',
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
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .bdt-gallery-item-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-gallery-item-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-gallery-item-link',
				'condition' => [
					'show_lightbox' => 'yes',
					'link_type'     => 'text',
				]
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
					'{{WRAPPER}} .bdt-gallery-item-link:hover span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-gallery-item-link:hover' => 'border-color: {{VALUE}};',
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
				'label'      => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => '_skin',
							'value'    => 'bdt-carousel',
						],
						[
							'name'     => 'navigation',
							'operator' => '!=',
							'value'    => 'none',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev svg,
					{{WRAPPER}} .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev,
					{{WRAPPER}} .bdt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev:hover,
					{{WRAPPER}} .bdt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev svg,
					{{WRAPPER}} .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev:hover svg,
					{{WRAPPER}} .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
					'{{WRAPPER}} .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
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

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-navigation-prev,
					{{WRAPPER}} .bdt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .bdt-navigation-prev,
					{{WRAPPER}} .bdt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-slider-dotnav a' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-slider-dotnav a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .bdt-slider-dotnav.bdt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
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
							'value' => 'arrows',
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
					'{{WRAPPER}} .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
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
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
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
					'{{WRAPPER}} .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-navigation-next' => 'right: {{SIZE}}px;',
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
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
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

	public function render_header() {

		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$this->add_render_attribute('advanced-image-gallery', 'id', 'bdt-avdg-' . esc_attr($id) );

		$this->add_render_attribute('advanced-image-gallery', 'class', ['bdt-advanced-image-gallery', 'bdt-skin-default'  ] );
		
		$this->add_render_attribute('advanced-image-gallery', 'bdt-grid', '');
		$this->add_render_attribute('advanced-image-gallery', 'class', ['bdt-grid', 'bdt-grid-small'] );

		
		if ( $settings['caption_all_time'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-caption-all-time-yes');
		}
		
		if ($settings['masonry'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'bdt-grid', 'masonry: true');
		}

		if ($settings['show_lightbox'] or 'bdt-hidden' === $settings['_skin'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'bdt-lightbox', 'animation: ' . $settings['lightbox_animation'] . ';');
			if ($settings['lightbox_autoplay']) {
				$this->add_render_attribute('advanced-image-gallery', 'bdt-lightbox', 'autoplay: 500;');
				
				if ($settings['lightbox_pause']) {
					$this->add_render_attribute('advanced-image-gallery', 'bdt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns_mobile']));
		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns_tablet']) .'@s');
		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-' . esc_attr($settings['columns']) .'@m');

		?>
		<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
		<?php
	}

	private function render_loop_item($settings) {

		$this->add_render_attribute('advanced-image-gallery-item', 'class', ['bdt-gallery-item', 'bdt-transition-toggle']);

		$this->add_render_attribute('advanced-image-gallery-inner', 'class', 'bdt-advanced-image-gallery-inner');
		
		if ($settings['tilt_show']) {
			$this->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
			if ($settings['tilt_scale']['size']) {
				$this->add_render_attribute('advanced-image-gallery-inner', 'data-tilt-scale', $settings['tilt_scale']['size']);
			}
		}

		foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>

			<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-inner' ); ?>>
					<?php
					$this->render_thumbnail($item);
					
					if ($settings['show_lightbox'] or ($settings['show_caption'] and 'yes' !== $settings['caption_all_time'] )  )  :
						$this->render_overlay($item);
					endif;

					?>
				</div>
				<?php if ($settings['show_caption'] and 'yes' == $settings['caption_all_time'])  : ?>
					<?php $this->render_caption($item); ?>
				<?php endif; ?>
			</div>

		<?php endforeach;
	}

	public function render_footer() {
		?>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->render_header($settings, $id, $skin = 'standard');
		$this->render_loop_item($settings);
		$this->render_footer();
	}

	public function render_thumbnail($item) {
		$settings  = $this->get_settings();
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings ); 					

		echo '<div class="bdt-gallery-thumbnail bdt-transition-toggle">
			<img src="'.esc_url($image_url).'" alt="'.esc_attr( Control_Media::get_image_alt( $item ) ).'">
		</div>';
	}

	public function render_caption($text) {
		$image_caption = get_post($text['id']);
		$settings      = $this->get_settings();

		$this->add_render_attribute( 'caption', 'class', 'bdt-gallery-item-caption bdt-display-inline-block', true );
		
		if ($settings['caption_all_time']) {
			$this->add_render_attribute( 'caption', 'class', ( '' != $settings['caption_position'] ) ? 'bdt-position-' . $settings['caption_position'] : 'bdt-caption-position-default' );
		}

		?>
		<?php if ( ! empty( $image_caption->post_excerpt ) ) : ?>
			<div><div <?php echo $this->get_render_attribute_string( 'caption' ); ?>>
				<?php echo $image_caption->post_excerpt; ?>
			</div></div>
		<?php endif;
	}

	public function render_overlay($content) {
		$settings                  = $this->get_settings();
		$image_caption = get_post($content['id']);
		$overlay_settings          = [];
		
		$this->add_render_attribute( 'overlay-settings', 'class', ['bdt-position-cover','bdt-overlay','bdt-overlay-default'], true );
		
		if ($settings['overlay_animation']) {
			$this->add_render_attribute( 'overlay-settings', 'class', 'bdt-transition-' . $settings['overlay_animation']);
		}

		?>
		<div <?php echo $this->get_render_attribute_string('overlay-settings'); ?>>
			<div class="bdt-advanced-image-gallery-content">
				<div class="bdt-advanced-image-gallery-content-inner">
				
					<?php $this->add_render_attribute(
						[
							'overlay-lightbox-attr' => [
								'class' => [
									'bdt-gallery-item-link',
									'elementor-clickable',
									'icon-type-' . $settings['link_type'],
								],
								'data-elementor-open-lightbox' => 'no',
								'data-caption'                 => $image_caption->post_excerpt,
							],
						], '', '', true
					);

					$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

					if ( ! $image_url ) {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $content['url'], true );
					} else {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $image_url[0], true );
					}
					
					?>
					<?php if ( 'yes' == $settings['show_lightbox'] )  : ?>
						<div class="bdt-flex-inline bdt-gallery-item-link-wrapper">
							<a <?php echo $this->get_render_attribute_string( 'overlay-lightbox-attr' ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span bdt-icon="icon: plus; ratio: 1.6"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="bdt-text"><?php echo esc_html_x( 'ZOOM', 'Advanced Image Gallery String', 'bdthemes-element-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>

					<?php if ($settings['show_caption'] and 'yes' != $settings['caption_all_time'])  : ?>
						<?php $this->render_caption($content); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function link_only($content) {
		$settings      = $this->get_settings();
		$image_caption = get_post($content['id']);
		$link_count    = 1;

		$this->add_render_attribute(
			[
				'lightbox-attributes' => [
					'class' => [
						'elementor-clickable',
						'icon-type-' . $settings['link_type'],
						$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : '',
					],
					'data-elementor-open-lightbox' => 'no',
					'data-caption'                 => $image_caption->post_excerpt,
				],
			], '', '', true
		);

		$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

		if ( ! $image_url ) {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $content['url'], true );
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $image_url[0], true );
		}

		$this->lightbox_slide_index++;
		
		if (1 === $this->lightbox_slide_index) {
			$this->add_render_attribute( 'lightbox-attributes', 'class', ['bdt-gallery-item-link', 'bdt-hidden-gallery-button'] );

			if ('simple_text' == $settings['lightbox_link_type']) {
				$link_content = '<span>' . $settings['gallery_link_text'] . '</span>';
			} else {
				$link_image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['link_image']['id'], 'link_image_size', $settings );
				$link_image_src = ($link_image_src) ? $link_image_src : $settings['link_image']['url'];
				$link_content   = '<img src=' . esc_url($link_image_src) . ' alt="' . get_the_title() . '">';
			}			
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '>' . $link_content . '</a>';
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'class', 'bdt-hidden' );
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '></a>';
		}
	}		
}
