<?php
/*
Plugin Name: Daily Prayer Time
Version: 2019.5.14
Plugin URI: https://wordpress.org/plugins/daily-prayer-time-for-mosques/
Description: Display yearly, monthly and daily prayer time, ramadan time vertically or horizontally, in any language
Author: <a href="http://mmrs151.wordpress.com">mmrs151</a>
Contributors: <a href="http://vergedesign.co.uk/">Hjeewa</a>, <a href="https://profiles.wordpress.org/kams01">kams01</a>
*/
require_once('Models/Init.php');
require_once('Models/DailyShortCode.php');
require_once('Models/MonthlyShortCode.php');
require_once('Models/UpdateStyles.php');
require_once('Models/DSTemplateLoader.php');
require_once ('Models/DigitalScreen.php');

class DailyPrayerTime extends WP_Widget
{
    public function __construct()
    {
        $widget_details = array(
            'className' => 'DailyPrayerTime',
            'description' => 'Show daily prayer time vertically or horizontally'
        );
        $this->add_stylesheet();
        $this->add_scripts();

        if (get_option('dpt-init') != 1) {
            new Init();
        }

        parent::__construct('DailyPrayerTime', 'Daily Prayer Time', $widget_details);
    }

    public function form($instance)
    {
        include 'Views/dptWidgetForm.php';
        ?>

        <div class='mfc-text'>

        </div>

        <?php

        echo $args['after_widget'];
        echo "<a href='http://www.uwt.org/' target='_blank'>Support The Ummah</a></br></br>";
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        include 'Models/dptWidget.php';

        echo $args['after_widget'];
    }

    private function add_stylesheet() {
        wp_register_style( 'timetable-style', plugins_url('Assets/css/styles.css', __FILE__) );
        wp_enqueue_style( 'timetable-style' );

        wp_register_style( 'verge-style', plugins_url('Assets/css/vergestyles.css', __FILE__) );
        wp_enqueue_style( 'verge-style' );

        wp_register_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

        // load bootstrap
        wp_register_style( 'dpt_bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        wp_enqueue_style( 'dpt_bootstrap' );

        wp_register_style( 'dpt_font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style( 'dpt_font_awesome' );

        wp_register_style('jquery_ui_css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_style( 'jquery_ui_css' );


        new UpdateStyles('timetable-style');
    }

    private function add_scripts()
    {
        // Get the Path to this plugin's folder
        $path = plugin_dir_url( __FILE__ ); // I am in Models
//        $path .= '../';

        // Enqueue our script
        wp_enqueue_script( 'dpt',
            $path. 'Assets/js/dpt.js',
            array( 'jquery' ),
            '1.0.0', true );

        // Get the protocol of the current page
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

        // Set the ajaxurl Parameter which will be output right before
        // our ajax-delete-posts.js file so we can use ajaxurl
        $params = array(
            // Get the url to the admin-ajax.php file using admin_url()
            'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
        );

        // bootstrap js from CDN
        wp_enqueue_script( 'dpt_popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
        wp_enqueue_script( 'dpt_bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        wp_enqueue_script( 'jquery-ui-dialog' );

        wp_enqueue_script("jquery-ui",'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '1.8.8');

        wp_enqueue_script("jquery-cookie",'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array('jquery'), '1.4.1');
        wp_enqueue_script("jquery-blockUI",'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js', array('jquery'), '2.7.0');
        wp_enqueue_script('dpt-admin', plugins_url( '/Assets/js/dpt-admin.js', __FILE__ ), array( 'jquery' ), '4.0.0');

        // Print the script to our page
        wp_localize_script( 'dpt', 'timetable_params', $params );
    }

}

add_action('widgets_init', 'init_dpt_widget');
function init_dpt_widget()
{
    register_widget('DailyPrayerTime');
}
############################# END OF WIDGET ############################################

#============================= SHORTCODE =================================================
$monthlyShortCode = new MonthlyShortCode();
add_shortcode( 'monthlytable', array($monthlyShortCode, 'printMonthlyTimeTable') );

$dailyShortCode = new DailyShortCode();
add_shortcode( 'dailytable_vertical', array($dailyShortCode, 'verticalTime') );
add_shortcode( 'dailytable_horizontal', array($dailyShortCode, 'horizontalTime') );
add_shortcode( 'display_ramadan_time', array($dailyShortCode, 'scRamadanTime') );
add_shortcode( 'daily_next_prayer', array($dailyShortCode, 'scNextPrayer') );
add_shortcode( 'fajr_prayer', array($dailyShortCode, 'scFajr') );
add_shortcode( 'sunrise', array($dailyShortCode, 'scSunrise') );
add_shortcode( 'zuhr_prayer', array($dailyShortCode, 'scZuhr') );
add_shortcode( 'asr_prayer', array($dailyShortCode, 'scAsr') );
add_shortcode( 'maghrib_prayer', array($dailyShortCode, 'scMaghrib') );
add_shortcode( 'isha_prayer', array($dailyShortCode, 'scIsha') );
add_shortcode( 'fajr_start', array($dailyShortCode, 'scFajrStart') );
add_shortcode( 'zuhr_start', array($dailyShortCode, 'scZuhrStart') );
add_shortcode( 'asr_start', array($dailyShortCode, 'scAsrStart') );
add_shortcode( 'maghrib_start', array($dailyShortCode, 'scMaghribStart') );
add_shortcode( 'isha_start', array($dailyShortCode, 'scIshaStart') );
add_shortcode( 'display_iqamah_update', array($dailyShortCode, 'scIqamahUpdate') );

add_shortcode( 'digital_screen', array($dailyShortCode, 'scDigitalScreen') );


#============================= MENU PAGES =========================================== #
add_action( 'admin_menu', "prayer_settings");
function prayer_settings()
{
    add_menu_page(
        'Daily Prayer Time',
        'Prayer time',
        'manage_options',
        'dpt',
        'renderMainPage',
        plugins_url( 'Assets/images/icon19.png', __FILE__ )
    );

    add_submenu_page('dpt', 'Settings', 'Settings', 'manage_options', 'dpt', 'renderMainPage');
    add_submenu_page('dpt', 'Helps and Tips', 'Helps and Tips', 'manage_options', 'helps-and-tips', 'helps_and_tips');

    function renderMainPage() { include 'Views/widget-admin.php'; }

    function helps_and_tips()
    {
        include('Views/HelpsAndTips.php');
    }
}

#============================ DEACTIVATION =========================================== #
register_deactivation_hook( __FILE__, 'pluginUninstall' );
function pluginUninstall() {


    global $wpdb;
    $table = $wpdb->prefix."timetable";

    delete_option('dpt-init');
    delete_option('asrSelect');
    delete_option('prayersLocal');
    delete_option('headersLocal');
    delete_option('numbersLocal');
    delete_option('monthsLocal');
    delete_option('ramadan-chbox');
    delete_option('timesLocal');
    delete_option('hijri-chbox');
    delete_option('hijri-adjust');
    delete_option('tableBackground');
    delete_option('tableHeading');
    delete_option('evenRow');
    delete_option('fontColor');
    delete_option('highlight');
    delete_option('jamah_changes');
    delete_option('scrolling-text');
    delete_option('blink-text');
    delete_option('slider-chbox');
    delete_option('transitionEffect');
    delete_option('transitionSpeed');
    delete_option('slider1Url');
    delete_option('slider2Url');
    delete_option('slider3Url');
    delete_option('slider4Url');
    delete_option('slider5Url');

    $wpdb->query("DROP TABLE IF EXISTS $table");
}
