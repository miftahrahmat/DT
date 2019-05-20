<?php
namespace Auxin\Plugin\Pro\Elementor\Modules;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


class Common {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;


    function __construct(){
        // Add new controls to advanced tab globally
        add_action( "elementor/element/after_section_end", array( $this, 'add_parallax_controls_section'   ), 15, 3 );
        add_action( "elementor/element/after_section_end", array( $this, 'add_sticky_controls_section' ), 17, 3 );
        add_action( "elementor/element/after_section_end", array( $this, 'add_pagecover_controls_section' ), 18, 3 );

        // Renders attributes for all Elementor Elements
        add_action( 'elementor/frontend/widget/before_render' , array( $this, 'render_attributes' ) );
        add_action( 'elementor/frontend/column/before_render' , array( $this, 'render_attributes' ) );
        add_action( 'elementor/frontend/section/before_render', array( $this, 'render_attributes' ) );
    }

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Add extra controls to advanced section
     *
     * @return void
     */
    public function add_parallax_controls_section( $widget, $section_id, $args ){

        if( in_array( $widget->get_name(), array('section') ) ){
            return;
        }

        // Hook element section
        $target_sections = array('section_custom_css');

        if( ! defined('ELEMENTOR_PRO_VERSION') ) {
            $target_sections[] = 'section_custom_css_pro';
        }

        if( ! in_array( $section_id, $target_sections ) ){
            return;
        }


        // Adds parallax options to advanced section
        // ---------------------------------------------------------------------
        $widget->start_controls_section(
            'aux_pro_common_parallax_section',
            array(
                'label'     => __( 'Parallax Pro', PLUGIN_DOMAIN ),
                'tab'       => Controls_Manager::TAB_ADVANCED
            )
        );

        $widget->add_control(
            'aux_parallax_enabled',
            array(
                'label'        => __( 'Enable Parallax', PLUGIN_DOMAIN ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', PLUGIN_DOMAIN ),
                'label_off'    => __( 'Off', PLUGIN_DOMAIN ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before'
            )
        );

        $widget->add_control(
            'aux_parallax_el_origin',
            array(
                'label'   => __( 'Parallax Origin', PLUGIN_DOMAIN ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'top'     => __( 'Top', PLUGIN_DOMAIN ),
                    'middle'  => __( 'Middle', PLUGIN_DOMAIN ),
                    'bottom'  => __( 'Bottom', PLUGIN_DOMAIN )
                ),
                'default'   => 'middle',
                'condition' => array(
                    'aux_parallax_enabled' => 'yes'
                )
            )
        );

        $widget->add_control(
            'aux_parallax_el_depth',
            array(
                'label'      => __('Parallax Velocity',PLUGIN_DOMAIN ),
                'type'       => Controls_Manager::SLIDER,
                'default'   => array(
                    'size' => 0.15,
                ),
                'range' => array(
                    'px' => array(
                        'min'  => -1,
                        'max'  => 1,
                        'step' => 0.01
                    )
                ),
                'condition' => array(
                    'aux_parallax_enabled' => 'yes'
                )
            )
        );

        $widget->add_control(
            'aux_parallax_disable_on',
            array(
                'label'   => __( 'Disable Parallax', PLUGIN_DOMAIN ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'tablet'  => __( 'On Mobile and Tablet', PLUGIN_DOMAIN ),
                    'phone'   => __( 'On Mobile', PLUGIN_DOMAIN ),
                    'custom'  => __( 'Under a screen size', PLUGIN_DOMAIN )
                ),
                'default'   => 'tablet',
                'condition' => array(
                    'aux_parallax_enabled' => 'yes'
                ),
                'label_block' => true
            )
        );

        $widget->add_control(
            'aux_parallax_disable_under',
            array(
                'label'      => __('Disable under size',PLUGIN_DOMAIN ),
                'description'=> __('Specifies a screen width under which the parallax will be disabled automatically. (in pixels)',PLUGIN_DOMAIN ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => array(
                    'size' => 768,
                ),
                'range' => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 1400,
                        'step' => 1
                    )
                ),
                'condition' => array(
                    'aux_parallax_enabled'    => 'yes',
                    'aux_parallax_disable_on' => 'custom'
                )
            )
        );

        $widget->end_controls_section();
    }

    /**
     * Add extra controls to advanced section
     *
     * @return void
     */
    public function add_sticky_controls_section( $widget, $section_id, $args ){

        if( in_array( $widget->get_name(), array('section') ) ){
            return;
        }

        // Hook element section
        $target_sections = array('section_custom_css');

        if( ! defined('ELEMENTOR_PRO_VERSION') ) {
            $target_sections[] = 'section_custom_css_pro';
        }

        if( ! in_array( $section_id, $target_sections ) ){
            return;
        }


        // Adds parallax options to advanced section
        // ---------------------------------------------------------------------
        $widget->start_controls_section(
            'aux_pro_common_sticky_section',
            array(
                'label'     => __( 'Sticky Pro', PLUGIN_DOMAIN ),
                'tab'       => Controls_Manager::TAB_ADVANCED
            )
        );

        $widget->add_control(
            'aux_sticky_enabled',
            array(
                'label'        => __( 'Enable Sticky', PLUGIN_DOMAIN ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', PLUGIN_DOMAIN ),
                'label_off'    => __( 'Off', PLUGIN_DOMAIN ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before'
            )
        );

        $widget->add_control(
            'aux_sticky_margin',
            array(
                'label'      => __('Space between elements',PLUGIN_DOMAIN ),
                'type'       => Controls_Manager::SLIDER,
                'default'   => array(
                    'size' => 0,
                ),
                'range' => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 100
                    )
                ),
                'condition' => array(
                    'aux_sticky_enabled' => 'yes'
                )
            )
        );

        $widget->add_control(
            'aux_sticky_disable_on',
            array(
                'label'   => __( 'Disable Sticky', PLUGIN_DOMAIN ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'tablet'  => __( 'On Mobile and Tablet', PLUGIN_DOMAIN ),
                    'phone'   => __( 'On Mobile', PLUGIN_DOMAIN ),
                    'custom'  => __( 'Under a screen size', PLUGIN_DOMAIN )
                ),
                'default'   => 'tablet',
                'condition' => array(
                    'aux_sticky_enabled' => 'yes'
                ),
                'label_block' => true
            )
        );

        $widget->add_control(
            'aux_sticky_disable_under',
            array(
                'label'      => __('Disable under size',PLUGIN_DOMAIN ),
                'description'=> __('Specifies a screen width under which the parallax will be disabled automatically. (in pixels)',PLUGIN_DOMAIN ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => array(
                    'size' => 767,
                ),
                'range' => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 1400,
                        'step' => 1
                    )
                ),
                'condition' => array(
                    'aux_sticky_enabled'    => 'yes',
                    'aux_sticky_disable_on' => 'custom'
                )
            )
        );        

        $widget->end_controls_section();
    }

    /**
     * Add extra controls to advanced section
     *
     * @return void
     */
    public function add_pagecover_controls_section( $widget, $section_id, $args ){

        if( ! in_array( $widget->get_name(), array('section') ) ){
            return;
        }

        // Hook element section
        $target_sections = array('section_custom_css');

        if( ! defined('ELEMENTOR_PRO_VERSION') ) {
            $target_sections[] = 'section_custom_css_pro';
        }

        if( ! in_array( $section_id, $target_sections ) ){
            return;
        }

        $widget->start_controls_section(
            'aux_page_cover_section',
            array(
                'label'     => __( 'Page Cover', PLUGIN_DOMAIN ),
                'tab'       => Controls_Manager::TAB_ADVANCED
            )
        );
        
        $widget->add_control(
            'aux_page_cover',
			array(
				'label'        => __( 'Enable Page Cover', PLUGIN_DOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'prefix_class' => 'aux-',
				'return_value' => 'page-cover-wrapper',
            )
        );

        $widget->end_controls_section();

    }

    /**
     * Renders attributes
     *
     * @param  Widget_Base $widget Instance of widget
     *
     * @return void
     */
    public function render_attributes( $widget ){
        $settings = $widget->get_settings();

        // Add parallax attributes
        if( $this->setting_value( $settings, 'aux_parallax_enabled', 'yes' ) ){
            $widget->add_render_attribute( '_wrapper', 'class', 'aux-parallax-piece' );

            if( null !== $value = $this->setting_value( $settings, 'aux_parallax_el_origin' ) ){
                $widget->add_render_attribute( '_wrapper', 'data-parallax-origin', $value );
            }
            if( null !== $value = $this->setting_value( $settings, 'aux_parallax_el_depth' ) ){
                $widget->add_render_attribute( '_wrapper', 'data-parallax-depth', $value['size'] );
            }
            if( null !== $value = $this->setting_value( $settings, 'aux_parallax_disable_on' ) ){
                $breakpoint = 1024;

                if( 'tablet' == $value ){
                    $breakpoint = 1024;
                } elseif( 'phone' == $value ){
                    $breakpoint = 768;
                } elseif( null !== $value = $this->setting_value( $settings, 'aux_parallax_disable_under' ) ){
                    $breakpoint = $value['size'];
                }
                $widget->add_render_attribute( '_wrapper', 'data-parallax-off', $breakpoint );
            }
        }

        // Add parallax attributes
        if( $this->setting_value( $settings, 'aux_sticky_enabled', 'yes' ) ){
            // Set sticky data options
            $widget->add_render_attribute( '_wrapper', 'class', 'aux-sticky-piece' );
            $widget->add_render_attribute( '_wrapper', 'data-boundaries', true );
            $widget->add_render_attribute( '_wrapper', 'data-use-transform', true );
            if( null !== $value = $this->setting_value( $settings, 'aux_sticky_margin' ) ){
                $widget->add_render_attribute( '_wrapper', 'data-sticky-margin', $value['size'] );
            }
            if( null !== $value = $this->setting_value( $settings, 'aux_sticky_disable_on' ) ){
                $breakpoint = 768;
                
                if( 'tablet' == $value ){
                    $breakpoint = 1024;
                } elseif( 'phone' == $value ){
                    $breakpoint = 768;
                } elseif( null !== $value = $this->setting_value( $settings, 'aux_sticky_disable_under' ) ){
                    $breakpoint = $value['size'];
                }
                $widget->add_render_attribute( '_wrapper', 'data-sticky-off', $breakpoint );
            }            
        }

    }


    private function setting_value( $settings, $key, $value = null ){
        if( ! isset( $settings[ $key ] ) ){
            return;
        }
        // Retrieves the setting value
        if( is_null( $value ) ){
            return $settings[ $key ];
        }
        // Validates the setting value
        return ! empty( $settings[ $key ] ) && $value == $settings[ $key ];
    }

}
