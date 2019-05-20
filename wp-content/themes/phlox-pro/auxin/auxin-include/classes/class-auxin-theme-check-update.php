<?php
/**
 * This class checkes and notifies the user if there is a new version of theme available
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2019
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

if( class_exists('Auxin_Theme_Check_Update') ){
    return;
}


class Auxin_Theme_Check_Update {

    /**
     * The theme current version
     * @var string
     */
    public $current_version;

    /**
     * The theme remote update path
     * @var string
     */
    public $update_path;

    /**
     * Theme Slug (theme_directory/theme_file.php)
     * @var string
     */
    public $template;

    /**
     * The item name while requesting to update api
     * @var string
     */
    public $request_name;

    /**
     * The item ID in marketplace
     * @var string
     */
    public $theme_id;

    /**
     * The item name while requesting to update api
     * @var string
     */
    public $banners;

    /**
     * Whether auto downloading and updating the theme is enabled or not
     * @var boolean
     */
    public $auto_update_enabled;


    /**
     * Initialize a new instance of the WordPress Auto-Update class
     * @param string $current_version
     * @param string $update_path
     * @param string $template
     */
    function __construct( $current_version, $update_path, $template, $item_request_name = '' ) {
        $this->auto_update_enabled = true;

        // Set the class public variables
        $this->current_version  = $current_version;
        $this->update_path      = $update_path;
        $this->template         = $template;

        $this->request_name     = empty( $item_request_name ) ? $template : $item_request_name;

        // define the alternative API for updating checking
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update') );
    }


    /**
     * Add our self-hosted autoupdate theme to the filter transient
     *
     * @param $transient
     * @return object $ transient
     */
    public function check_update( $transient ) {

        if( apply_filters( 'auxin_disable_theme_auto_update', 0 ) )
            return $transient;

        // Get the remote version
        $remote_version = $this->get_remote_version();

        $theme_data = wp_get_theme();

        $download_url = $this->auto_update_enabled ? $this->get_download_url() : '';

        // If a newer version is available, add the update info to update transient
        if ( version_compare( $this->current_version, $remote_version, '<' ) ) {
            $template_reponse                       = array();
            $template_reponse['theme']              = $this->template;
            $template_reponse['new_version']        = $remote_version;
            $template_reponse['url']                = $theme_data->ThemeURI;
            $template_reponse['package']            = ( false !== $download_url && ! is_wp_error( $download_url ) ) ? $download_url : '';
            $transient->response[ $this->template ] = $template_reponse;

        } elseif ( isset( $transient->response[ $this->template ] ) ) {
            unset( $transient->response[ $this->template ] );
        }

        return $transient;
    }


    /**
     * Return the remote version
     * @return string $remote_version
     */
    public function get_remote_version() {
        global $wp_version;

        $theme_data = wp_get_theme();

        $this_theme              = array();
        $this_theme['Name']      = $theme_data->Name;
        $this_theme['ID']        = $this->theme_id;
        $this_theme['Slug']      = $this->template;
        $this_theme['Version']   = $this->current_version;
        $this_theme['Activated'] = get_option( $this->template . '_is_license_actived', 0 );

        $args = array(
            'user-agent' => 'WordPress/'.$wp_version.'; '. get_site_url(),
            'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
            'body'       => array(
                'cat'       => 'version-check',
                'action'    => 'final',
                'type'      => 'theme',
                'item-name' => $this->request_name,
                'item-info' => $this_theme
            )
        );

        $request = wp_remote_post( $this->update_path, $args );

        if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
            return $request['body'];
        }
        return false;
    }


    /**
     * Retrieves the temporary download link
     *
     * @return string  The download link
     */
    public function get_download_url() {

        global $wp_version;

        $args = array(
            'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
            'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3 ),
            'body'       => array(
                'action'    => 'token',
                'token'     => 'bf63a14cf3be6c2c03a2c6',
                'cat'       => 'download-purchase',
                'url'       => get_site_url()
            )
        );

        $request = wp_remote_post( $this->update_path, $args );

        if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {

            $error_message = isset( $result['error'] ) ? $result['error'].'. ' : '';
            $error_code    = isset( $result['code']  ) ? $result['code']. '. ' : '';

            return new WP_Error( 'no_credentials',
                apply_filters( 'auxin_theme_updater_failed_connect_api',
                    __( 'Faild to connect to download API ..', 'phlox-pro' ) . $error_message . $error_code ,
                    $error_message,
                    $error_code
                )
            );
        }
        $json   = $request['body'];
        $result = json_decode( $request['body'], true );


        if( empty( $result['download_url'] ) ) {
            $result         = json_decode( $request['body'], true );
            $error_message  = isset( $result['msg'] )  ? $result['msg'].'. '   : '';
            $error_code     = isset( $result['code'] ) ? $result['code']. '. ' : '';

            // API error ..
            return new WP_Error( 'no_credentials',
                apply_filters( 'auxin_theme_updater_api_error',
                    $json . __( 'Error on connecting to download API ..', 'phlox-pro' ) . $error_message . ' [' . $error_code . ']' ,
                    $error_message,
                    $error_code
                )
            );
        }

        return $result['download_url'];
    }

}
