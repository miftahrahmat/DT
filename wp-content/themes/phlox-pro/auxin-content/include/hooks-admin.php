<?php
/**
 * Pointers (Tooltips) to introduce new theme features or display notifications in admin area
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2019
 * @link       http://averta.net
 */

/*-----------------------------------------------------------------------------------*/
/*  Install theme recommended plugins
/*-----------------------------------------------------------------------------------*/


add_action( 'tgmpa_register', 'auxin_theme_register_recommended_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function auxin_theme_register_recommended_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'             => __('Elementor', 'phlox-pro'),
            'slug'             => 'elementor',
            'required'         => false,
            'categories'       => array('essential', 'pagebuilder', 'visual-builder')
        ),

        array(
            'name'             => __('Elementor Element Pack', 'phlox-pro'),
            'slug'             => 'bdthemes-element-pack',
            'version'          => '2.5.6',
            'source'           => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/bdthemes-element-pack.zip',
            'thumbnail'        => 'custom',
            'required'         => false,
            'categories'       => array('essential', 'bundled', 'pagebuilder')
        ),

        array(
            'name'             => __('Phlox Core Elements', 'phlox-pro'),
            'slug'             => 'auxin-elements',
            'version'          => '2.3.2',
            'badge'            => __( 'Exclusive', 'phlox-pro' ),
            'required'         => true,
            'force_activation' => true,
            'categories'       => array('auxin', 'essential', 'bundled')
        ),

        array(
            'name'             => __('Phlox Portfolio', 'phlox-pro'),
            'slug'             => 'auxin-portfolio',
            'version'          => '1.7.6',
            'badge'            => __( 'Exclusive', 'phlox-pro' ),
            'required'         => false,
            'force_activation' => false,
            'categories'       => array('auxin', 'essential', 'bundled')
        ),

        array(
            'name'             => __('Phlox Pro Features', 'phlox-pro'),
            'slug'             => 'auxin-pro-tools',
            'version'          => '1.2.1',
            'source'           => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/auxin-pro-tools.zip',
            'thumbnail'        => 'custom',
            'badge'            => __( 'Exclusive', 'phlox-pro' ),
            'required'         => true,
            'force_activation' => true,
            'categories'       => array('auxin', 'essential', 'bundled')
        ),

        array(
            'name'       => __('Phlox News', 'phlox-pro'),
            'slug'       => 'auxin-the-news',
            'version'    => '1.2.0',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/auxin-the-news.zip',
            'thumbnail'  => 'custom',
            'badge'      => __( 'Exclusive', 'phlox-pro' ),
            'required'   => false,
            'categories' => array('essential', 'auxin', 'bundled')
        ),

        array(
            'name'       => __('WooCommerce', 'phlox-pro'),
            'slug'       => 'woocommerce',
            'required'   => false,
            'categories' => array('e-commerce')
        ),

        array(
            'name'      => __('Phlox Shop', 'phlox-pro'),
            'slug'      => 'auxin-shop',
            'version'   => '1.3.0',
            'source'    => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/auxin-shop.zip',
            'thumbnail' => 'custom',
            'badge'     => __( 'Exclusive', 'phlox-pro' ),
            'required'  => false,
            'categories'=> array('auxin', 'e-commerce', 'bundled')
        ),

        array(
            'name'       => __('Master Slider Pro', 'phlox-pro'),
            'slug'       => 'masterslider',
            'version'    => '3.2.9',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/masterslider.zip',
            'thumbnail'  => 'custom',
            'badge'      => __( 'Exclusive', 'phlox-pro' ),
            'required'   => false,
            'categories' => array('essential', 'bundled')
        ),

        array(
            'name'       => __('Visual Composer Page Builder', 'phlox-pro'),
            'slug'       => 'js_composer',
            'version'    => '5.5.4',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/js_composer.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('pagebuilder', 'bundled', 'visual-builder')
        ),

        array(
            'name'       => __('Ultimate VC Addons', 'phlox-pro'),
            'slug'       => 'Ultimate_VC_Addons',
            'version'    => '3.16.25',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/Ultimate_VC_Addons.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('recommended', 'pagebuilder', 'bundled')
        ),

        array(
            'name'       => __('Visual CSS Style Editor: Yellow Pencil', 'phlox-pro'),
            'slug'       => 'waspthemes-yellow-pencil',
            'version'    => '7.0.6',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/waspthemes-yellow-pencil.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('recommended', 'bundled', 'visual-builder')
        ),

        array(
            'name'       => __('Revolution Slider', 'phlox-pro'),
            'slug'       => 'revslider',
            'version'    => '5.4.8',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/revslider.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('recommended', 'bundled')
        ),

        array(
            'name'       => __('LayerSlider', 'phlox-pro'),
            'slug'       => 'LayerSlider',
            'version'    => '6.7.6',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/LayerSlider.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('recommended', 'bundled')
        ),

        array(
            'name'       => __('Go Pricing Tables',  'phlox-pro'),
            'slug'       => 'go_pricing',
            'version'    => '3.3.13',
            'source'     => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/go_pricing.zip',
            'thumbnail'  => 'custom',
            'required'   => false,
            'categories' => array('recommended', 'bundled')
        ),

        array(
            'name'          => __('Convert Plus',  'phlox-pro'),
            'slug'          => 'convertplug',
            'version'       => '3.3.5',
            'source'        => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/convertplug.zip',
            'thumbnail'     => 'custom',
            'required'      => false,
            'categories'    => array('recommended', 'bundled')
        ),

        array(
            'name'             => __('ZoomSounds - Audio Player', 'phlox-pro'),
            'slug'             => 'dzs-zoomsounds',
            'version'          => '5.12',
            'source'           => 'http://dl.averta.net/themes/premium/phlox/27tmpha29ix/dzs-zoomsounds.zip',
            'thumbnail'        => 'custom',
            'required'         => false,
            'categories'       => array('recommended', 'bundled')
        ),

        array(
            'name'             => __('Auto Theme Updater', 'phlox-pro'),
            'slug'             => 'envato-market',
            'version'          => '2.0.0',
            'source'           => 'http://envato.github.io/wp-envato-market/dist/envato-market.zip', // The "external" source of the plugin.
            'thumbnail'        => 'default',
            'required'         => true,
            'force_activation' => false,
            'categories'       => array('bundled')
        ),
        array(
            'name'       => __('Page Builder', 'phlox-pro'),
            'slug'       => 'siteorigin-panels',
            'required'   => false,
            'categories' => array('recommended', 'pagebuilder')
        ),

        array(
            'name'       => __('Page Builder Widgets Bundle', 'phlox-pro'),
            'slug'       => 'so-widgets-bundle',
            'required'   => false,
            'categories' => array('recommended', 'pagebuilder')
        ),

        array(
            'name'       => __('Instagram Feed', 'phlox-pro'),
            'slug'       => 'instagram-feed',
            'required'   => false,
            'categories' => array('recommended', 'social')
        ),

        array(
            'name'       => __('WordPress SEO', 'phlox-pro'),
            'slug'       => 'wordpress-seo',
            'required'   => false,
            'categories' => array('recommended', 'optimization')
        ),

        array(
            'name'       => __('Recent Tweets Widget', 'phlox-pro'),
            'slug'       => 'recent-tweets-widget',
            'required'   => false,
            'categories' => array('recommended', 'social')
        ),

        array(
            'name'       => __('Contact Form 7', 'phlox-pro'),
            'slug'       => 'contact-form-7',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Dokan - WooCommerce Multivendor Marketplace ', 'phlox-pro'),
            'slug'       => 'dokan-lite',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('WordPress Importer', 'phlox-pro'),
            'slug'       => 'wordpress-importer',
            'required'   => false,
            'thumbnail'  => 'default',
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Related Posts for WordPress', 'phlox-pro'),
            'slug'       => 'related-posts-for-wp',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('WP ULike', 'phlox-pro'),
            'slug'       => 'wp-ulike',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Autoptimize', 'phlox-pro'),
            'slug'       => 'autoptimize',
            'required'   => false,
            'categories' => array('recommended', 'optimization')
        ),

        array(
            'name'       => __('Custom Facebook Feed', 'phlox-pro'),
            'slug'       => 'custom-facebook-feed',
            'required'   => false,
            'thumbnail'  => 'default',
            'categories' => array('recommended', 'social')
        ),

        array(
            'name'       => __('Flickr Justified Gallery', 'phlox-pro'),
            'slug'       => 'flickr-justified-gallery',
            'required'   => false,
            'thumbnail'  => 'default',
            'categories' => array('recommended', 'social')
        ),

        array(
            'name'       => __('Image Optimization', 'phlox-pro'),
            'slug'       => 'wp-smushit',
            'required'   => false,
            'thumbnail'  => 'default',
            'categories' => array('recommended', 'optimization')
        ),

        array(
            'name'       => __('Export/Import Theme Options', 'phlox-pro'),
            'slug'       => 'customizer-export-import',
            'required'   => false,
            'thumbnail'  => 'default',
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Popular Posts', 'phlox-pro'),
            'slug'       => 'wordpress-popular-posts',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('EU Cookie Notce', 'phlox-pro'),
            'slug'       => 'cookie-notice',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('MailChimp for WordPress', 'phlox-pro'),
            'slug'       => 'mailchimp-for-wp',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Widgets for SiteOrigin', 'phlox-pro'),
            'slug'       => 'widgets-for-siteorigin',
            'required'   => false,
            'categories' => array('recommended', 'pagebuilder')
        ),

        array(
            'name'       => __('Real-time Bitcoin Converter', 'phlox-pro'),
            'slug'       => 'real-time-bitcoin-currency-converter',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Custom Sidebars', 'phlox-pro'),
            'slug'       => 'custom-sidebars',
            'required'   => false,
            'categories' => array('recommended')
        ),

        array(
            'name'       => __('Simple Taxonomy Ordering', 'phlox-pro'),
            'slug'       => 'simple-taxonomy-ordering',
            'required'   => false,
            'categories' => array('recommended')
        )
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'phlox-pro',            // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => get_template_directory() . "/auxin-content/embeds/plugins/",                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => false,                   // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

        'strings'      => array(
            'page_title'                      => __( 'Install Recommended Plugins', 'phlox-pro' ),
            'menu_title'                      => __( 'Install Plugins', 'phlox-pro' )
        )
    );

    tgmpa( $plugins, $config );
}

function auxin_define_plugins_categories_localized( $plugin_categories ){
    $extra = array(
        //'auxin'          => __( 'Exclusive', 'phlox-pro' ),
        //'pagebuilder'    => __( 'Page Builder', 'phlox-pro' ),
        'essential'      => __( 'Essentials', 'phlox-pro' ),
        'bundled'        => __( 'Bundled', 'phlox-pro' ),
        'recommended'    => __( 'Recommended', 'phlox-pro' ),
        'visual-builder' => __( 'Visual Builder', 'phlox-pro' ),
        'e-commerce'     => __( 'E-Commerce', 'phlox-pro' ),
        'blog'           => __( 'Blog', 'phlox-pro' ),
        'social'         => __( 'Social', 'phlox-pro' ),
        'optimization'   => __( 'Optimization', 'phlox-pro' )
    );

    return array_merge( $plugin_categories, $extra );
}
add_filter( 'auxin_admin_welcome_plugins_categories_localized', 'auxin_define_plugins_categories_localized' );

/*-----------------------------------------------------------------------------------*/
/*  Adds dashboard tab in theme about (welcome) page
/*-----------------------------------------------------------------------------------*/

function auxin_welcome_page_display_section_dashboard(){

    ?>
    <section class="aux-col-wrap aux-big-banners-row">
        <div class="aux-col2">
            <div class="aux-big-banner aux-importer-banner">
                <h3><?php _e( "Import Demo", 'phlox-pro' ); ?></h3>
                <p><?php _e( "Clone a demo site in few clicks", 'phlox-pro' ); ?></p>
                <a class="aux-wl-button aux-round aux-large aux-black" href="<?php echo auxin_welcome_page()->get_tab_link('importer'); ?>"><?php _e( "Run Importer", 'phlox-pro' ); ?></a>
            </div>
        </div>
        <div class="aux-col2">
            <div class="aux-big-banner aux-customize-banner">
                <h3><?php _e( "Customize Phlox", 'phlox-pro' ); ?></h3>
                <p><?php _e( "Customize any part of your website.", 'phlox-pro' ); ?></p>
                <a class="aux-wl-button aux-round aux-large aux-black" href="<?php echo self_admin_url( 'customize.php' ); ?>"><?php _e( "Customize", 'phlox-pro' ); ?></a>
            </div>
        </div>
    </section>
    <?php
    $support_link  = 'http://support.averta.net/en/topic-form/?ids=';
    $support_link .= (defined('THEME_PRO') && THEME_PRO) ? '51166' : '34922';
    $support_link .= '&utm_source=phlox-welcome&utm_medium=phlox-free&utm_content=submit-ticket&utm_term=support';

    $doc_link   = 'https://docs.phlox.pro/';
    $doc_link  .= '?utm_source=phlox-welcome&utm_medium=phlox-free&utm_content=dashboard-doc&utm_term=documentation';
    ?>
    <section class="aux-col-wrap aux-info-blocks-row">
        <div class="aux-col3">
            <div class="aux-info-block aux-info-block-support">
                <img class="welcome-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/support.svg'; ?>">
                <h4><?php _e( "Need Some Help?", 'phlox-pro' ); ?></h4>
                <p><?php _e( "We would love to be of any assistance.", 'phlox-pro' ); ?></p>
                <div><a class="aux-wl-button aux-round aux-large aux-green" href="<?php echo esc_url( $support_link ); ?>" target="_blank"><?php _e( "Send Ticket", 'phlox-pro' ); ?></a></div>
            </div>
        </div>
        <div class="aux-col3">
            <div class="aux-info-block aux-info-block-documentation">
                <img class="welcome-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/documentation.svg'; ?>">
                <h4><?php _e( "Documentation", 'phlox-pro' ); ?></h4>
                <p><?php _e( "Learn about any aspect of Phlox Theme.", 'phlox-pro' ); ?></p>
                <div><a class="aux-wl-button aux-round aux-large aux-orange" href="<?php echo esc_url( $doc_link ); ?>" target="_blank"><?php _e( "Start Reading", 'phlox-pro' ); ?></a></div>
            </div>
        </div>
        <div class="aux-col3">
            <div class="aux-info-block aux-info-block-subscribe">
                <img class="welcome-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/subscription.svg'; ?>">
                <h4><?php _e( "Subscription", 'phlox-pro' ); ?></h4>
                <p><?php _e( "Get the latest changes in your inbox.", 'phlox-pro' ); ?></p>
                <div><a class="aux-wl-button aux-round aux-large aux-black disabled" href="#"><?php _e( "Coming soon", 'phlox-pro' ); ?></a></div>
            </div>
        </div>
    </section>
    <?php
}

function auxin_welcome_add_section_dashboard( $sections ){

    $sections['dashboard'] = array(
        'label'          => __( 'Dashboard', 'phlox-pro' ),
        'description'    => '',
        'callback'       => 'auxin_welcome_page_display_section_dashboard',
        'add_admin_menu' => true
    );

    return $sections;
}

add_filter( 'auxin_admin_welcome_sections', 'auxin_welcome_add_section_dashboard', 20 );

/*-----------------------------------------------------------------------------------*/
/*  Adds customize tab in theme about (welcome) page
/*-----------------------------------------------------------------------------------*/

function auxin_welcome_add_section_customize( $sections ){

    $sections['customize'] = array(
        'label'            => esc_html__( 'Customization', 'phlox-pro' ),
        'description'      => '',
        'url'              => self_admin_url( 'customize.php' ),
        'add_admin_menu'   => true
    );

    return $sections;
}

add_filter( 'auxin_admin_welcome_sections', 'auxin_welcome_add_section_customize', 60 );

/*-----------------------------------------------------------------------------------*/
/*  Get and inject generate styles in content of custom css file
/*-----------------------------------------------------------------------------------*/

/**
 * Get generated styles by option panel
 *
 * @return string    return generated styles
 */
function auxin_add_option_styles( $css ){

    $sorted_sections = Auxin_Option::api()->data->sorted_sections;
    $sorted_fields   = Auxin_Option::api()->data->sorted_fields;


    foreach ( $sorted_fields as $section_id => $fields ) {
        foreach ( $fields as $field_id => $field ) {
            if( isset( $field['style_callback'] ) && ! empty( $field['style_callback'] ) ){
                $css[ $field_id ] = call_user_func( $field['style_callback'], null );
            } elseif( ! empty( $field['selectors'] ) ){
                $selectors = '';
                // convert the selector to string
                if( ! empty( $field['selectors'] ) ){
                    if( is_array( $field['selectors'] ) ){
                        foreach ( $field['selectors'] as $property => $property_value ) {
                            // if just array value is set
                            if( is_numeric( $property ) ){
                                $selectors .= $property_value . ',';
                            } else {
                                $selectors .= $property . '{'. $property_value .'} ';
                            }
                        }
                    } else {
                        $selectors = $field['selectors'];
                    }
                }

                $selectors = trim( $selectors, ', ' );

                if( '' !== $replacement_value = auxin_get_option( $field_id, '' ) ){

                    $replacement_value = trim( $replacement_value, ', ' );

                    if( ( '{' === $replacement_value[0] ) && ( $parsed_json = json_decode($replacement_value) ) && (json_last_error() == JSON_ERROR_NONE) ){
                        $css_generator = new Auxin_CSS_Generator_Option_Manager();
                        $css[ $field_id ] = $css_generator->get_css( $replacement_value, $selectors );
                        Auxin_Fonts::get_instance()->parse_typography();
                    } else {
                        $css[ $field_id ] = str_replace( "{{VALUE}}" , $replacement_value, $selectors );
                    }
                } else {
                    unset( $css[ $field_id ] );
                }
            } else {
                unset( $css[ $field_id ] );
            }
        }
    }

    return $css;
}

add_filter( 'auxin_custom_css_file_content', 'auxin_add_option_styles' );

/*-----------------------------------------------------------------------------------*/
/*  Adds support tab in theme about (welcome) page
/*-----------------------------------------------------------------------------------*/

function auxin_welcome_page_display_section_tutorials(){
    $support_link  = 'http://support.averta.net/en/item/';
    $support_link .= (defined('THEME_PRO') && THEME_PRO) ? 'phlox-pro/' : 'phlox/';
    $support_link .= '?utm_source=phlox-welcome&utm_medium=phlox-free&utm_content=tuts-forum&utm_term=support';

    $doc_link   = 'https://docs.phlox.pro/';
    $doc_link  .= '?utm_source=phlox-welcome&utm_medium=phlox-free&utm_content=tuts-doc&utm_term=documentation';
    ?>
    <div class="feature-section aux-welcome-page-tutorials">
        <div class="aux-section-content-box aux-clearfix">
            <a href="https://www.youtube.com/playlist?list=PL7X-1Jmy1jcdekHe6adxB81SBcrHOmLRS" target="_blank" title="<?php _e( 'Play all video tutorials' ,'phlox-pro' ); ?>"><img width="111" class="aux-tutts-info-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/video-tuts.svg'; ?>" /></a>
            <div class="aux-tutts-info-title-wrap">
                <h3 class="aux-content-title"><?php _e('Video Tutorials', 'phlox-pro' ); ?></h3>
                <p class="aux-content-subtitle"><?php printf( __('Take your skills with %s to the next level!', 'phlox-pro' ), '<strong>' . THEME_NAME_I18N . '</strong>' ); ?></p>
            </div>
            <a class="aux-tutts-info-doc-wrap" href="<?php echo esc_url( $doc_link ); ?>" target="_blank">
                <img width="69" class="tuts-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/documentation.svg'; ?>">
                <h3 class="aux-content-title"><?php _e('Documentation', 'phlox-pro' ); ?></h3>
                <span class="aux-text-link"><?php _e('Check out', 'phlox-pro' ); ?></span>
            </a>
            <a class="aux-tutts-info-support-wrap" href="<?php echo esc_url( $support_link ); ?>" target="_blank">
                <img width="75" class="tuts-icon" src="<?php echo esc_url( AUXIN_URL ) . 'css/images/welcome/support.svg'; ?>">
                <h3 class="aux-content-title"><?php _e('Support Center', 'phlox-pro' ); ?></h3>
                <span class="aux-text-link"><?php _e('Check out', 'phlox-pro' ); ?></span>
            </a>
        </div>
    </div>
    <?php
}

function auxin_welcome_add_section_support( $sections ){

    $sections['help'] = array(
        'label'          => __( 'Tutorials', 'phlox-pro' ),
        'description'    => '',
        'callback'       => 'auxin_welcome_page_display_section_tutorials',
        'add_admin_menu' => true
    );

    return $sections;
}

add_filter( 'auxin_admin_welcome_sections', 'auxin_welcome_add_section_support', 80 );

/*-----------------------------------------------------------------------------------*/
/*  Adds importer tab in theme about (welcome) page
/*-----------------------------------------------------------------------------------*/

function auxin_welcome_page_display_section_import(){
    ?>
    <div class="aux-welcome-page-import">
        <div class="aux-section-content-box">
            <h3 class="aux-content-title"><?php _e('Please install "Phlox Core Elements" plugin to enable this feature.', 'phlox-pro' ); ?></h3>
        </div>
    </div>
    <?php
}

function auxin_welcome_add_section_importer( $sections ){

    $sections['importer'] = array(
        'label'       => esc_html__( 'Demo Importer', 'phlox-pro' ),
        'description' => '',
        'callback'    => 'auxin_welcome_page_display_section_import'
    );

    return $sections;
}
add_filter( 'auxin_admin_welcome_sections', 'auxin_welcome_add_section_importer', 60 );

/*-----------------------------------------------------------------------------------*/
/*  Turn off the automatic update check for Master Slider Pro
/*-----------------------------------------------------------------------------------*/

add_filter( 'masterslider_disable_auto_update', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*  Check theme requirements and throw a notice if the requirements are not met
/*-----------------------------------------------------------------------------------*/

if( version_compare( PHP_VERSION, '5.4.0', '<') || version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ){
    add_action( 'admin_notices', 'auxin_theme_requirements_notice' );
}

/**
 * Adds a message for theme requirements.
 *
 * @global string $wp_version WordPress version.
 */
function auxin_theme_requirements_notice() {
    $message = sprintf( __( 'This theme requires at least WordPress version 4.7 and PHP 5.4. You are running WordPress version %s and PHP version %s. Please upgrade and try again.', 'phlox-pro' ), $GLOBALS['wp_version'], PHP_VERSION );
    printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Update the deprecated option ids
 *
 */
function auxn_update_deprecated_theme_options(){

    $option_fileds = Auxin_option::api()->data->fields;
    $auxin_array_options = get_option( THEME_ID.'_theme_options' , array() );

    foreach ( $option_fileds as $option_filed ) {
        if( ! empty( $option_filed['id_deprecated'] ) ){
            if( ! isset( $auxin_array_options[ $option_filed['id'] ] ) ){
                if( isset( $auxin_array_options[ $option_filed['id_deprecated'] ] ) ){
                    auxin_update_option( $option_filed['id'], $auxin_array_options[ $option_filed['id_deprecated'] ] );
                }
            }
        }
    }

}
add_action( 'auxin_theme_updated', 'auxn_update_deprecated_theme_options' );
