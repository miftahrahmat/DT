<?php
namespace ElementPack\Modules\Table\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Table extends Widget_Base {
	public function get_name() {
		return 'bdt-table';
	}

	public function get_title() {
		return BDTEP . __( 'Table', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-wi-table';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_keywords() {
		return [ 'table', 'row', 'column' ];
	}

	public function get_script_depends() {
		return [ 'datatables' ];
	}

	public function get_style_depends() {
		return [ 'datatables' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_table',
			[
				'label' => __( 'Table', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => __( 'Source', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'   => __( 'Custom', 'bdthemes-element-pack' ),
					'csv_file' => __( 'CSV File', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => __( 'Content', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( '<table><thead><tr><th>Name</th><th>Age</th><th>Phone</th></tr></thead><tbody><tr><td>Tom</td><td>5</td><td>010281065</td></tr><tr><td>Jerry</td><td>4</td><td>012540515</td></tr><tr><td>Halum</td><td>12</td><td>011511441</td></tr></tbody></table>', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Table Data', 'bdthemes-element-pack' ),
				'rows'        => 10,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'file',
			[
				'label'         => __( 'Enter a CSV File URL', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'label_block'   => true,
				'default'       => [
					'url' => BDTEP_ASSETS_URL . 'others/table.csv',
				],
				'condition'     => [
					'source' => 'csv_file',
				],
			]
		);

		$this->add_control(
			'header_align',
			[
				'label'   => __( 'Header Alignment', 'bdthemes-element-pack' ),
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'body_align',
			[
				'label'   => __( 'Body Alignment', 'bdthemes-element-pack' ),
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .bdt-table table' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'use_data_table',
			[
				'label'   => esc_html__( 'Datatable', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_data_table',
			[
				'label'     => __( 'Data Table Settings', 'bdthemes-element-pack' ),
				'condition' => [
					'use_data_table' => 'yes',
				],
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
			'show_pagination',
			[
				'label'   => esc_html__( 'Pagination', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_info',
			[
				'label'   => esc_html__( 'Info', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table',
			[
				'label' => __( 'Table', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stripe_style',
			[
				'label' => __( 'Stripe Style', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'table_border_style',
			[
				'label'   => __( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'bdthemes-element-pack' ),
					'solid'  => __( 'Solid', 'bdthemes-element-pack' ),
					'double' => __( 'Double', 'bdthemes-element-pack' ),
					'dotted' => __( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => __( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => __( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table table' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_border_width',
			[
				'label'   => __( 'Border Width', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table table' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .bdt-table table' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => __( 'Header', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7ebef',
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_border_style',
			[
				'label'   => __( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'bdthemes-element-pack' ),
					'solid'  => __( 'Solid', 'bdthemes-element-pack' ),
					'double' => __( 'Double', 'bdthemes-element-pack' ),
					'dotted' => __( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => __( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => __( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_border_width',
			[
				'label'   => __( 'Border Width', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'header_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_body',
			[
				'label' => __( 'Body', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cell_border_style',
			[
				'label'   => __( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'bdthemes-element-pack' ),
					'solid'  => __( 'Solid', 'bdthemes-element-pack' ),
					'double' => __( 'Double', 'bdthemes-element-pack' ),
					'dotted' => __( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => __( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => __( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_width',
			[
				'label'   => __( 'Border Width', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => __( 'Cell Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0.5,
					'bottom' => 0.5,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs('tabs_body_style');

		$this->start_controls_tab(
			'tab_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'normal_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .bdt-table td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'row_hover_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-bdt-table .bdt-table table tr:hover td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'row_hover_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-bdt-table .bdt-table table tr:hover td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stripe',
			[
				'label'     => __( 'Stripe', 'bdthemes-element-pack' ),
				'condition' => [
					'stripe_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .even td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stripe_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .even td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filter_style',
			[
				'label'      => esc_html__( 'Filter', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('filter_style');
		
		$this->start_controls_tab(
			'filter_header_style',
			[
				'label'     => __( 'Header', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'datatable_header_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_length label, {{WRAPPER}} .bdt-table .dataTables_filter label' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);


		$this->add_control(
			'datatable_header_input_color',
			[
				'label'     => esc_html__( 'Input Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'datatable_header_input_background',
			[
				'label'     => esc_html__( 'Input Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'datatable_header_input_padding',
			[
				'label'      => esc_html__( 'Input Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'datatable_header_input_border',
				'label'       => esc_html__( 'Input Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select',
			]
		);

		$this->add_responsive_control(
			'datatable_header_input_radius',
			[
				'label'      => esc_html__( 'Input Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'datatable_header_input_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-table .dataTables_filter input, {{WRAPPER}} .bdt-table .dataTables_length select',
			]
		);

		$this->add_control(
			'datatable_header_space',
			[
				'label'   => __( 'Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 40,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_filter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_footer_style',
			[
				'label'     => __( 'Footer', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'datatable_footer_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_info, {{WRAPPER}} .bdt-table .dataTables_paginate' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'datatable_footer_pagination_color',
			[
				'label'     => esc_html__( 'Pagination Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_paginate a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'datatable_footer_pagination_active_color',
			[
				'label'     => esc_html__( 'Pagination Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table .dataTables_paginate a.current' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'datatable_footer_space',
			[
				'label'   => __( 'Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 40,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-table table' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = 'bdt-table-' . $this->get_id();

		$this->add_render_attribute( 'table', 'class', 'bdt-table' );
		$this->add_render_attribute( 'table', 'class', $settings['stripe_style'] ? 'bdt-stripe' : '' );
		$this->add_render_attribute( 'table', 'id', $id );

		if ( 'yes' == $settings['use_data_table'] ) :
			
			$this->add_render_attribute( 'table', 'class', 'bdt-data-table' );

			$this->add_render_attribute(
				[
					'table' => [
						'data-settings' => [
							wp_json_encode([
								'paging'    => ( 'yes' == $settings['show_pagination'] ) ? true : false,
					    		'info'      => ( 'yes' == $settings['show_info'] ) ? true : false,
					    		'searching' => ( 'yes' == $settings['show_searching'] ) ? true : false,
					    		'ordering'  => ( 'yes' == $settings['show_ordering'] ) ? true : false,
					        ])
						]
					]
				]
			);
		
		endif;

		?>
		<div <?php echo $this->get_render_attribute_string( 'table' ); ?>>
			<?php echo ( 'custom' == $settings['source'] ) ? do_shortcode($settings['content']) : (($settings['file']['url']) ? element_pack_parse_csv(esc_url($settings['file']['url'])) : '<div class="bdt-alert-warning bdt-text-center">Opps!! You didn\'t enter any table data or CSV file'); ?>	
		</div>
		<?php
	}
}
