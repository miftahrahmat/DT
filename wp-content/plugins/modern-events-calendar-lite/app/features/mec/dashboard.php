<?php
/** no direct access **/
defined('MECEXEC') or die();

// get screen id
$current_user = wp_get_current_user();

// user event created
$count_events = wp_count_posts($this->get_main_post_type());
$user_post_count = isset($count_events->publish) ? $count_events->publish : '0';

// user calendar created
$count_calendars = wp_count_posts('mec_calendars');
$user_post_count_c = isset($count_calendars->publish) ? $count_calendars->publish : '0';

// mec location
$user_location_count_l = wp_count_terms('mec_location', array(
    'hide_empty'=>false,
    'parent'=>0
));

// mec orgnizer
$user_organizer_count_l = wp_count_terms('mec_organizer', array(
    'hide_empty'=>false,
    'parent'=>0
));

$version = $verify = NULL;

if($this->getPRO())
{
    // Get MEC New Update
    $envato = $this->getEnvato();

    $v = $envato->get_MEC_info('version');
    $version = isset($v->version) ? $v->version : NULL;
    $verify = $envato->get_MEC_info('dl');
}

// MEC Database
$db = $this->getDB();

// MEC Settings
$settings = $this->get_settings();

// MEC Booking Status
$booking_status = ($this->getPRO() and isset($settings['booking_status']) and $settings['booking_status']) ? true : false;

// Add ChartJS library
if($booking_status) wp_enqueue_script('mec-chartjs-script', $this->asset('js/chartjs.min.js'));

// Whether to show dashboard boxes or not!
$box_support = apply_filters('mec_dashboard_box_support', true);
$box_stats = apply_filters('mec_dashboard_box_stats', true);
?>
<div id="webnus-dashboard" class="wrap about-wrap">
    <div class="welcome-head w-clearfix">
        <div class="w-row">
            <div class="w-col-sm-9">
                <h1> <?php echo sprintf(__('Welcome %s', 'modern-events-calendar-lite'), $current_user->user_firstname); ?> </h1>
                <div class="w-welcome">
                    <p>
                        <?php echo sprintf(__('%s - Most Powerful & Easy to Use Events Management System', 'modern-events-calendar-lite'), '<strong>'.($this->getPRO() ? __('Modern Events Calendar', 'modern-events-calendar-lite') : __('Modern Events Calendar (Lite)', 'modern-events-calendar-lite')).'</strong>'); ?>
                        <?php if(!$this->getPRO()): ?>
                        <span><a href="https://wordpress.org/support/plugin/modern-events-calendar-lite/reviews/#new-post" target="_blank"><?php echo _x('Rate the plugin ★★★★★', 'plugin rate', 'modern-events-calendar-lite'); ?></a></span>
                        <?php endif; ?>
                        <?php if(version_compare(MEC_VERSION , $version, '<')): ?>
                        <a class="mec-tooltip" title="<?php esc_attr_e("Update $version is ready for download.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="w-col-sm-3">
                <img src="<?php echo plugin_dir_url(__FILE__ ) . '../../../assets/img/mec-logo-w.png'; ?>" />
                <span class="w-theme-version"><?php echo __('Version', 'modern-events-calendar-lite'); ?> <?php echo MEC_VERSION; ?></span>
            </div>
        </div>
    </div>
    <div class="welcome-content w-clearfix extra">

        <?php if(!$this->getPRO()): ?>
        <div class="w-row mec-pro-notice">
            <div class="w-col-sm-12">
                <div class="info-msg"><?php echo sprintf(__("You're using %s version of Modern Events Calendar. To use advanced booking system, modern skins like Agenda, Timetable, Masonry, Yearly View, Available Spots, etc you should %s to the Pro version.", 'modern-events-calendar-lite'), '<strong>'.__('lite', 'modern-events-calendar-lite').'</strong>', '<a class="info-msg-link" href="'.$this->get_pro_link().'" target="_blank">'.__('upgrade', 'wpl').'</a>'); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="w-row">
            <!-- <div class="w-col-sm-12">
                <div class="w-box mec-intro-section">
                    <div class="w-box-head">
                        <?php _e('GETTING STARTED', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content mec-intro-section-welcome">
                        <h3><?php _e('Welcome to Modern Events Calendar' , 'modern-events-calendar-lite'); ?></h3>
                        <p><?php _e('We recommend you watch this 2 minute getting started video, and then try the editor yourself by dragging and dropping elements to create your first page.' , 'modern-events-calendar-lite'); ?></p>
                    </div>
                </div>
            </div> -->
            <?php if($this->getPRO()) : ?>
            <div class="w-col-sm-12">
                <div class="w-box mec-activation">
                    <div class="w-box-head">
                        <?php _e('MEC Activate', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <p><?php echo esc_html__('In order to use all plugin features and options, please enter your purchase code.', 'modern-events-calendar-lite'); ?></p>
                        <div class="box-mec-avtivation">
                            <?php 
                                $mec_options = get_option('mec_options');
                                $one_license = $five_license = $ten_license = $product_license = '';
                                if ( !empty($mec_options) && isset($mec_options['product_name']) ):
                                    if ( $mec_options['product_name'] == '1 License for MEC Plugin' )
                                    {
                                        $one_license = 'checked';
                                    } 
                                    elseif ( $mec_options['product_name'] == '5 License for MEC Plugin' )
                                    {
                                        $five_license = 'checked';
                                    }
                                    elseif ( $mec_options['product_name'] == '10 License for MEC Plugin' )
                                    {
                                        $ten_license = 'checked';
                                    }
                                    if ( $mec_options['product_name'] != '' )
                                    {
                                        $product_license = $mec_options['purchase_code'];
                                    }
                                endif;
                            ?>
                            <form id="MECActivation" action="#" method="post">
                                <div class="LicenseType">
                                    <input type="radio" id="OneLicense" name="MECLicense" value="1 License for MEC Plugin" class="<?php echo esc_html($one_license); ?>" />
                                    <label for="OneLicense"><span></span>1 License</label>
                                    <input type="radio" id="FiveLicense" value="5 License for MEC Plugin" name="MECLicense" class="<?php echo esc_html($five_license); ?>" />
                                    <label for="FiveLicense"><span></span>5 License</label>
                                    <input type="radio" id="TenLicense" value="10 License for MEC Plugin" name="MECLicense" class="<?php echo esc_html($ten_license); ?>" />
                                    <label for="TenLicense"><span></span>10 License</label>
                                </div>
                                <div class="LicenseField">
                                    <input type="password" placeholder="Put your purchase code here" name="MECPurchaseCode" value="<?php echo esc_html($product_license); ?>">
                                    <input type="submit">
                                    <?php
                                    $license_status = '';
                                    if(!empty($mec_options['purchase_code']) && !is_null($verify))
                                    {
                                        $license_status = 'PurchaseSuccess';
                                    } 
                                    elseif ( !empty($mec_options['purchase_code']) && is_null($verify) )
                                    {
                                        $license_status = 'PurchaseError';
                                    }
                                    ?>
                                    <div class="MECPurchaseStatus <?php echo esc_html($license_status); ?>"></div>
                                </div>
                                <div class="MECLicenseMessage"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(current_user_can('read')): ?>
            <div class="w-col-sm-3">
                <div class="w-box doc">
                    <div class="w-box-child mec-count-child">
                        <p><?php echo '<p class="mec_dash_count">'.$user_post_count.'</p> '.__('Events', 'modern-events-calendar-lite'); ?></p>
                    </div>
                </div>
            </div>
            <div class="w-col-sm-3">
                <div class="w-box doc">
                    <div class="w-box-child mec-count-child">
                        <p><?php echo '<p class="mec_dash_count">'.$user_post_count_c.'</p> '.__('Shortcodes', 'modern-events-calendar-lite'); ?></p>
                    </div>
                </div>
            </div>
            <div class="w-col-sm-3">
                <div class="w-box doc">
                    <div class="w-box-child mec-count-child">
                        <p><?php echo '<p class="mec_dash_count">'.$user_location_count_l.'</p> '.__('Locations', 'modern-events-calendar-lite'); ?></p>
                    </div>
                </div>
            </div>            
            <div class="w-col-sm-3">
                <div class="w-box doc">
                    <div class="w-box-child mec-count-child">
                        <p><?php echo '<p class="mec_dash_count">'.$user_organizer_count_l.'</p> '. __('Organizers', 'modern-events-calendar-lite'); ?></p>
                    </div>
                </div>
            </div>           
            <?php endif; ?>
        </div>
        <?php if($box_stats): ?>
        <div class="w-row">
            <div class="w-col-sm-<?php echo $booking_status ? 6 : 12; ?>">
                <div class="w-box upcoming-events">
                    <div class="w-box-head">
                        <?php _e('Upcoming Events', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <?php
                            $render = $this->getRender();
                            echo $render->skin('list', array
                            (
                                'sk-options'=>array('list'=>array
                                (
                                    'style'=>'minimal',
                                    'start_date_type'=>'today',
                                    'load_more_button'=>'0',
                                    'limit'=>'6',
                                    'month_divider'=>'0'
                                ))
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <?php if($booking_status): ?>
            <div class="w-col-sm-6">
                <div class="w-box gateways">
                    <div class="w-box-head">
                        <?php echo esc_html__('Popular Gateways', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <?php
                            $results = $db->select("SELECT COUNT(`meta_id`) AS count, `meta_value` AS gateway FROM `#__postmeta` WHERE `meta_key`='mec_gateway' GROUP BY `meta_value`", 'loadAssocList');

                            $labels = '';
                            $data = '';
                            $bg_colors = '';

                            foreach($results as $result)
                            {
                                if (!class_exists($result['gateway'])) {
                                    continue;
                                }

                                $gateway = new $result['gateway'];
                                $stats[] = array('label'=>$gateway->title(), 'count'=>$result['count']);

                                $labels .= '"'.$gateway->title().'",';
                                $data .= ((int) $result['count']).',';
                                $bg_colors .= "'".$gateway->color()."',";
                            }
                            echo '<canvas id="mec_gateways_chart" width="300" height="300"></canvas>';
                            echo '<script type="text/javascript">
                                jQuery(document).ready(function()
                                {
                                    var ctx = document.getElementById("mec_gateways_chart");
                                    var mecGatewaysChart = new Chart(ctx,
                                    {
                                        type: "doughnut",
                                        data:
                                        {
                                            labels: ['.trim($labels, ', ').'],
                                            datasets: [
                                            {
                                                data: ['.trim($data, ', ').'],
                                                backgroundColor: ['.trim($bg_colors, ', ').']
                                            }]
                                        }
                                    });
                                });
                            </script>';
                        ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if($booking_status): ?>
        <div class="w-row">
            <div class="w-col-sm-12">
                <div class="w-box total-bookings">
                    <div class="w-box-head">
                        <?php echo esc_html__('Total Bookings', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <?php
                            $start = isset($_GET['start']) ? sanitize_text_field($_GET['start']) : date('Y-m-d', strtotime('-15 days'));
                            $end = isset($_GET['end']) ? sanitize_text_field($_GET['end']) : date('Y-m-d');
                            $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'daily';
                            $chart = isset($_GET['chart']) ? sanitize_text_field($_GET['chart']) : 'bar';
                            
                            $periods = $this->get_date_periods($start, $end, $type);
                            
                            $stats = '';
                            $labels = '';
                            foreach($periods as $period)
                            {
                                $posts_ids = $db->select("SELECT `ID` FROM `#__posts` WHERE `post_type`='".$this->get_book_post_type()."' AND `post_date`>='".$period['start']."' AND `post_date`<='".$period['end']."'", 'loadColumn');
                                
                                if(count($posts_ids)) $total_sells = $db->select("SELECT SUM(`meta_value`) FROM `#__postmeta` WHERE `meta_key`='mec_price' AND `post_id` IN (".implode(',', $posts_ids).")", 'loadResult');
                                else $total_sells = 0;
                                
                                $labels .= '"'.$period['label'].'",';
                                $stats .= $total_sells.',';
                            }
                            
                            $currency = $this->get_currency_sign();
                        ?>
                        <ul>
                            <li><a href="?page=mec-intro&start=<?php echo date('Y-m-01'); ?>&end=<?php echo date('Y-m-t'); ?>&type=daily&chart=<?php echo $chart; ?>"><?php _e('This Month', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="?page=mec-intro&start=<?php echo date('Y-m-01', strtotime('-1 Month')); ?>&end=<?php echo date('Y-m-t', strtotime('-1 Month')); ?>&type=daily&chart=<?php echo $chart; ?>"><?php _e('Last Month', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="?page=mec-intro&start=<?php echo date('Y-01-01'); ?>&end=<?php echo date('Y-12-31'); ?>&type=monthly&chart=<?php echo $chart; ?>"><?php _e('This Year', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="?page=mec-intro&start=<?php echo date('Y-01-01', strtotime('-1 Year')); ?>&end=<?php echo date('Y-12-31', strtotime('-1 Year')); ?>&type=daily&chart=<?php echo $chart; ?>"><?php _e('Last Year', 'modern-events-calendar-lite'); ?></a></li>
                        </ul>
                        <form class="mec-sells-filter" method="GET" action="">
                            <input type="hidden" name="page" value="mec-intro" />
                            <input type="text" class="mec_date_picker" name="start" placeholder="<?php esc_attr_e('Start Date', 'modern-events-calendar-lite'); ?>" value="<?php echo $start; ?>" />
                            <input type="text" class="mec_date_picker" name="end" placeholder="<?php esc_attr_e('End Date', 'modern-events-calendar-lite'); ?>" value="<?php echo $end; ?>" />
                            <select name="type">
                                <option value="daily" <?php echo $type == 'daily' ? 'selected="selected"' : ''; ?>><?php _e('Daily', 'modern-events-calendar-lite'); ?></option>
                                <option value="monthly" <?php echo $type == 'monthly' ? 'selected="selected"' : ''; ?>><?php _e('Monthly', 'modern-events-calendar-lite'); ?></option>
                                <option value="yearly" <?php echo $type == 'yearly' ? 'selected="selected"' : ''; ?>><?php _e('Yearly', 'modern-events-calendar-lite'); ?></option>
                            </select>
                            <select name="chart">
                                <option value="bar" <?php echo $chart == 'bar' ? 'selected="selected"' : ''; ?>><?php _e('Bar', 'modern-events-calendar-lite'); ?></option>
                                <option value="line" <?php echo $chart == 'line' ? 'selected="selected"' : ''; ?>><?php _e('Line', 'modern-events-calendar-lite'); ?></option>
                            </select>
                            <button type="submit"><?php _e('Filter', 'modern-events-calendar-lite'); ?></button>
                        </form>
                        <?php
                            echo '<canvas id="mec_total_bookings_chart" width="600" height="300"></canvas>';
                            echo '<script type="text/javascript">
                                jQuery(document).ready(function()
                                {
                                    var ctx = document.getElementById("mec_total_bookings_chart");
                                    var mecSellsChart = new Chart(ctx,
                                    {
                                        type: "'.$chart.'",
                                        data:
                                        {
                                            labels: ['.trim($labels, ', ').'],
                                            datasets: [
                                            {
                                                label: "'.esc_js(sprintf(__('Total Sells (%s)', 'modern-events-calendar-lite'), $currency)).'",
                                                data: ['.trim($stats, ', ').'],
                                                backgroundColor: "rgba(159, 216, 255, 0.3)",
                                                borderColor: "#36A2EB",
                                                borderWidth: 1
                                            }]
                                        }
                                    });
                                });
                            </script>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="w-row">
            <div class="w-col-sm-12">
                <div class="w-box change-log">
                    <div class="w-box-head">
                        <?php echo esc_html__('Change Log', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <pre><?php echo file_get_contents(plugin_dir_path(__FILE__ ).'../../../changelog.txt'); ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>