<?php
/**
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2019 
 */


/**
 * Get template part.
 *
 * @param mixed $slug
 * @param string $name (default: '')
 */
function auxpro_get_template_part( $slug, $name = '' ) {
    auxin_get_template_part( $slug, $name, AUXPRO()->template_path() );
}


/**
 * Whether a plugin is active or not
 *
 * @param  string $plugin_basename  plugin directory name and mail file address
 * @return bool                     True if plugin is active and FALSE otherwise
 */
if( ! function_exists( 'auxin_is_plugin_active' ) ){
    function auxin_is_plugin_active( $plugin_basename ){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return is_plugin_active( $plugin_basename );
    }
}
