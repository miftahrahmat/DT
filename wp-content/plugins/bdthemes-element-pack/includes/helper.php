<?php
use ElementPack\Element_Pack_Loader;


/**
 * Show any alert by this function
 * @param  mixed  $message [description]
 * @param  class prefix  $type    [description]
 * @param  boolean $close   [description]
 * @return helper           [description]
 */
function element_pack_alert($message, $type = 'warning', $close = true) {
    ?>
    <div class="bdt-alert-<?php echo $type; ?>" bdt-alert>
        <?php if($close) : ?>
            <a class="bdt-alert-close" bdt-close></a>
        <?php endif; ?>
        <?php echo wp_kses_post( $message ); ?>
    </div>
    <?php
}

/**
 * all array css classes will output as proper space
 * @param array $classes shortcode css class as array
 * @return proper string
 */

function bdt_get_post_types(){

    $cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
    $exclude_cpts = array( 'elementor_library', 'attachment', 'product' );

    foreach ( $exclude_cpts as $exclude_cpt ) {
        unset($cpts[$exclude_cpt]);
    }

    $post_types = array_merge($cpts);
    return $post_types;
}

/**
 * Add REST API support to an already registered post type.
 */

// function bdt_custom_post_type_rest_support() {
//     global $wp_post_types;

//     $post_types = bdt_get_post_types();
//     foreach( $post_types as $post_type ) {
//         $post_type_name = $post_type;
//         if( isset( $wp_post_types[ $post_type_name ] ) ) {
//             $wp_post_types[$post_type_name]->show_in_rest = true;
//             $wp_post_types[$post_type_name]->rest_base = $post_type_name;
//             $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
//         }
//     }

// }

// add_action( 'init', 'bdt_custom_post_type_rest_support', 25 );

/**
 * subscribe mailchimp with api key
 * @param  string $email        any valid email
 * @param  string $status       subscribe or unsubscribe
 * @param  array  $merge_fields First name and last name of subscriber
 * @return [type]               [description]
 */
function element_pack_mailchimp_subscriber_status( $email, $status, $merge_fields = array('FNAME' => '','LNAME' => '') ){

    $options = get_option( 'element_pack_api_settings' );
    $list_id = (!empty($options['mailchimp_list_id'])) ? $options['mailchimp_list_id'] : ''; // Your list is here
    $api_key = (!empty($options['mailchimp_api_key'])) ? $options['mailchimp_api_key'] : ''; // Your mailchimp api key here

    $data = array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields
    );
    $mailchimp_api = curl_init(); // init cURL connection
 
    curl_setopt($mailchimp_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mailchimp_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mailchimp_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mailchimp_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($mailchimp_api, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($mailchimp_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mailchimp_api, CURLOPT_POST, true);
    curl_setopt($mailchimp_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mailchimp_api, CURLOPT_POSTFIELDS, json_encode($data) );
 
    $result = curl_exec($mailchimp_api);

    return $result;
}


if (!function_exists('element_pack_allow_tags')) {
    function element_pack_allow_tags($tag = null) {
        $tag_allowed = wp_kses_allowed_html('post');

        $tag_allowed['input'] = array(
            'class'   => [],
            'id'      => [],
            'name'    => [],
            'value'   => [],
            'checked' => [],
            'type'    => []
        );
        $tag_allowed['select'] = array(
            'class'    => [],
            'id'       => [],
            'name'     => [],
            'value'    => [],
            'multiple' => [],
            'type'     => []
        );
        $tag_allowed['option'] = array(
            'value'    => [],
            'selected' => []
        );

        if($tag == null){
            return $tag_allowed;
        }
        elseif(is_array($tag)){
            $new_tag_allow = [];
            foreach ($tag as $_tag){
                $new_tag_allow[$_tag] = $tag_allowed[$_tag];
            }

            return $new_tag_allow;
        }
        else{
            return isset($tag_allowed[$tag]) ? array($tag=>$tag_allowed[$tag]) : [];
        }
    }
}

/**
 * post pagination
 */
function element_pack_post_pagination($wp_query) {

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="bdt-pagination bdt-flex-center">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('<span bdt-pagination-previous></span>') );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="current"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="bdt-pagination-dot-dot"><span>...</span></li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="bdt-active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="bdt-pagination-dot-dot"><span>...</span></li>' . "\n";

        $class = $paged == $max ? ' class="bdt-active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('<span bdt-pagination-next></span>') );

    echo '</ul>' . "\n";
}


function element_pack_iso_time($time) {
    $current_offset = (float) get_option( 'gmt_offset' );
    $timezone_string = get_option( 'timezone_string' );

    // Create a UTC+- zone if no timezone string exists.
    //if ( empty( $timezone_string ) ) {
        if ( 0 === $current_offset ) {
            $timezone_string = '+00:00';
        } elseif ( $current_offset < 0 ) {
            $timezone_string = $current_offset . ':00';
        } else {
            $timezone_string = '+0' . $current_offset . ':00';
        }
    //}

    $sub_time = [];
    $sub_time = explode(" ", $time);
    $final_time = $sub_time[0] .'T'. $sub_time[1] .':00' . $timezone_string;

    return $final_time;
}


/**
 * Make sure elementor plugin installed or not
 * @return error message
 */
function bdthemes_elementor_not_found() {
    $class = 'notice notice-error';
    $message = __( 'Ops! Elementor Plugin Not Found! Make sure you installed and Activated correctly.', 'bdthemes-element-pack' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

function element_pack_get_menu() {
    $menus = wp_get_nav_menus();
    $items = ['0' => esc_html__( 'Select Menu', 'bdthemes-element-pack' ) ];
    foreach ( $menus as $menu ) {
        $items[ $menu->slug ] = $menu->name;
    }

    return $items;
}

/**
 * default get_option() default value check
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function element_pack_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

// Anywhere Template
// function element_pack_ae_options() {    
//     if (post_type_exists('ae_global_templates')) {
//         $anywhere = get_posts(array(
//             'fields'         => 'ids', // Only get post IDs
//             'posts_per_page' => -1,
//             'post_type'      => 'ae_global_templates',
//         ));

//         $anywhere_options = ['0' => esc_html__( 'Select Template', 'bdthemes-element-pack' ) ];

//         foreach ($anywhere as $key => $value) {
//             $anywhere_options[$value] = get_the_title($value);
//         }        
//     } else {
//         $anywhere_options = ['0' => esc_html__( 'AE Plugin Not Installed', 'bdthemes-element-pack' ) ];
//     }
//     return $anywhere_options;
// }

// Elementor Saved Template 
// function element_pack_et_options() {
//     $templates = Element_Pack_Loader::elementor()->templates_manager->get_source( 'local' )->get_items();
//     $types     = [];

//     if ( empty( $templates ) ) {
//         $template_options = [ '0' => __( 'You Haven’t Saved Templates Yet.', 'bdthemes-element-pack' ) ];
//     } else {
//         $template_options = [ '0' => __( 'Select Template', 'bdthemes-element-pack' ) ];
        
//         foreach ( $templates as $template ) {
//             $template_options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
//             $types[ $template['template_id'] ] = $template['type'];
//         }
//     }

//     return $template_options;
// }

// Sidebar Widgets
function element_pack_sidebar_options() {
    global $wp_registered_sidebars;
    $sidebar_options = [];

    if ( ! $wp_registered_sidebars ) {
        $sidebar_options['0'] = esc_html__( 'No sidebars were found', 'bdthemes-element-pack' );
    } else {
        $sidebar_options['0'] = esc_html__( 'Select Sidebar', 'bdthemes-element-pack' );

        foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
            $sidebar_options[ $sidebar_id ] = $sidebar['name'];
        }
    }

    return $sidebar_options;
}

function element_pack_get_category($terms) {
    $post_categories = get_terms( $terms );

    $post_options = [];
    foreach ( $post_categories as $category ) {
        $post_options[ $category->slug ] = $category->name;
    }

    return $post_options;
}

// BDT Transition
function element_pack_transition_options() {
    $transition_options = [
        ''                    => esc_html__('None', 'bdthemes-element-pack'),
        'fade'                => esc_html__('Fade', 'bdthemes-element-pack'),
        'scale-up'            => esc_html__('Scale Up', 'bdthemes-element-pack'),
        'scale-down'          => esc_html__('Scale Down', 'bdthemes-element-pack'),
        'slide-top'           => esc_html__('Slide Top', 'bdthemes-element-pack'),
        'slide-bottom'        => esc_html__('Slide Bottom', 'bdthemes-element-pack'),
        'slide-left'          => esc_html__('Slide Left', 'bdthemes-element-pack'),
        'slide-right'         => esc_html__('Slide Right', 'bdthemes-element-pack'),
        'slide-top-small'     => esc_html__('Slide Top Small', 'bdthemes-element-pack'),
        'slide-bottom-small'  => esc_html__('Slide Bottom Small', 'bdthemes-element-pack'),
        'slide-left-small'    => esc_html__('Slide Left Small', 'bdthemes-element-pack'),
        'slide-right-small'   => esc_html__('Slide Right Small', 'bdthemes-element-pack'),
        'slide-top-medium'    => esc_html__('Slide Top Medium', 'bdthemes-element-pack'),
        'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'bdthemes-element-pack'),
        'slide-left-medium'   => esc_html__('Slide Left Medium', 'bdthemes-element-pack'),
        'slide-right-medium'  => esc_html__('Slide Right Medium', 'bdthemes-element-pack'),
    ];

    return $transition_options;
}

// BDT Blend Type
function element_pack_blend_options() {
    $blend_options = [
        'multiply'    => esc_html__( 'Multiply', 'bdthemes-element-pack' ),
        'screen'      => esc_html__( 'Screen', 'bdthemes-element-pack' ),
        'overlay'     => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
        'darken'      => esc_html__( 'Darken', 'bdthemes-element-pack' ),
        'lighten'     => esc_html__( 'Lighten', 'bdthemes-element-pack' ),
        'color-dodge' => esc_html__( 'Color-Dodge', 'bdthemes-element-pack' ),
        'color-burn'  => esc_html__( 'Color-Burn', 'bdthemes-element-pack' ),
        'hard-light'  => esc_html__( 'Hard-Light', 'bdthemes-element-pack' ),
        'soft-light'  => esc_html__( 'Soft-Light', 'bdthemes-element-pack' ),
        'difference'  => esc_html__( 'Difference', 'bdthemes-element-pack' ),
        'exclusion'   => esc_html__( 'Exclusion', 'bdthemes-element-pack' ),
        'hue'         => esc_html__( 'Hue', 'bdthemes-element-pack' ),
        'saturation'  => esc_html__( 'Saturation', 'bdthemes-element-pack' ),
        'color'       => esc_html__( 'Color', 'bdthemes-element-pack' ),
        'luminosity'  => esc_html__( 'Luminosity', 'bdthemes-element-pack' ),
    ];

    return $blend_options;
}

// BDT Position
function element_pack_position() {
    $position_options = [
        ''              => esc_html__('Default', 'bdthemes-element-pack'),
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center'        => esc_html__('Center', 'bdthemes-element-pack') ,
        'center-left'   => esc_html__('Center Left', 'bdthemes-element-pack') ,
        'center-right'  => esc_html__('Center Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

// BDT Thumbnavs Position
function element_pack_thumbnavs_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center-left'   => esc_html__('Center Left', 'bdthemes-element-pack') ,
        'center-right'  => esc_html__('Center Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

function element_pack_navigation_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center'        => esc_html__('Center', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}


function element_pack_pagination_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

// BDT Drop Position
function element_pack_drop_position() {
    $drop_position_options = [
        'bottom-left'    => esc_html__('Bottom Left', 'bdthemes-element-pack'),
        'bottom-center'  => esc_html__('Bottom Center', 'bdthemes-element-pack'),
        'bottom-right'   => esc_html__('Bottom Right', 'bdthemes-element-pack'),
        'bottom-justify' => esc_html__('Bottom Justify', 'bdthemes-element-pack'),
        'top-left'       => esc_html__('Top Left', 'bdthemes-element-pack'),
        'top-center'     => esc_html__('Top Center', 'bdthemes-element-pack'),
        'top-right'      => esc_html__('Top Right', 'bdthemes-element-pack'),
        'top-justify'    => esc_html__('Top Justify', 'bdthemes-element-pack'),
        'left-top'       => esc_html__('Left Top', 'bdthemes-element-pack'),
        'left-center'    => esc_html__('Left Center', 'bdthemes-element-pack'),
        'left-bottom'    => esc_html__('Left Bottom', 'bdthemes-element-pack'),
        'right-top'      => esc_html__('Right Top', 'bdthemes-element-pack'),
        'right-center'   => esc_html__('Right Center', 'bdthemes-element-pack'),
        'right-bottom'   => esc_html__('Right Bottom', 'bdthemes-element-pack'),
    ];

    return $drop_position_options;
}

// Button Size
function element_pack_button_sizes() {
    $button_sizes = [
        'xs' => esc_html__( 'Extra Small', 'bdthemes-element-pack' ),
        'sm' => esc_html__( 'Small', 'bdthemes-element-pack' ),
        'md' => esc_html__( 'Medium', 'bdthemes-element-pack' ),
        'lg' => esc_html__( 'Large', 'bdthemes-element-pack' ),
        'xl' => esc_html__( 'Extra Large', 'bdthemes-element-pack' ),
    ];

    return $button_sizes;
}

// Button Size
function element_pack_heading_size() {
    $heading_sizes = [
        'h1' => esc_html__( 'H1', 'bdthemes-element-pack' ),
        'h2' => esc_html__( 'H2', 'bdthemes-element-pack' ),
        'h3' => esc_html__( 'H3', 'bdthemes-element-pack' ),
        'h4' => esc_html__( 'H4', 'bdthemes-element-pack' ),
        'h5' => esc_html__( 'H5', 'bdthemes-element-pack' ),
        'h6' => esc_html__( 'H6', 'bdthemes-element-pack' ),
    ];

    return $heading_sizes;
}

// Title Tags
function element_pack_title_tags() {
    $title_tags = [
        'h1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
        'h2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
        'h3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
        'h4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
        'h5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
        'h6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
        'div'  => esc_html__( 'div', 'bdthemes-element-pack' ),
        'span' => esc_html__( 'span', 'bdthemes-element-pack' ),
        'p'    => esc_html__( 'p', 'bdthemes-element-pack' ),
    ];

    return $title_tags;
}
/**
 * This is a svg file converter function which return a svg content 
 * @param  svg file
 * @return svg content
 */
function element_pack_svg_icon($icon) {

    $icon_path = BDTEP_ASSETS_PATH . "images/svg/{$icon}.svg";

    if ( !file_exists( $icon_path ) ) { return false; }

    ob_start();

    include $icon_path;

    $svg = ob_get_clean();

    return $svg;
}

/**
 * create function for create on-fly function for some cases
 * @param on-fly function param
 * @code on-fly function code
 * @return function
 */
if(!function_exists("create_function")){
    function create_function($params,$code) { 
        eval('$g=function(' . $params . '){ ' . $code . ' };');
        return $g;
    }
}



/**
 * weather code to icon and description output
 * more info: http://www.apixu.com/doc/Apixu_weather_conditions.json
 */
function element_pack_weather_code( $code = null, $condition = null ) {

    $codes = apply_filters( 'element-pack/weather/codes', [
        "1000" => [
            "desc" => esc_html_x("Sunny", "Weather String", "bdthemes-element-pack" ),
            "icon" => "113"
        ],
        "1003" => [
            "desc" => esc_html_x("Partly cloudy", "Weather String", "bdthemes-element-pack" ),
            "icon" => "116"
        ],
        "1006" => [
            "desc" => esc_html_x("Cloudy", "Weather String", "bdthemes-element-pack" ),
            "icon" => "119"
        ],
        "1009" => [
            "desc" => esc_html_x("Overcast", "Weather String", "bdthemes-element-pack" ),
            "icon" => "122"
        ],
        "1030" => [
            "desc" => esc_html_x("Mist", "Weather String", "bdthemes-element-pack" ),
            "icon" => "143"
        ],
        "1063" => [
            "desc" => esc_html_x("Patchy rain possible", "Weather String", "bdthemes-element-pack" ),
            "icon" => "176"
        ],
        "1066" => [
            "desc" => esc_html_x("Patchy snow possible", "Weather String", "bdthemes-element-pack" ),
            "icon" => "179"
        ],
        "1069" => [
            "desc" => esc_html_x("Patchy sleet possible", "Weather String", "bdthemes-element-pack" ),
            "icon" => "182"
        ],
        "1072" => [
            "desc" => esc_html_x("Patchy freezing drizzle possible", "Weather String", "bdthemes-element-pack" ),
            "icon" => "185"
        ],
        "1087" => [
            "desc" => esc_html_x("Thundery outbreaks possible", "Weather String", "bdthemes-element-pack" ),
            "icon" => "200"
        ],
        "1114" => [
            "desc" => esc_html_x("Blowing snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "227"
        ],
        "1117" => [
            "desc" => esc_html_x("Blizzard", "Weather String", "bdthemes-element-pack" ),
            "icon" => "230"
        ],
        "1135" => [
            "desc" => esc_html_x("Fog", "Weather String", "bdthemes-element-pack" ),
            "icon" => "248"
        ],
        "1147" => [
            "desc" => esc_html_x("Freezing fog", "Weather String", "bdthemes-element-pack" ),
            "icon" => "260"
        ],
        "1150" => [
            "desc" => esc_html_x("Patchy light drizzle", "Weather String", "bdthemes-element-pack" ),
            "icon" => "263"
        ],
        "1153" => [
            "desc" => esc_html_x("Light drizzle", "Weather String", "bdthemes-element-pack" ),
            "icon" => "266"
        ],
        "1168" => [
            "desc" => esc_html_x("Freezing drizzle", "Weather String", "bdthemes-element-pack" ),
            "icon" => "281"
        ],
        "1171" => [
            "desc" => esc_html_x("Heavy freezing drizzle", "Weather String", "bdthemes-element-pack" ),
            "icon" => "284"
        ],
        "1180" => [
            "desc" => esc_html_x("Patchy light rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "293"
        ],
        "1183" => [
            "desc" => esc_html_x("Light rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "296"
        ],
        "1186" => [
            "desc" => esc_html_x("Moderate rain at times", "Weather String", "bdthemes-element-pack" ),
            "icon" => "299"
        ],
        "1189" => [
            "desc" => esc_html_x("Moderate rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "302"
        ],
        "1192" => [
            "desc" => esc_html_x("Heavy rain at times", "Weather String", "bdthemes-element-pack" ),
            "icon" => "305"
        ],
        "1195" => [
            "desc" => esc_html_x("Heavy rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "308"
        ],
        "1198" => [
            "desc" => esc_html_x("Light freezing rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "311"
        ],
        "1201" => [
            "desc" => esc_html_x("Moderate or heavy freezing rain", "Weather String", "bdthemes-element-pack" ),
            "icon" => "314"
        ],
        "1204" => [
            "desc" => esc_html_x("Light sleet", "Weather String", "bdthemes-element-pack" ),
            "icon" => "317"
        ],
        "1207" => [
            "desc" => esc_html_x("Moderate or heavy sleet", "Weather String", "bdthemes-element-pack" ),
            "icon" => "320"
        ],
        "1210" => [
            "desc" => esc_html_x("Patchy light snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "323"
        ],
        "1213" => [
            "desc" => esc_html_x("Light snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "326"
        ],
        "1216" => [
            "desc" => esc_html_x("Patchy moderate snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "329"
        ],
        "1219" => [
            "desc" => esc_html_x("Moderate snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "332"
        ],
        "1222" => [
            "desc" => esc_html_x("Patchy heavy snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "335"
        ],
        "1225" => [
            "desc" => esc_html_x("Heavy snow", "Weather String", "bdthemes-element-pack" ),
            "icon" => "338"
        ],
        "1237" => [
            "desc" => esc_html_x("Ice pellets", "Weather String", "bdthemes-element-pack" ),
            "icon" => "350"
        ],
        "1240" => [
            "desc" => esc_html_x("Light rain shower", "Weather String", "bdthemes-element-pack" ),
            "icon" => "353"
        ],
        "1243" => [
            "desc" => esc_html_x("Moderate or heavy rain shower", "Weather String", "bdthemes-element-pack" ),
            "icon" => "356"
        ],
        "1246" => [
            "desc" => esc_html_x("Torrential rain shower", "Weather String", "bdthemes-element-pack" ),
            "icon" => "359"
        ],
        "1249" => [
            "desc" => esc_html_x("Light sleet showers", "Weather String", "bdthemes-element-pack" ),
            "icon" => "362"
        ],
        "1252" => [
            "desc" => esc_html_x("Moderate or heavy sleet showers", "Weather String", "bdthemes-element-pack" ),
            "icon" => "365"
        ],
        "1255" => [
            "desc" => esc_html_x("Light snow showers", "Weather String", "bdthemes-element-pack" ),
            "icon" => "368"
        ],
        "1258" => [
            "desc" => esc_html_x("Moderate or heavy snow showers", "Weather String", "bdthemes-element-pack" ),
            "icon" => "371"
        ],
        "1261" => [
            "desc" => esc_html_x("Light showers of ice pellets", "Weather String", "bdthemes-element-pack" ),
            "icon" => "374"
        ],
        "1264" => [
            "desc" => esc_html_x("Moderate or heavy showers of ice pellets", "Weather String", "bdthemes-element-pack" ),
            "icon" => "377"
        ],
        "1273" => [
            "desc" => esc_html_x("Patchy light rain with thunder", "Weather String", "bdthemes-element-pack" ),
            "icon" => "386"
        ],
        "1276" => [
            "desc" => esc_html_x("Moderate or heavy rain with thunder", "Weather String", "bdthemes-element-pack" ),
            "icon" => "389"
        ],
        "1279" => [
            "desc" => esc_html_x("Patchy light snow with thunder", "Weather String", "bdthemes-element-pack" ),
            "icon" => "392"
        ],
        "1282" => [
            "desc" => esc_html_x("Moderate or heavy snow with thunder", "Weather String", "bdthemes-element-pack" ),
            "icon" => "395"
        ]
    ]);

    if ( ! $code ) {
        return $codes;
    }

    $code_key = (string) $code;

    if ( ! isset( $codes[ $code_key ] ) ) {
        return false;
    }

    if ( $condition && isset( $codes[ $code_key ][ $condition ] ) ) {
        return $codes[ $code_key ][ $condition ];
    }

    return $codes[ $code_key ];
}

function element_pack_wind_code( $degree ) {
    
    $direction = '';

    if ( ( $degree >= 0 && $degree <= 33.75 ) or ( $degree > 348.75 && $degree <= 360 ) ) {
        $direction = esc_html_x( 'north', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 33.75 && $degree <= 78.75 ) {
        $direction = esc_html_x( 'north-east', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 78.75 && $degree <= 123.75 ) {
        $direction = esc_html_x( 'east', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 123.75 && $degree <= 168.75 ) {
        $direction = esc_html_x( 'south-east', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 168.75 && $degree <= 213.75 ) {
        $direction = esc_html_x( 'south', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 213.75 && $degree <= 258.75 ) {
        $direction = esc_html_x( 'south-west', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 258.75 && $degree <= 303.75 ) {
        $direction = esc_html_x( 'west', 'Weather String', 'bdthemes-element-pack' );
    } else if ( $degree > 303.75 && $degree <= 348.75 ) {
        $direction = esc_html_x( 'north-west', 'Weather String', 'bdthemes-element-pack' );
    }

    return $direction;
}


function element_pack_parse_csv($file) {
    $skip_char = $column = '';
    $csv_lines = file( $file );
    if ( is_array( $csv_lines ) ) {
        $cnt = count( $csv_lines );
        for ( $i = 0; $i < $cnt; $i++ ) {
            $line = $csv_lines[$i];
            $line = trim( $line );
            $first_char = true;
            $col_num = 0;
            $length = strlen( $line );
            for ( $b = 0; $b < $length; $b++ ) {
                if ( $skip_char != true ) {
                    $process = true;
                    if ( $first_char == true ) {
                        if ( $line[$b] == '"' ) {
                            $terminator = '";';
                            $process = false;
                        }
                        else
                            $terminator = ';';
                        $first_char = false;
                    }
                    if ( $line[$b] == '"' ) {
                        $next_char = $line[$b + 1];
                        if ( $next_char == '"' ) $skip_char = true;
                        elseif ( $next_char == ';' ) {
                            if ( $terminator == '";' ) {
                                $first_char = true;
                                $process = false;
                                $skip_char = true;
                            }
                        }
                    }
                    if ( $process == true ) {
                        if ( $line[$b] == ';' ) {
                            if ( $terminator == ';' ) {
                                $first_char = true;
                                $process = false;
                            }
                        }
                    }
                    if ( $process == true ) $column .= $line[$b];
                    if ( $b == ( $length - 1 ) ) $first_char = true;
                    if ( $first_char == true ) {
                        $values[$i][$col_num] = $column;
                        $column = '';
                        $col_num++;
                    }
                }
                else
                    $skip_char = false;
            }
        }
    }
    $return = '<table><thead><tr>';
    foreach ( $values[0] as $value ) $return .= '<th>' . $value . '</th>';
    $return .= '</tr></thead><tbody>';
    array_shift( $values );
    foreach ( $values as $rows ) {
        $return .= '<tr>';
        foreach ( $rows as $col ) {
            $return .= '<td>' . $col . '</td>';
        }
        $return .= '</tr>';
    }
    $return .= '</tbody></table>';
    return $return;
}

/**
 * String to ID maker for any title to relavent id
 * @param  [type] $string any title or string
 * @return [type]         [description]
 */
function element_pack_string_id($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    //finally return here
    return $string;
}


/**
 * Ninja form array creator for get all form as 
 * @return array [description]
 */
function element_pack_ninja_forms_options() {
    $form_options = [];
    if ( class_exists( 'Ninja_Forms' ) ) {
        $ninja_forms  = Ninja_Forms()->form()->get_forms();
        if ( ! empty( $ninja_forms ) && ! is_wp_error( $ninja_forms ) ) {
            $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
            foreach ( $ninja_forms as $form ) {   
                $form_options[ $form->get_id() ] = $form->get_setting( 'title' );
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}

function element_pack_caldera_forms_options() {
    if ( class_exists( 'Caldera_Forms' ) ) {
        $caldera_forms = Caldera_Forms_Forms::get_forms( true, true );
        $form_options  = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        $form          = [];
        if ( ! empty( $caldera_forms ) && ! is_wp_error( $caldera_forms ) ) {
            foreach ( $caldera_forms as $form ) {
                if ( isset($form['ID']) and isset($form['name'])) {
                    $form_options[$form['ID']] = $form['name'];
                }   
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}

function element_pack_quform_options() {
    if ( class_exists( 'Quform' ) ) {
        $quform       = Quform::getService('repository');
        $quform       = $quform->formsToSelectArray();
        $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        if ( ! empty( $quform ) && ! is_wp_error( $quform ) ) {
            foreach ( $quform as $id => $name ) {
                $form_options[esc_attr( $id )] = esc_html( $name );
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}


function element_pack_gravity_forms_options() {
    if ( class_exists( 'GFCommon' ) ) {
        $contact_forms = RGFormsModel::get_forms( null, 'title' );
        $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        if ( ! empty( $contact_forms ) && ! is_wp_error( $contact_forms ) ) {
            foreach ( $contact_forms as $form ) {   
                $form_options[ $form->id ] = $form->title;
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}


function element_pack_rev_slider_options() {
    if( class_exists( 'RevSlider' ) ){
        $slider             = new RevSlider();
        $revolution_sliders = $slider->getArrSliders();
        $slider_options     = ['0' => esc_html__( 'Select Slider', 'bdthemes-element-pack' ) ];
        if ( ! empty( $revolution_sliders ) && ! is_wp_error( $revolution_sliders ) ) {
            foreach ( $revolution_sliders as $revolution_slider ) {
               $alias = $revolution_slider->getAlias();
               $title = $revolution_slider->getTitle();
               $slider_options[$alias] = $title;
            }
        }
    } else {
        $slider_options = ['0' => esc_html__( 'No Slider Found!', 'bdthemes-element-pack' ) ];
    }
    return $slider_options;
}


/**
 * helper functions class for helping some common usage things
 */
if (!class_exists('element_pack_helper')) {
    class element_pack_helper {

        static $selfClosing = ['input'];

        /**
         * Renders a tag.
         *
         * @param  string $name
         * @param  array  $attrs
         * @param  string $text
         * @return string
         */
        public static function tag($name, array $attrs = [], $text = null) {
            $attrs = self::attrs($attrs);
            return "<{$name}{ $attrs }" . (in_array($name, self::$selfClosing) ? '/>' : ">$text</{$name}>");
        }

        /**
         * Renders a form tag.
         *
         * @param  array $tags
         * @param  array $attrs
         * @return string
         */
        public static function form($tags, array $attrs = []) {
            $attrs = self::attrs($attrs);
            return "<form{$attrs}>\n" . implode("\n", array_map(function($tag) {
                $output = self::tag($tag['tag'], array_diff_key($tag, ['tag' => null]));
                return $output;
            }, $tags)) . "\n</form>";
        }

        /**
         * Renders an image tag.
         *
         * @param  array|string $url
         * @param  array        $attrs
         * @return string
         */
        public static function image($url, array $attrs = []) {
            $url = (array) $url;
            $path = array_shift($url);
            $params = $url ? '?'.http_build_query(array_map(function ($value) {
                return is_array($value) ? implode(',', $value) : $value;
            }, $url)) : '';

            if (!isset($attrs['alt']) || empty($attrs['alt'])) {
                $attrs['alt'] = true;
            }

            $output = self::attrs(['src' => $path.$params], $attrs);

            return "<img{$output}>";
        }
        
        /**
         * Renders tag attributes.
         * @param  array $attrs
         * @return string
         */
        public static function attrs(array $attrs) {
            $output = [];

            if (count($args = func_get_args()) > 1) {
                $attrs = call_user_func_array('array_merge_recursive', $args);
            }

            foreach ($attrs as $key => $value) {

                if (is_array($value)) { $value = implode(' ', array_filter($value)); }
                if (empty($value) && !is_numeric($value)) { continue; }

                if (is_numeric($key)) {
                   $output[] = $value;
                } elseif ($value === true) {
                   $output[] = $key;
                } elseif ($value !== '') {
                   $output[] = sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false));
                }
            }

            return $output ? ' '.implode(' ', $output) : '';
        }

        /**
         * social icon generator from link
         * @param  [type] $link [description]
         * @return [type]       [description]
         */
        public static function icon($link) {
           static $icons;
           $icons = self::social_icons();

           if (strpos($link, 'mailto:') === 0) {
               return 'mail';
           }

           $icon = parse_url($link, PHP_URL_HOST);
           $icon = preg_replace('/.*?(plus\.google|[^\.]+)\.[^\.]+$/i', '$1', $icon);
           $icon = str_replace('plus.google', 'google-plus', $icon);

           if (!in_array($icon, $icons)) {
               $icon = 'social';
           }

           return $icon;
        }

        // most used social icons array
        public static function social_icons() {
           $icons = [ "behance", "dribbble", "facebook", "github-alt", "github", "foursquare", "tumblr", "whatsapp", "soundcloud", "flickr", "google-plus", "google", "linkedin", "vimeo", "instagram", "joomla", "pagekit", "pinterest", "twitter", "uikit", "wordpress", "xing", "youtube" ];

           return $icons;
        }


        public static function remove_p( $content ) {
            $content = force_balance_tags( $content );
            $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
            $content = preg_replace( '~\s?<p>(\s| )+</p>\s?~', '', $content );
            return $content;
        }

        /**
         * Get timezone id from server
         * @return [type] [description]
         */
        public static function get_timezone_id() {    
            $timezone = get_option( 'timezone_string' );

            /* If site timezone string exists, return it */
            if ( $timezone ) {
                return $timezone;
            }

            $utc_offset = 3600 * get_option( 'gmt_offset', 0 );

            /* Get UTC offset, if it isn't set return UTC */
            if ( ! $utc_offset ) {
                return 'UTC';
            }

            /* Attempt to guess the timezone string from the UTC offset */
            $timezone = timezone_name_from_abbr( '', $utc_offset );

            /* Last try, guess timezone string manually */
            if ( $timezone === false ) {

                $is_dst = date( 'I' );

                foreach ( timezone_abbreviations_list() as $abbr ) {
                    foreach ( $abbr as $city ) {
                        if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset ) {
                            return $city['timezone_id'];
                        }
                    }
                }
            }

            /* If we still haven't figured out the timezone, fall back to UTC */
            return 'UTC';
        }

        /**
         * ACtual CSS Class extrator
         * @param  [type] $classes [description]
         * @return [type]          [description]
         */
        public static function acssc($classes) {
            if (is_array($classes)) {
                $classes     = implode($classes, ' ');
            }
            $abs_classes = trim(preg_replace('/\s\s+/', ' ', $classes));
            return $abs_classes;
        }

        /**
         * Custom Excerpt Length
         * @param  integer $limit [description]
         * @return [type]         [description]
         */
        public static function custom_excerpt($limit=50) {
            return strip_shortcodes(wp_trim_words(get_the_content(), $limit, '...'));
        }

    }
}