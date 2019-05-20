<?php
namespace Auxin\Plugin\Pro\Elementor;

/**
 * Auxin Elementor Elements
 *
 * Custom Elementor extension.
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2019 
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Main Auxin Elementor Elements Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elements {


    /**
     * Default elementor dit path
     *
     * @since 1.0.0
     *
     * @var string The defualt path to elementor dir on this plugin.
     */
    private $dir_path = '';


    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var Auxin_Elementor_Core_Elements The single instance of the class.
    */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Auxin_Elementor_Core_Elements An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
          self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
    */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }

        // Define elementor dir path
        $this->dir_path = AUXPRO_INC_DIR . '/elements/elementor';

        // Include core files
        $this->includes();

        // Add required hooks
        $this->hooks();
    }

    /**
     * Include Files
     *
     * Load required core files.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function includes() {
        $this->load_modules();
    }

    /**
     * Add hooks
     *
     * Add required hooks for extending the Elementor.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function hooks() {

        // Register controls, widgets, and categories
        add_action( 'auxin/core_elements/elementor/widgets_list', array( $this, 'register_widgets' ) );

        // Register Widget Styles
        // add_action( 'elementor/frontend/after_enqueue_styles'   , array( $this, 'widget_styles' ) );

        // Register Widget Scripts
        add_action( 'elementor/frontend/after_register_scripts' , array( $this, 'widget_scripts' ) );

        // Register Admin Scripts
        add_action( 'elementor/editor/before_enqueue_scripts'   , array( $this, 'editor_scripts' ), 11 );
    }

    /**
     * Register widgets
     *
     * Register all widgets which are in widgets list.
     *
     * @access public
     */
    public function register_widgets( $widgets ) {

        $widgets['810'] = array(
            'file'  => $this->dir_path . '/widgets/faq.php',
            'class' => __NAMESPACE__ . '\Elements\FAQ'
        );

        $widgets['820'] = array(
            'file'  => $this->dir_path . '/widgets/3d-textbox.php',
            'class' => __NAMESPACE__ . '\Elements\Text_Box_3D'
        );

        $widgets['830'] = array(
            'file'  => $this->dir_path . '/widgets/countdown.php',
            'class' => __NAMESPACE__ . '\Elements\Countdown'
        );

        $widgets['840'] = array(
            'file'  => $this->dir_path . '/widgets/price-list.php',
            'class' => __NAMESPACE__ . '\Elements\PriceList'
        );

        $widgets['850'] = array(
            'file'  => $this->dir_path . '/widgets/custom-label.php',
            'class' => __NAMESPACE__ . '\Elements\CustomLabel'
        );

        $widgets['860'] = array(
            'file'  => $this->dir_path . '/widgets/progressbar.php',
            'class' => __NAMESPACE__ . '\Elements\ProgressBar'
        );

        $widgets['870'] = array(
            'file'  => $this->dir_path . '/widgets/shape.php',
            'class' => __NAMESPACE__ . '\Elements\Simple_Shape'
        );

        $widgets['880'] = array(
            'file'  => $this->dir_path . '/widgets/domain-checker.php',
            'class' => __NAMESPACE__ . '\Elements\DomainChecker'
        );

        $widgets['890'] = array(
            'file'  => $this->dir_path . '/widgets/svg.php',
            'class' => __NAMESPACE__ . '\Elements\Simple_SVG'
        );

        $widgets['900'] = array(
            'file'  => $this->dir_path . '/widgets/template.php',
            'class' => __NAMESPACE__ . '\Elements\Template'
        );

        $widgets['910'] = array(
            'file'  => $this->dir_path . '/widgets/weather.php',
            'class' => __NAMESPACE__ . '\Elements\Weather'
        );

        return $widgets;
    }

    /**
     * Load Modules
     *
     * Load all auxin elementor modules.
     *
     * @since 1.0.0
     *
     * @access public
     */
    private function load_modules() {

        $modules = array(
            array(
                'file'  => $this->dir_path . '/modules/common.php',
                'class' => 'Modules\Common'
            ),
            array(
                'file'  => $this->dir_path . '/modules/section.php',
                'class' => 'Modules\Section'
            ),
            /*array(
                'file'  => $this->dir_path . '/modules/column.php',
                'class' => 'Modules\Column'
            )*/
        );

        foreach ( $modules as $module ) {
            if( ! empty( $module['file'] ) && ! empty( $module['class'] ) ){
                include_once( $module['file'] );

                if( class_exists( __NAMESPACE__ . '\\' . $module['class'] ) ){
                    $class_name = __NAMESPACE__ . '\\' . $module['class'];
                } else {
                    auxin_error( sprintf( __('Module class "%s" not found.', PLUGIN_DOMAIN ), $class_name ) );
                    continue;
                }
                new $class_name();
            }
        }
    }

    /**
     * Enqueue styles.
     *
     * Enqueue all the frontend styles.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_styles() {

    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the frontend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_scripts() {
        wp_enqueue_script( 'auxin-elementor-pro-widgets' , AUXPRO_ADMIN_URL . '/assets/js/elementor/widgets.js' , array(), AUXPRO_VERSION );
    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the backend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function editor_scripts() {
        // Elementor Custom Style
        wp_register_style(  'auxin-elementor-pro-editor', AUXPRO_ADMIN_URL . '/assets/css/elementor-editor.css', array(), AUXPRO_VERSION );
        // Elementor Custom Scripts
        wp_enqueue_script( 'auxin-elementor-pro-editor', AUXPRO_ADMIN_URL . '/assets/js/elementor/editor.js', array(), AUXPRO_VERSION );
    }

}

Elements::instance();
