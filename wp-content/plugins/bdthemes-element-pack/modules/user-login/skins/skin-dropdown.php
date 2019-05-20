<?php
namespace ElementPack\Modules\UserLogin\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

use Elementor\Skin_Base as Elementor_Skin_Base;
use ElementPack\Element_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Dropdown extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/bdt-user-login/section_style/before_section_start', [ $this, 'register_dropdown_button_style_controls' ] );
		
		add_action( 'elementor/element/bdt-user-login/section_forms_additional_options/before_section_start', [ $this, 'register_dropdown_button_controls' ] );

	}

	public function get_id() {
		return 'bdt-dropdown';
	}

	public function get_title() {
		return __( 'Dropdown', 'bdthemes-element-pack' );
	}

	public function register_dropdown_button_controls() {

		$this->start_controls_section(
			'section_dropdown_button',
			[
				'label' => esc_html__( 'Dropdown Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Log In', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_size',
			[
				'label'   => esc_html__( 'Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => element_pack_button_sizes(),
			]
		);

		$this->add_responsive_control(
			'dropdown_button_align',
			[
				'label' => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'dropdown_button_icon',
			[
				'label'       => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'dropdown_button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'After', 'bdthemes-element-pack' ),
				],
				'condition' => [
					$this->get_control_id( 'dropdown_button_icon!' ) => '',
				],
			]
		);

		$this->add_control(
			'dropdown_button_icon_indent',
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
					$this->get_control_id( 'dropdown_button_icon!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown .bdt-button-dropdown-icon.elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-button-dropdown .bdt-button-dropdown-icon.elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function register_dropdown_button_style_controls() {
		$this->start_controls_section(
			'section_style_dropdown_button',
			[
				'label' => esc_html__( 'Dropdown Button', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_button_style' );

		$this->start_controls_tab(
			'tab_dropdown_button_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-button-dropdown',
			]
		);

		$this->add_control(
			'dropdown_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'dropdown_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-button-dropdown',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'dropdown_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-button-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-button-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_button_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button-dropdown:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'dropdown_button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'dropdown_button_animation',
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

	public function render() {
		$settings = $this->parent->get_settings();
		$id       = 'dropdown' . $this->parent->get_id();
		
		if ( is_user_logged_in() && ! Element_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			
			$this->parent->add_render_attribute(
				[
					'dropdown-button' => [
						'class' => [
							'elementor-button',
							'bdt-button-dropdown',
							'elementor-size-' . $this->get_instance_value('dropdown_button_size'),
							$this->get_instance_value('dropdown_button_animation') ? 'elementor-animation-' . $this->get_instance_value('dropdown_button_animation') : ''

						],
						'href' => ($settings['show_edit_profile']) ? get_edit_user_link() : '#',
					]
				]
			);

			
			$current_user = wp_get_current_user();

			?>
			<div id="<?php echo esc_attr($id); ?>" class="bdt-user-login bdt-user-login-skin-dropdown">
				<a <?php echo $this->parent->get_render_attribute_string('dropdown-button'); ?>>
					<?php if ( $settings['show_logged_in_message'] ) : ?>
					<span class="bdt-user-name"><?php esc_html_e( 'Hi', 'bdthemes-element-pack' ); ?>, <?php echo $current_user->display_name; ?></span>
					<?php endif; ?>

					<?php if ( $settings['show_avatar_in_button'] ) : ?>
						<span class="bdt-user-login-button-avatar"><?php echo get_avatar( $current_user->user_email, 16 ); ?></span>
					<?php endif; ?>
					
				</a>
				
				<?php $this->parent->user_dropdown_menu(); ?>
				
			</div>
			<?php

			return;
		} else {

			$dropdown_offset = $settings['dropdown_offset'];
			$this->parent->add_render_attribute(
				[
					'dropdown-settings' => [
						'bdt-dropdown' => [
							wp_json_encode(array_filter([
								"mode"   => $settings["dropdown_mode"],
								"pos"    => $settings["dropdown_position"],
								"offset" => $dropdown_offset["size"]
							]))
						]
					]
				]
			);

			$this->parent->add_render_attribute( 'dropdown-settings', 'class', 'bdt-dropdown' );
		}

		$this->parent->form_fields_render_attributes();

		$this->parent->add_render_attribute(
			[
				'dropdown-button-settings' => [
					'class' => [
						'elementor-button',
						'bdt-button-dropdown',
						'elementor-size-' . $this->get_instance_value('dropdown_button_size'),
						$this->get_instance_value('dropdown_button_animation') ? 'elementor-animation-' . $this->get_instance_value('dropdown_button_animation') : ''

					],
					'href' => 'javascript:void(0)',
				]
			]
		);

		?>
		<div id="<?php echo esc_attr($id); ?>" class="bdt-user-login bdt-user-login-skin-dropdown">
			<a <?php echo $this->parent->get_render_attribute_string('dropdown-button-settings'); ?>>
				<?php $this->render_text(); ?>
			</a>

			<div <?php echo $this->parent->get_render_attribute_string('dropdown-settings'); ?>>

				<div class="elementor-form-fields-wrapper bdt-text-left">
					<?php $this->parent->user_login_form(); ?>
				</div>

			</div>
		</div>
		<?php

		$this->parent->user_login_ajax_script();
	}

	protected function render_text() {

		$this->parent->add_render_attribute('button-icon', 'class', ['bdt-button-dropdown-icon', 'elementor-button-icon', 'elementor-align-icon-' . $this->get_instance_value('dropdown_button_icon_align')]);

		if ( is_user_logged_in() && ! Element_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( 'Logout', 'bdthemes-element-pack' );
		} else {
			$button_text = $this->get_instance_value('dropdown_button_text');
		}

		$dropdown_button_icon = $this->get_instance_value('dropdown_button_icon');
		
		?>
		<span class="elementor-button-content-wrapper">
			<?php if ( ! empty( $dropdown_button_icon ) ) : ?>
			<span <?php echo $this->parent->get_render_attribute_string('button-icon'); ?>>
				<i class="<?php echo esc_attr( $dropdown_button_icon ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span class="elementor-button-text">
				<?php echo esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}
}

