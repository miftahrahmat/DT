<?php
/**
 * Include classes
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2019
 * @link       http://averta.net
*/

if( is_admin() ){

    // Assigning capabilities and option on theme install
    new Auxin_Theme_Screen_Help();

    // Register required assets (scripts & styles)
    new Auxin_Admin_Assets();

    // Parse and load fonts
    Auxin_Fonts::get_instance();

    /*  Include update notifier
    /*------------------------------------------*/
    if( AUXIN_UPDATE_NOTIFIER && class_exists( 'Auxin_Theme_Check_Update', true ) && ! class_exists( 'Envato_Market', true ) ){
        // Init theme auto-update class
        $theme_update_check = new Auxin_Theme_Check_Update (
            THEME_VERSION,                          // theme version
            'http://api.averta.net/envato/items/',  // API URL
            THEME_ID,                               // template slug name
            THEME_ID                                // item request name
        );
        $theme_update_check->theme_id = '3909293';
        $theme_update_check->auto_update_enabled = true;

        new Auxin_Theme_Updater( THEME_ID );
    }
}

// Init Master Menu navigation
Auxin_Master_Nav_Menu::get_instance();

