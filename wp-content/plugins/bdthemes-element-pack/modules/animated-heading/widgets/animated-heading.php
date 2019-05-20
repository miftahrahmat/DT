<?php
namespace ElementPack\Modules\AnimatedHeading\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AnimatedHeading extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'bdt-animated-heading';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Animated Heading', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-animated-heading';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'animated', 'heading', 'headline', 'vivid' ];
	}

	public function get_script_depends() {
		return [ 'morphext', 'typed' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => esc_html__( 'Heading', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'heading_layout',
			[
				'label'   => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'animated' => esc_html__( 'Animated', 'bdthemes-element-pack' ),
					'typed'    => esc_html__( 'Typed', 'bdthemes-element-pack' ),
				],
				'default' => 'animated',
			]
		);

		$this->add_control(
			'pre_heading',
			[
				'label'       => esc_html__( 'Prefix Heading', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your prefix title', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'Hello I am', 'bdthemes-element-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'animated_heading',
			[
				'label'       => esc_html__( 'Heading', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your title', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Write animated heading here with comma separated. Such as Animated, Morphing, Awesome', 'bdthemes-element-pack' ),
				'default'     => esc_html__( "Animated,Morphing,Awesome", 'bdthemes-element-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'post_heading',
			[
				'label'       => esc_html__( 'Post Heading', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your suffix title', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'Heading', 'bdthemes-element-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => esc_html__( 'HTML Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => element_pack_title_tags(),
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
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
				'default'      => 'center',
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_animation',
			[
				'label'     => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'heading_animation!' => '',
				],
			]
		);

		$this->add_control(
			'heading_animation',
			[
				'label'       => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ANIMATION,
				'default'     => 'fadeIn',
				'label_block' => true,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'animated',
				],
			]
		);

		$this->add_control(
			'heading_animation_duration',
			[
				'label'   => esc_html__( 'Animation Duration', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''     => esc_html__( 'Normal', 'bdthemes-element-pack' ),
					'slow' => esc_html__( 'Slow', 'bdthemes-element-pack' ),
					'fast' => esc_html__( 'Fast', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'animated',
				],
			]
		);

		$this->add_control(
			'heading_animation_delay',
			[
				'label'     => esc_html__( 'Animation Delay', 'bdthemes-element-pack' ) . ' (ms)',
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2500,
				'min'       => 100,
				'max'       => 7000,
				'step'      => 100,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'animated',
				],
			]
		);

		$this->add_control(
			'type_speed',
			[
				'label'     => esc_html__( 'Type Speed', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 60,
				'min'       => 10,
				'max'       => 100,
				'step'      => 5,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'typed',
				],
			]
		);

		$this->add_control(
			'start_delay',
			[
				'label'     => esc_html__( 'Start Delay', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'typed',
				],
			]
		);

		$this->add_control(
			'back_speed',
			[
				'label'     => esc_html__( 'Back Speed', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 30,
				'min'       => 0,
				'max'       => 100,
				'step'      => 2,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'typed',
				],
			]
		);

		$this->add_control(
			'back_delay',
			[
				'label'     => esc_html__( 'Back Delay', 'bdthemes-element-pack' ) . ' (ms)',
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'min'       => 0,
				'max'       => 3000,
				'step'      => 50,
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'typed',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'     => esc_html__( 'Loop', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'heading_animation!' => '',
					'heading_layout'     => 'typed',
				],
			]
		);

		$this->add_control(
			'loop_count',
			[
				'label'     => esc_html__( 'Loop Count', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'condition' => [
					'loop'           => 'yes',
					'heading_layout' => 'typed',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_animated_heading',
			[
				'label' => esc_html__( 'Heading', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'animated_heading_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-heading .bdt-heading-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'animated_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-heading-tag',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'animated_heading_shadow',
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-heading-tag',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pre_heading',
			[
				'label'     => esc_html__( 'Pre Heading', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pre_heading!' => '',
				]
			]
		);

		$this->add_control(
			'pre_heading_color',
			[
				'label'     => esc_html__( 'Pre Heading Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-heading .bdt-pre-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pre_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-pre-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'pre_heading_shadow',
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-pre-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_post_heading',
			[
				'label'     => esc_html__( 'Post Heading', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_heading!' => '',
				]
			]
		);

		$this->add_control(
			'post_heading_color',
			[
				'label'     => esc_html__( 'Post Heading Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-heading .bdt-post-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-post-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'post_heading_shadow',
				'selector' => '{{WRAPPER}} .bdt-heading .bdt-post-heading',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings();
		$id            = $this->get_id();
		$final_heading = '';
		$heading_html  = [];
		$type_heading = explode(",", esc_html($settings['animated_heading']) );

		if ( empty( $settings['pre_heading'] ) and empty( $settings['animated_heading'] ) and empty( $settings['post_heading'] ) ) {
			return;
		}

		$this->add_render_attribute( 'heading', 'class', 'bdt-heading-tag' );
		$this->add_render_attribute( 'heading', 'style', 'opacity: 0;' );
		
		$this->add_render_attribute( 'animated-heading', 'id', 'bdt-ah-' . $id );
		$this->add_render_attribute( 'animated-heading', 'class', 'bdt-animated-heading' );
		
		if ( 'animated' == $settings['heading_layout'] ) {
			if ($settings['heading_animation_duration']) {
				$this->add_render_attribute( 'animated-heading', 'class', ' bdt-animated-' . $settings['heading_animation_duration'] );
			}
			$this->add_render_attribute(
				[
					'animated-heading' => [
						'data-settings' => [
							wp_json_encode(array_filter([
								'layout'    => $settings['heading_layout'],
								'animation' => $settings['heading_animation'],
								'speed'     => $settings['heading_animation_delay'],
					        ]))
						]
					]
				]
			);
		} elseif ( 'typed' == $settings['heading_layout'] ) {
			$this->add_render_attribute(
				[
					'animated-heading' => [
						'data-settings' => [
							wp_json_encode(array_filter([
								'layout'     => $settings['heading_layout'],
								'strings'    => $type_heading,
								'typeSpeed'  => $settings['type_speed'],
								'startDelay' => $settings['start_delay'],
								'backSpeed'  => $settings['back_speed'],
								'backDelay'  => $settings['back_delay'],
								'loop'       => ( $settings['loop'] ) ? true : false,
								'loopCount'  => ( $settings['loop_count'] ) ? $settings['loop_count'] : '0',
					        ]))
						]
					]
				]
			);
		}




		if ($settings['pre_heading']) {
			$final_heading .= '<div class="bdt-pre-heading">'.esc_attr($settings['pre_heading']).'</div> ';
		}

		   	$final_heading .= '<div ' . $this->get_render_attribute_string( 'animated-heading' ) . '>';
			
			if ($settings['animated_heading'] and 'animated' == $settings['heading_layout']) {
		   		$final_heading .= rtrim(esc_attr($settings['animated_heading']), ',');
			}

			$final_heading .= '</div> ';

		if ($settings['post_heading']) {
			$final_heading .= '<div class="bdt-post-heading">'.esc_attr($settings['post_heading']).'</div>';
		}


		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$final_heading = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $final_heading );
		}

		$heading_html[] = '<div id ="bdtah-'.$id.'" class="bdt-heading">';
		
		
		$heading_html[] = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'heading' ), $final_heading );
		
		$heading_html[] = '</div>';

		echo implode("", $heading_html);

		
	}

	

}
