<?php
/**
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

/**
 * The main challange here is defining a dynamic dl link
 *
 * for $updade_themes_transient->response[ $theme_slug ]->package;
 */


if( ! class_exists('theme_Upgrader') ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
}



if( ! class_exists('Auxin_Theme_Updater') ) {

    class Auxin_Theme_Updater extends Theme_Upgrader {

        /**
         * theme slug
         *
         * @var string
         */
        public $theme_slug;

        /**
         * Installable update file name
         *
         * @var string
         */
        public $installable_theme_zip_file = '';

        /**
         * Instance of this class.
         *
         * @var      object
         */
        public static $instance = null;


        /**
         * Set theme info and add essential hooks
         *
         * @param string $theme_slug                 The name of directory and main file name of theme
         *
         * @param string $installable_theme_zip_file Installable update file name. Default is {theme_slug}-installable.zip
         */
        public function __construct( $theme_slug = '', $installable_theme_zip_file = '' ){

            parent::__construct();

            $this->theme_slug = $theme_slug;
            $this->installable_theme_zip_file = empty( $installable_theme_zip_file ) ? $this->theme_slug . '-installable.zip' : $installable_theme_zip_file;

        }

        /**
         * Inject package address in update_themes transient`
         *
         * @param  object $transient update_themes transient
         * @return object            update_themes transient
         */
        function define_package_for_theme_update_transient( $transient ){

            if( isset( $transient->response[ $this->theme_slug ] ) ){
                $r = $transient->response[ $this->theme_slug ];

                $dl_url = $this->get_downloaded_package_url();
                if( ! is_wp_error( $dl_url ) ){
                    $transient->response[ $this->theme_slug ]['package'] = $dl_url;
                }

            }

            return $transient;
        }

        /**
         * Get download url from API
         * @param  string $username      Envato username
         * @param  string $purchase_code Envato purchase code
         * @param  string $token         The user token
         * @return string                The downlaod URL
         */
        /*public function get_download_url ( $username = '', $purchase_code = '', $token = '' ) {

            if( $custom_download = apply_filters( 'auxin_theme_updater_custom_package_download_url', 0 ) )
                return $custom_download;

            if( empty( $username ) || empty( $purchase_code ) || empty( $token ) ) {
                return new WP_Error( 'no_credentials',
                    apply_filters( 'auxin_theme_updater_login_info_required',
                        __( 'Envato username, API key and your item purchase code are required for downloading updates from Envato marketplace.' ) , $this->theme_slug
                    )
                );
            }

            $args = array(
                'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
                'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
                'body' => array(
                    'action'    => 'token',
                    'key'       => $purchase_code,
                    'user'      => $username,
                    'token'     => $token,
                    'url'       => get_site_url()
                )
            );*/
        public function get_download_url() {

            global $wp_version;

            $args = array(
                'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
                'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3 ),
                'body'       => array(
                    'cat'       => 'download-purchase',
                    'action'    => 'token',
                    'token'     => 'bf63a14cf3be6c2c03a2c6',
                    'url'       => get_site_url()
                )
            );

            $request = wp_remote_post( 'http://api.averta.net/envato/items/', $args );

            if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {

                $error_message = isset( $result['error'] ) ? $result['error'].'. ' : '';
                $error_code    = isset( $result['code']  ) ? $result['code']. '. ' : '';

                return new WP_Error( 'no_credentials',
                    apply_filters( 'auxin_theme_updater_failed_connect_api',
                        __( 'Faild to connect to download API ..', 'phlox-pro' ) . $error_message . $error_code ,
                        $this->theme_slug, $error_message , $error_code
                    )
                );
            }
            $json   = $request['body'];
            $result = json_decode( $request['body'], true );


            if( empty( $result['download_url'] ) ) {
                $result         = json_decode( $request['body'], true );
                $error_message  = isset( $result['msg'] )  ? $result['msg'].'. '   : '';
                $error_code     = isset( $result['code'] ) ? $result['code']. '. ' : '';

                // Envato API error ..
                return new WP_Error( 'no_credentials',
                    apply_filters( 'auxin_theme_updater_api_error',
                        $json . __( 'Error on connecting to download API ..', 'phlox-pro' ) . $error_message . ' [' . $error_code . ']' ,
                        $this->theme_slug, $error_message , $error_code
                    )
                );
            }

            return $result['download_url'];
        }


        /**
         * Download installable file from custom download API
         */
        protected function get_downloaded_package_url() {

            /**
             * Initialize the WP_Filesystem
             */
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH.'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            $res = $this->fs_connect( array( WP_CONTENT_DIR ) );

            if ( ! $res ) {
                return new WP_Error('no_credentials', __( "Error! Failed to connect filesystem", 'phlox-pro' ) );
            }

            /*
            $username       = msp_get_setting( 'username'      , 'msp_envato_license' );
            $purchase_code  = msp_get_setting( 'purchase_code' , 'msp_envato_license' );
            $token          = msp_get_setting( 'token'         , 'msp_envato_license' );

            $the_download_url = $this->get_download_url( $username, $purchase_code, $token );
            */
            return $this->get_download_url();
        }


        /**
         * Download a package.
         *
         * @param string $package The URI of the package. If this is the full path to an
         *                        existing local file, it will be returned untouched.
         * @return string|WP_Error The full path to the downloaded package file, or a {@see WP_Error} object.
         */
        public function download_package( $package ) {
            // we will override package file with our own package
            $package = $this->get_downloaded_package_url();

            if( is_wp_error( $package ) )
                return $package;

            return parent::download_package( $package );
        }


        /**
         * Return an instance of this class.
         *
         * @return    object    A single instance of this class.
         */
        public static function get_instance() {

            if ( null == self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

    }

}
