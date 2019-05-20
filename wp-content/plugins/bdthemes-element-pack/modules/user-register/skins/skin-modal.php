<?php
namespace ElementPack\Modules\UserRegister\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

use Elementor\Skin_Base as Elementor_Skin_Base;
use ElementPack\Element_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Modal extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/bdt-user-register/section_style/before_section_start', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/bdt-user-register/section_forms_additional_options/before_section_start', [ $this, 'register_modal_button_controls' ] );
		add_action( 'elementor/element/bdt-user-register/section_style/before_section_start', [ $this, 'register_modal_button_style_controls' ] );

	}

	public function get_id() {
		return 'bdt-modal';
	}

	public function get_title() {
		return __( 'Modal', 'bdthemes-element-pack' );
	}

	public function register_modal_button_controls(Widget_Base $widget) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_modal_button',
			[
				'label' => esc_html__( 'Modal Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'modal_button_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Register', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'modal_button_size',
			[
				'label'   => esc_html__( 'Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => element_pack_button_sizes(),
			]
		);

		$this->add_responsive_control(
			'modal_button_align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->add_control(
			'modal_button_icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'modal_button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					$this->get_control_id( 'modal_button_icon!' ) => '',
				],
			]
		);

		$this->add_control(
			'modal_button_icon_indent',
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
					$this->get_control_id( 'modal_button_icon!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-button-modal .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
	}

	public function register_modal_button_style_controls(Widget_Base $widget) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_style_modal_button',
			[
				'label' => esc_html__( 'Modal Button', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_modal_button_style' );

		$this->start_controls_tab(
			'tab_modal_button_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'modal_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-button-modal',
			]
		);

		$this->add_control(
			'modal_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'modal_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-button-modal',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'modal_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-button-modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-button-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_button_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'modal_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-modal:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'modal_button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'modal_button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->end_controls_section();
	}

	public function register_controls(Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_modal_style',
			[
				'label' => esc_html__( 'Modal Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'modal_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#modal{{ID}} .bdt-modal-dialog' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'modal_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#modal{{ID}} .bdt-modal-dialog',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'modal_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#modal{{ID}} .bdt-modal-dialog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#modal{{ID}} .bdt-modal-dialog .bdt-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_close_button',
			[
				'label'   => esc_html__( 'Close Button', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'modal_header',
			[
				'label'   => esc_html__( 'Modal Header', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings    = $this->parent->get_settings();
		$id          = 'modal' . $this->parent->get_id();
		$current_url = remove_query_arg( 'fake_arg' );

		$this->parent->add_render_attribute(
			[
				'modal-button' => [
					'class' => [
						'elementor-button',
						'bdt-button-modal',
						'elementor-size-' . $this->get_instance_value('modal_button_size'),
						$this->get_instance_value('modal_button_animation') ? 'elementor-animation-' . $this->get_instance_value('modal_button_animation') : ''
					],
					'href' => wp_logout_url( $current_url )
				]
			]
		);

		if ( is_user_logged_in() && ! Element_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			if ( $settings['show_logged_in_message'] ) {
				?>
				<div id="<?php echo esc_attr($id); ?>" class="bdt-user-register bdt-user-register-skin-dropdown">
					<a <?php echo $this->parent->get_render_attribute_string( 'modal-button' ); ?>>
						<?php $this->render_text(); ?>
					</a>
				</div>
				<?php
			}

			return;
		}

		$this->parent->form_fields_render_attributes();

		$this->parent->add_render_attribute(
			[
				'modal-button-settings' => [
					'class' => [
						'elementor-button',
						'bdt-button-modal',
						'elementor-size-' . $this->get_instance_value('modal_button_size'),
						$this->get_instance_value('modal_button_animation') ? 'elementor-animation-' . $this->get_instance_value('modal_button_animation') : ''
					],
					'href'       => 'javascript:void(0)',
					'bdt-toggle' => 'target: #' . esc_attr($id)
				]
			]
		);

		?>
		<div class="bdt-user-register bdt-user-register-skin-modal">

			<a <?php echo $this->parent->get_render_attribute_string( 'modal-button-settings' ); ?>>
				<?php $this->render_text(); ?>
			</a>
			<div id="<?php echo esc_attr($id); ?>" class="bdt-flex-top bdt-user-register-modal" bdt-modal>
				<div class="bdt-modal-dialog bdt-margin-auto-vertical">
					<?php if ($this->get_instance_value('modal_close_button')) : ?>
						<button class="bdt-modal-close-default" type="button" bdt-close></button>
					<?php endif; ?>
					<?php if ($this->get_instance_value('modal_header')) : ?>
					<div class="bdt-modal-header">
			            <h2 class="bdt-modal-title"><span bdt-icon="user"></span> <?php esc_html_e('User Registration', 'bdthemes-element-pack'); ?></h2>
			        </div>
					<?php endif; ?>
					<div class="elementor-form-fields-wrapper bdt-modal-body">
						<?php $this->parent->user_register_form(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php

		$this->parent->user_register_ajax_script();
	}

	protected function render_text() {		

		$this->parent->add_render_attribute('button-icon', 'class', ['bdt-modal-button-icon', 'elementor-button-icon', 'bdt-button-icon-align-' . $this->get_instance_value('modal_button_icon_align')]);

		if ( is_user_logged_in() && ! Element_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( 'Logout', 'bdthemes-element-pack' );
		} else {
			$button_text = $this->get_instance_value('modal_button_text');
		}

		$modal_button_icon = $this->get_instance_value('modal_button_icon');
		
		?>
		<span class="elementor-button-content-wrapper">
			<?php if ( ! empty( $modal_button_icon ) ) : ?>
			<span <?php echo $this->parent->get_render_attribute_string('button-icon'); ?>>
				<i class="<?php echo esc_attr( $modal_button_icon ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span class="elementor-button-text">
				<?php echo esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}

}

