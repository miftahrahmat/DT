<?php
namespace ElementPack\Modules\AdvancedButton\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class AdvancedButton extends Widget_Base {
	public function get_name() {
		return 'bdt-advanced-button';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Advanced Button', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-advanced-button';
	}	

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'button', 'advanced', 'link' ];
	}

	public function get_style_depends() {
		return [ 'bdt-advanced-button' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Click me', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Click me', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'https://your-link.com', 'bdthemes-element-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Button Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'bdthemes-element-pack' ),
					'sm' => esc_html__( 'Small', 'bdthemes-element-pack' ),
					'md' => esc_html__( 'Medium', 'bdthemes-element-pack' ),
					'lg' => esc_html__( 'Large', 'bdthemes-element-pack' ),
					'xl' => esc_html__( 'Extra Large', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'onclick',
			[
				'label'   => esc_html__( 'OnClick', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
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
					'onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'options'      => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => esc_html__( 'Left', 'bdthemes-element-pack' ),
					'right'  => esc_html__( 'Right', 'bdthemes-element-pack' ),
					'top'    => esc_html__( 'Top', 'bdthemes-element-pack' ),
					'bottom' => esc_html__( 'Bottom', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'bdthemes-element-pack' ),
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
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button .bdt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-advanced-button .bdt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-advanced-button .bdt-button-icon-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-advanced-button .bdt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_effect',
			[
				'label'   => esc_html__( 'Effect', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => esc_html__( 'Effect A', 'bdthemes-element-pack' ),
					'b' => esc_html__( 'Effect B', 'bdthemes-element-pack' ),
					'c' => esc_html__( 'Effect C', 'bdthemes-element-pack' ),
					'd' => esc_html__( 'Effect D', 'bdthemes-element-pack' ),
					'e' => esc_html__( 'Effect E', 'bdthemes-element-pack' ),
					'f' => esc_html__( 'Effect F', 'bdthemes-element-pack' ),
					'g' => esc_html__( 'Effect G', 'bdthemes-element-pack' ),
					'h' => esc_html__( 'Effect H', 'bdthemes-element-pack' ),
					'i' => esc_html__( 'Effect I', 'bdthemes-element-pack' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'attention_button',
			[
				'label' => esc_html__( 'Attention', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'tabs_advanced_button_style' );

		$this->start_controls_tab(
			'tab_advanced_button_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-advanced-button, 
								{{WRAPPER}} .bdt-advanced-button.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:after,
								{{WRAPPER}} .bdt-advanced-button.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:before',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'bdthemes-element-pack' ),
					'solid'  => esc_html__( 'Solid', 'bdthemes-element-pack' ),
					'dotted' => esc_html__( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => esc_html__( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => esc_html__( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
			[
				'label' => esc_html__( 'Border Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'advanced_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-button',
			]
		);

		$this->add_responsive_control(
			'advanced_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'advanced_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-advanced-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_advanced_button_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-advanced-button:after, 
								{{WRAPPER}} .bdt-advanced-button:hover,
								{{WRAPPER}} .bdt-advanced-button.bdt-advanced-button-effect-i,
								{{WRAPPER}} .bdt-advanced-button.bdt-advanced-button-effect-h:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_hover_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'bdthemes-element-pack' ),
					'solid'  => esc_html__( 'Solid', 'bdthemes-element-pack' ),
					'dotted' => esc_html__( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => esc_html__( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => esc_html__( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button:hover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_hover_border_width',
			[
				'label' => esc_html__( 'Border Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_hover_border_style!' => 'none'
				]
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_hover_border_style!' => 'none'
				]
			]
		);

		$this->add_responsive_control(
			'advanced_button_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-button:hover',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_advanced_button_icon_style' );

		$this->start_controls_tab(
			'tab_advanced_button_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_icon_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advanced_button_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'advanced_button_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon:after',
			]
		);

		$this->add_control(
			'advanced_button_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'advanced_button_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon:after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'advanced_button_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-advanced-button .bdt-advanced-button-icon',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_advanced_button_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button:hover .bdt-advanced-button-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advanced_button_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-advanced-button:hover .bdt-advanced-button-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-button:hover .bdt-advanced-button-icon:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_text() {
		$settings = $this->get_settings();
		$this->add_render_attribute( 'content-wrapper', 'class', 'bdt-advanced-button-content-wrapper' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'top' == $settings['icon_align'] ) ? 'bdt-flex bdt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'bottom' == $settings['icon_align'] ) ? 'bdt-flex bdt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper', 'data-text', esc_attr($settings['text']));

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'bdt-advanced-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'bdt-advanced-button-text' );
		$this->add_inline_editing_attributes( 'text', 'none' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
				<div class="bdt-advanced-button-icon bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-advanced-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'advanced_button', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'advanced_button', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'advanced_button', 'rel', 'nofollow' );
			}

		}

		if ( $settings['link']['nofollow'] ) {
			$this->add_render_attribute( 'advanced_button', 'rel', 'nofollow' );
		}

		if ($settings['onclick']) {
			$this->add_render_attribute( 'advanced_button', 'onclick', $settings['onclick_event'] );
		}

		if ($settings['attention_button']) {
			$this->add_render_attribute( 'advanced_button', 'class', 'bdt-ep-attention-button' );
		}

		$this->add_render_attribute( 'advanced_button', 'class', 'bdt-advanced-button' );		
		$this->add_render_attribute( 'advanced_button', 'class', 'bdt-advanced-button-effect-' . esc_attr($settings['button_effect']) );
		$this->add_render_attribute( 'advanced_button', 'class', 'bdt-advanced-button-size-' . esc_attr($settings['button_size']) );
		

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'advanced_button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'advanced_button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}


	protected function _content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 'bdt-advanced-button-text' );

		view.addInlineEditingAttributes( 'text', 'none' );
		
		
		view.addRenderAttribute( 'button', 'onclick', settings.onclick_event );

		var animation = (settings.hover_animation) ? ' elementor-animation-' + settings.hover_animation : '';
		var attention = (settings.attention_button) ? ' bdt-ep-attention-button' : '';

		view.addRenderAttribute( 'content-wrapper', 'class', 'bdt-advanced-button-content-wrapper' );

		if (settings.icon_align == 'bottom') {
			view.addRenderAttribute( 'content-wrapper', 'class', 'bdt-flex bdt-flex-column-reverse' );
		}
		
		view.addRenderAttribute( 'content-wrapper', 'data-text', settings.readmore_text);

		#>
		<div class="elementor-button-wrapper">
			<a class="bdt-advanced-button bdt-advanced-button-effect-{{ settings.button_effect }} bdt-advanced-button-size-{{ settings.button_size }}{{animation}}{{attention}}" href="{{ settings.link.url }}" role="button" {{{ view.getRenderAttributeString( 'button' ) }}}>
				<div {{{ view.getRenderAttributeString( 'content-wrapper' ) }}}>
					<# if ( settings.icon ) { #>
					<div class="bdt-advanced-button-icon bdt-button-icon-align-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}" aria-hidden="true"></i>
					</div>
					<# } #>
					<div {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</div>
				</div>
			</a>
		</div>
		<?php
	}
}
