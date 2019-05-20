<?php
namespace Auxin\Plugin\CoreElements\Elementor\Elements\Theme_Elements;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Elementor 'MenuBox' widget.
 *
 * Elementor widget that displays an 'MenuBox'.
 *
 * @since 1.0.0
 */
class MenuBox extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'MenuBox' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_menu_box';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'MenuBox' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Navigation Menu', 'auxin-elements' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'MenuBox' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-nav-menu auxin-badge';
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'MenuBox' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_categories() {
        return array( 'auxin-core', 'auxin-theme-elements' );
    }

    /**
     * Get the all available menus
     *
     * Retrieve the list of all menus.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array menu slug.
     */
	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}


    /**
     * Register 'MenuBox' widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            array(
                'label'      => __('General', 'auxin-elements' ),
            )
        );

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				array(
					'label' => __( 'Menu', 'auxin-elements' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'auxin-elements' ), admin_url( 'nav-menus.php' ) ),
                )
			);
		} else {
			$this->add_control(
				'menu_slug',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'auxin-elements' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                )
			);
		}

        $this->add_control(
            'type',
            array(
                'label'       => __('Type', 'auxin-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'horizontal',
                'options'     => array(
                   'horizontal' => __('Horizontal' , 'auxin-elements' ),
                   'vertical'   => __('Vertical'    , 'auxin-elements' ),
                   'burger'     => __('Burger'    , 'auxin-elements' )
                ),
                'condition' => array(
                    'menu_slug!' => ''
                )
            )
        );

        $this->add_control(
            'splitter',
            array(
                'label'        => __( 'Display Menu Splitter', 'auxin-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-elements' ),
                'label_off'    => __( 'Off', 'auxin-elements' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
                'condition' => array(
                    'type' => 'horizontal'
                )
            )
        );

        $this->add_control(
            'indicator',
            array(
                'label'        => __( 'Display Submenu Indicator', 'auxin-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-elements' ),
                'label_off'    => __( 'Off', 'auxin-elements' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'display_burger',
            array(
                'label'       => __('Display Burger Toggle on', 'auxin-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => '768',
                'options'     => array(
                   '1024'   => __('Tablet' , 'auxin-elements' ),
                   '768'    => __('Mobile'    , 'auxin-elements' ),
                   'custom' => __('Custom'    , 'auxin-elements' )
                ),
                'condition' => array(
                    'menu_slug!' => ''
                )
            )
        );

        $this->add_control(
            'breakpoint',
            array(
                'label'      => __('BreakPoint','auxin-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array('px'),
                'range'      => array(
                    'px' => array(
                        'min'  => 1,
                        'max'  => 1600,
                        'step' => 1
                    )
                ),
				'default' => array(
					'unit' => 'px',
					'size' => 768,
                ),
                'separator'    => 'before',
                'condition' => array(
                    'type!'          => 'burger',
                    'display_burger' => 'custom'
                )
            )
        );

        $this->add_control(
            'burger_menu_location',
            array(
                'label'       => __('Burger Menu Location','auxin-elements' ),
                'type'        => 'aux-visual-select',
                'style_items' => 'max-width:45%;',
                'options'     => array(
                    'toggle-bar' => array(
                        'label'  => __( 'Expandable under top header', 'auxin-elements' ),
                        'image'  => AUXIN_URL . 'images/visual-select/burger-menu-location-1.svg'
                    ),
                    'overlay'    => array(
                        'label'  => __( 'FullScreen on entire page', 'auxin-elements' ),
                        'image'  => AUXIN_URL . 'images/visual-select/burger-menu-location-3.svg'
                    ),
                    'offcanvas'  => array(
                        'label'  => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'  => AUXIN_URL . 'images/visual-select/burger-menu-location-2.svg'
                    )
                ),
                'default'     => 'toggle-bar',
                'seperator'   => 'before'
            )
        );

        $this->add_control(
            'offcanvas_align',
            array(
                'label'       => __('Offcanvas Alignment', 'auxin-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'left',
                'options'     => array(
                   'left'  => __('Left' , 'auxin-elements' ),
                   'right' => __('Right'    , 'auxin-elements' )
                ),
                'condition' => array(
                    'burger_menu_location' => 'offcanvas'
                )
            )
        );

        $this->add_control(
            'burger_toggle_type',
            array(
                'label'       => __('Burger Menu Toggle Type', 'auxin-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'toggle',
                'options'     => array(
                   'toggle'    => __('Toggle' , 'auxin-elements' ),
                   'accordion' => __('Accordion'    , 'auxin-elements' )
                ),
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style TAB
        /*-----------------------------------------------------------------------------------*/

        /*   Menu Item Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'menu_item_section',
            array(
                'label'     => __( 'Menu Item', 'auxin-elements' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->start_controls_tabs( 'item_colors' );

        $this->start_controls_tab(
            'item_color_normal',
            array(
                'label'     => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'item_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-menu-depth-0 > .aux-item-content' => 'color: {{VALUE}} !important;',
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_color_hover',
            array(
                'label'     => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'item_hover_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-menu-depth-0.aux-hover > .aux-item-content ' => 'color: {{VALUE}} !important;'
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'menu_item_typo',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0 > .aux-item-content',
            )
        );

        $this->add_responsive_control(
            'item_padding',
            array(
                'label'      => __( 'Padding', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-depth-0 > .aux-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_responsive_control(
            'item_margin',
            array(
                'label'      => __( 'Margin', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-depth-0' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'seperator' => 'after'
            )
        );


        $this->start_controls_tabs( 'item_background_tab' );

        $this->start_controls_tab(
            'item_bg_normal',
            array(
                'label' => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'item_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-menu-depth-0 '
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'item_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0'
            )
        );

        $this->add_responsive_control(
            'item_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-depth-0' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'item_border',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_bg_hover',
            array(
                'label' => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'hover_item_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-menu-depth-0.aux-hover'
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'hover_item_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0.aux-hover'
            )
        );

        $this->add_responsive_control(
            'item_hover_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-depth-0.aux-hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
                'separator'  => 'after'
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'item_hover_border',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0.aux-hover',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'align',
            array(
                'label'      => __('Text Align','auxin-elements'),
                'type'       => Controls_Manager::CHOOSE,
                'devices'    => array( 'desktop', 'mobile' ),
                'options'    => array(
                    'left' => array(
                        'title' => __( 'Left', 'auxin-elements' ),
                        'icon' => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __( 'Center', 'auxin-elements' ),
                        'icon' => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => __( 'Right', 'auxin-elements' ),
                        'icon' => 'fa fa-align-right',
                    ),
                ),
                'default'    => 'left',
                'toggle'     => true,
                'selectors'  => array(
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                )
            )
        );

        $this->end_controls_section();


        /* submenu Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'submenu_style_section',
            array(
                'label'     => __( 'Submenu', 'auxin-elements' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->add_control(
            'submenu_skin',
            array(
                'label'       => __('Submenu Skin','auxin-elements' ),
                'type'        => 'aux-visual-select',
                'style_items' => 'max-width:45%;',
                'options'     => array(
                    'classic'        => array(
                        'label'      => __('Paradox', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-1.svg'
                    ),
                    'classic-center' => array(
                        'label'      => __( 'Classic', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-2.svg'
                    ),
                    'dash-divided'   => array(
                        'label'      => __( 'Dark Transparent', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-5.svg'
                    ),
                    'divided'        => array(
                        'label'      => __( 'Divided', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-3.svg'
                    ),
                    'minimal-center' => array(
                        'label'      => __( 'Center Paradox', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-4.svg'
                    ),
                    'modern'         => array(
                        'label'      => __( 'Modern Paradox', 'auxin-elements' ),
                        'image'      => AUXIN_URL . 'images/visual-select/sub-menu-skin-6.svg'
                    )
                ),
                'default'     => 'classic',
                'separator'   => 'after'
            )
        );

        $this->add_control(
            'submenu_anim',
            array(
                'label'       => __('Submenu Animation Effect','auxin-elements' ),
                'type'        => 'aux-visual-select',
                'style_items' => 'max-width:45%;',
                'options'     => array(
                    'none'          => array(
                        'label'     => __( 'None', 'auxin-elements' ),
                        'video_src' => AUXIN_URL . 'images/visual-select/videos/NoFade.webm webm'
                    ),
                    'fade'          => array(
                        'label'     => __( 'Fade', 'auxin-elements' ),
                        'video_src' => AUXIN_URL . 'images/visual-select/videos/Fade.webm webm'
                    ),
                    'slide-up'      => array(
                        'label'     => __( 'Fade and move', 'auxin-elements' ),
                        'video_src' => AUXIN_URL . 'images/visual-select/videos/FadeAndMove.webm webm'
                    )
                ),
                'default'     => 'none',
                'seperator'   => 'after'
            )
        );

        $this->start_controls_tabs( 'sub_background_tab' );

        $this->start_controls_tab(
            'sub_bg_normal',
            array(
                'label' => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'sub_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu'
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'sub_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu'
            )
        );

        $this->add_responsive_control(
            'sub_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'sub_border',
                'selector'  => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_bg_hover',
            array(
                'label' => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'hover_sub_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu:hover'
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'hover_sub_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu:hover'
            )
        );

        $this->add_responsive_control(
            'sub_hover_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'sub_hover_border',
                'selector'  => '{{WRAPPER}} .aux-menu-item.aux-open > .aux-submenu:hover',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        /*  SubMenu Item Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'submenu_item_section',
            array(
                'label'     => __( 'SubMenu Item', 'auxin-elements' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->start_controls_tabs( 'sub_item_colors' );

        $this->start_controls_tab(
            'sub_item_color_normal',
            array(
                'label'     => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'sub_item_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content' => 'color: {{VALUE}} !important;',
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_item_color_hover',
            array(
                'label'     => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'sub_item_hover_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-submenu .aux-menu-item.aux-hover .aux-item-content' => 'color: {{VALUE}} !important;'
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'menu_sub_item_typo',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .aux-submenu .aux-menu-item',
            )
        );

        $this->add_responsive_control(
            'sub_item_padding',
            array(
                'label'      => __( 'Padding', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_responsive_control(
            'sub_item_margin',
            array(
                'label'      => __( 'Margin', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-submenu .aux-menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'seperator' => 'after'
            )
        );


        $this->start_controls_tabs( 'sub_item_background_tab' );

        $this->start_controls_tab(
            'sub_item_bg_normal',
            array(
                'label' => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'sub_item_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content'
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'sub_item_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content'
            )
        );

        $this->add_responsive_control(
            'sub_item_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'sub_item_border',
                'selector'  => '{{WRAPPER}} .aux-submenu .aux-menu-item .aux-item-content',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_item_bg_hover',
            array(
                'label' => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'hover_sub_item_background',
                'label'    => __( 'Background', 'auxin-elements' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .aux-menu-depth-0 > .aux-submenu > .aux-menu-item.aux-hover > .aux-item-content'
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'      => 'hover_sub_item_box_shadow',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0 > .aux-submenu > .aux-menu-item.aux-hover > .aux-item-content'
            )
        );

        $this->add_responsive_control(
            'sub_item_hover_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-menu-depth-0 > .aux-submenu > .aux-menu-item.aux-hover > .aux-item-content' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
                'allowed_dimensions' => 'all',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'      => 'sub_item_hover_border',
                'selector'  => '{{WRAPPER}} .aux-menu-depth-0 > .aux-submenu > .aux-menu-item.aux-hover > .aux-item-content',
                'separator' => 'none'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /*  Burger Button Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'burger_section',
            array(
                'label'     => __( 'Burger Button', 'auxin-elements' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->start_controls_tabs( 'burger_color' );

        $this->start_controls_tab(
            'burger_color_normal',
            array(
                'label'     => __( 'Normal' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'burger_btn_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-burger:before,  {{WRAPPER}} .aux-burger:after, {{WRAPPER}} .aux-burger .mid-line' => 'border-color: {{VALUE}} !important;',
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'burger_color_hover',
            array(
                'label'     => __( 'Hover' , 'auxin-elements' )
            )
        );

        $this->add_control(
            'burger_btn_hover_color',
            array(
                'label' => __( 'Color', 'auxin-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-burger:hover:before,  {{WRAPPER}} .aux-burger:hover:after, {{WRAPPER}} .aux-burger:hover .mid-line' => 'border-color: {{VALUE}} !important;',
                ),
                'seperartor' => 'after'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'burger_btn_style',
            array(
                'label'       => __('Burger Button Style','auxin-elements' ),
                'type'        => 'aux-visual-select',
                'style_items' => 'max-width:45%;',
                'options'     => array(
                    'aux-lite-large'     => array(
                        'label'          => __( 'Expandable under top header', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-lite-large.svg'
                    ),
                    'aux-regular-large'  => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-regular-large.svg'
                    ),
                    'aux-thick-large'    => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-thick-large.svg'
                    ),
                    'aux-lite-medium'    => array(
                        'label'          => __( 'FullScreen on entire page', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-lite-medium.svg'
                    ),
                    'aux-regular-medium' => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-regular-medium.svg'
                    ),
                    'aux-thick-medium'   => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-thick-medium.svg'
                    ),
                    'aux-lite-small'     => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-lite-small.svg'
                    ),
                    'aux-regular-small'  => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-regular-small.svg'
                    ),
                    'aux-thick-small'    => array(
                        'label'          => __( 'Offcanvas panel', 'auxin-elements' ),
                        'image'          => AUXIN_URL . 'images/visual-select/burger-thick-small.svg'
                    )
                ),
                'default'     => 'aux-lite-small',
                'seperator'   => 'before'
            )
        );

        $this->end_controls_section();


    }

    /**
     * Render MenuBox widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['meun_slug'] = ! empty( $settings['meun_slug'] ) ? $settings['meun_slug'] : '';

        $offcanvas_output  = '';
        $fullscreen_output = '';
        $toggle_bar_output = '';

        $indicator = auxin_is_true( $settings['indicator'] );
        $splitter  = auxin_is_true( $settings['splitter'] );


        $menu_class  = '';
        $menu_class .= ' aux-skin-' . $settings['submenu_skin'] ;
        $menu_class .= 'none' !== $settings['submenu_anim'] ? ' aux-' . $settings['submenu_anim'] . '-nav' : '';
        $menu_class .= $indicator ? ' aux-with-indicator' : '';
        $menu_class .= $splitter ? ' aux-with-splitter' : '';


        $mobile_menu_target = '.elementor-element-' . $this->get_id();

        switch( $settings['burger_menu_location'] ) {
            case 'overlay':
                $fullscreen_output  = '<section class="aux-fs-popup aux-fs-menu-layout-center aux-indicator">';
                $fullscreen_output .= '<div class="aux-panel-close"><div class="aux-close aux-cross-symbol aux-thick-medium"></div></div>';
                $fullscreen_output .= '<div class="aux-fs-menu"></div>';
                $fullscreen_output .= '</section>';
                $mobile_menu_target .=  ' .aux-fs-popup .aux-fs-menu';
                break;

            case 'offcanvas':
                $offcanvas_output = '<section class="aux-offcanvas-menu aux-pin-' . $settings['offcanvas_align'] . '">';
                $offcanvas_output .= '<div class="aux-panel-close"><div class="aux-close aux-cross-symbol aux-thick-medium"></div></div>';
                $offcanvas_output .= '<div class="offcanvas-header"></div>';
                $offcanvas_output .= '<div class="offcanvas-content"></div>';
                $offcanvas_output .= '<div class="offcanvas-footer"></div>';
                $offcanvas_output .= '</section>';
                $mobile_menu_target .=  ' .aux-offcanvas-menu .offcanvas-content';
                break;

            case 'toggle-bar':
                $toggle_bar_output = '<div class="aux-toggle-menu-bar"></div>';
                $mobile_menu_target .= ' .aux-toggle-menu-bar';
                break;

            default:

        }

        printf( '<div class="aux-elementor-header aux-nav-menu-element aux-nav-menu-element-%s">', $this->get_id() );

        $burger_btn_output = printf( '<div class="aux-burger-box" data-target-panel="%s" data-target-content="%s"><div class="aux-burger %s"><span class="mid-line"></span></div></div>',
            $settings['burger_menu_location'],
            '.elementor-element-' . $this->get_id() . ' .aux-master-menu',
            $settings['burger_btn_style']
        );

        $breakpoint = 'custom' === $settings['display_burger'] ? $settings['breakpoint']['size'] : $settings['display_burger'];

        wp_nav_menu( array(
            'container_id'       => 'master-menu-elementor-'. $this->get_id(),
            'menu'               => $settings['menu_slug'],
            'direction'          => 'burger' === $settings['type'] ? null : $settings['type'],
            'mobile_under'       => 'burger' === $settings['type'] ? 7000 : $breakpoint,
            'mobile_menu_type'   => $settings['burger_toggle_type'],
            'mobile_menu_target' => $mobile_menu_target,
            'theme_location'     => 'element',
            'extra_class'        => esc_attr( $menu_class ),
            'fallback_cb'        => 'wp_page_menu'
        ));

        echo $offcanvas_output;
        echo $fullscreen_output;
        echo $toggle_bar_output;

        echo '</div>';

        if ( 'burger' !== $settings['type'] ) {
            printf( '<style>@media only screen and (min-width: %spx) { .elementor-element-%s .aux-burger-box { display: none } }</style>', $breakpoint,  $this->get_id() );
        }

    }

}
