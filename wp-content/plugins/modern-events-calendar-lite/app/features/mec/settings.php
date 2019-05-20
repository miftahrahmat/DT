<?php
/** no direct access **/
defined('MECEXEC') or die();

$settings = $this->main->get_settings();
$socials = $this->main->get_social_networks();
$archive_skins = $this->main->get_archive_skins();
$category_skins = $this->main->get_category_skins();

$fees = isset($settings['fees']) ? $settings['fees'] : array();
$ticket_variations = isset($settings['ticket_variations']) ? $settings['ticket_variations'] : array();
$currencies = $this->main->get_currencies();

// WordPress Pages
$pages = get_pages();

// Verify the Purchase Code
$verify = NULL;
if($this->getPRO())
{
    $envato = $this->getEnvato();
    $verify = $envato->get_MEC_info('dl');
}
?>
<div class="wns-be-container">
    <div id="wns-be-infobar">
        <input id="mec-search-settings" type="text" placeholder="Search..">
        <a id="" class="dpr-btn dpr-save-btn"><?php _e('Save Changes', 'modern-events-calendar-lite'); ?></a>
    </div>

    <div class="wns-be-sidebar">
        <ul class="wns-be-group-menu">
            <!-- <a  class="nav-tab nav-tab-active"></a> -->
            <li class="wns-be-group-menu-li has-sub active">

                <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" id="" class="wns-be-group-tab-link-a">
                    <span class="extra-icon">
                        <i class="sl-arrow-down"></i>
                    </span>
                    <i class="mec-sl-settings"></i> 
                    <span class="wns-be-group-menu-title"><?php echo __('Settings', 'modern-events-calendar-lite'); ?></span>
                </a>

                <ul id="" class="subsection" style="display: block;">

                    <li id="" class="pr-be-group-menu-li active">
                        <a data-id= "general_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('General Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "archive_options" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Archive Page Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "slug_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Slugs/Permalinks', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "event_options" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Event Details/Single Event Page', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>                                                           

                    <li id="" class="pr-be-group-menu-li">
                        <a id="" data-id= "currency_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Currency Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "speakers_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Speakers', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "googlemap_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Google Maps Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>                                

                    <li id="" class="pr-be-group-menu-li">
                        <a id="" data-id= "recaptcha_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Google Recaptcha Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "export_module_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Export Module Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "time_module_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Local Time Module', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "qrcode_module_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('QR Code Module', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                   <li id="" class="pr-be-group-menu-li">
                       <a data-id= "weather_module_option" class="wns-be-group-tab-link-a WnTabLinks">
                           <span class="pr-be-group-menu-title"><?php _e('Weather Module', 'modern-events-calendar-lite'); ?></span>
                       </a>
                   </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "countdown_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Countdown Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "social_options" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Social Networks', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "next_event_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Next Event Module', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "fes_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Frontend Event Submission', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "user_profile_options" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('User Profile', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "exceptional_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Exceptional Days', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                   <li id="" class="pr-be-group-menu-li">
                       <a data-id= "additional_organizers" class="wns-be-group-tab-link-a WnTabLinks">
                           <span class="pr-be-group-menu-title"><?php _e('Additional Organizers', 'modern-events-calendar-lite'); ?></span>
                       </a>
                   </li>

                   <li id="" class="pr-be-group-menu-li">
                       <a data-id= "additional_locations" class="wns-be-group-tab-link-a WnTabLinks">
                           <span class="pr-be-group-menu-title"><?php _e('Additional Locations', 'modern-events-calendar-lite'); ?></span>
                       </a>
                   </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "booking_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Booking', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "coupon_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Coupons', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "taxes_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Taxes / Fees', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "ticket_variations_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Ticket Variations & Options', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "buddy_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('BuddyPress Integration', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "mailchimp_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Mailchimp Integration', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                    <li id="" class="pr-be-group-menu-li">
                        <a data-id= "uploadfield_option" class="wns-be-group-tab-link-a WnTabLinks">
                            <span class="pr-be-group-menu-title"><?php _e('Upload Field', 'modern-events-calendar-lite'); ?></span>
                        </a>
                    </li>

                </ul>
            </li>

            <?php if($this->main->getPRO() and isset($this->settings['booking_status']) and $this->settings['booking_status']): ?>

                <li class="wns-be-group-menu-li">
                      <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-reg-form'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-layers"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Booking Form', 'modern-events-calendar-lite'); ?></span>
                    </a>
                </li>

                <li class="wns-be-group-menu-li">
                    <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-gateways'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-wallet"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Payment Gateways', 'modern-events-calendar-lite'); ?></span>
                    </a>
                </li>

            <?php endif;?>


            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-notifications'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-envelope"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Notifications', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-styling'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-equalizer"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Styling Options', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-customcss'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-wrench"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Custom CSS', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-messages'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-bubble"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Messages', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-ie'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-refresh"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Import / Export', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li>

            <!-- <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-support'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-support"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Support', 'modern-events-calendar-lite'); ?></span>
                </a>
            </li> -->

        </ul>
    </div>

    <div class="wns-be-main">
        <div id="wns-be-notification"></div>
        <div id="wns-be-content">
            <div class="wns-be-group-tab">
                <div class="mec-container">

                    <form id="mec_settings_form">

                        <div id="general_option" class="mec-options-fields active">

                            <h4 class="mec-form-subtitle"><?php _e('General Options', 'modern-events-calendar-lite'); ?></h4>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_hide_time_method"><?php _e('Hide Events', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_time_format" name="mec[settings][hide_time_method]">
                                        <option value="start" <?php if(isset($settings['hide_time_method']) and 'start' == $settings['hide_time_method']) echo 'selected="selected"'; ?>><?php _e('On Event Start', 'modern-events-calendar-lite'); ?></option>
                                        <option value="plus1" <?php if(isset($settings['hide_time_method']) and 'plus1' == $settings['hide_time_method']) echo 'selected="selected"'; ?>><?php _e('+1 Hour after start', 'modern-events-calendar-lite'); ?></option>
                                        <option value="plus2" <?php if(isset($settings['hide_time_method']) and 'plus2' == $settings['hide_time_method']) echo 'selected="selected"'; ?>><?php _e('+2 Hours after start', 'modern-events-calendar-lite'); ?></option>
                                        <option value="end" <?php if(isset($settings['hide_time_method']) and 'end' == $settings['hide_time_method']) echo 'selected="selected"'; ?>><?php _e('On Event End', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("This option is for showing start/end time of events on frontend of website.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">

                                <label class="mec-col-3" for="mec_settings_multiple_day_show_method"><?php _e('Multiple Day Events', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_multiple_day_show_method" name="mec[settings][multiple_day_show_method]">
                                        <option value="first_day_listgrid" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'first_day_listgrid') echo 'selected="selected"'; ?>><?php _e('Show only first day on List/Grid/Slider skins', 'modern-events-calendar-lite'); ?></option>
                                        <option value="first_day" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'first_day') echo 'selected="selected"'; ?>><?php _e('Show only first day on all skins', 'modern-events-calendar-lite'); ?></option>
                                        <option value="all_days" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'all_days') echo 'selected="selected"'; ?>><?php _e('Show all days', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("For showing all days of multiple day events on frontend or only show the first day.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>

                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_remove_data_on_uninstall"><?php _e('Remove MEC Data on Plugin Uninstall', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_remove_data_on_uninstall" name="mec[settings][remove_data_on_uninstall]">
                                        <option value="0" <?php if(isset($settings['remove_data_on_uninstall']) and !$settings['remove_data_on_uninstall']) echo 'selected="selected"'; ?>><?php _e('Disabled', 'modern-events-calendar-lite'); ?></option>
                                        <option value="1" <?php if(isset($settings['remove_data_on_uninstall']) and $settings['remove_data_on_uninstall'] == '1') echo 'selected="selected"'; ?>><?php _e('Enabled', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3"><?php _e('Exclude Date Suffix', 'modern-events-calendar-lite'); ?></label>
                                <label>
                                    <input type="hidden" name="mec[settings][date_suffix]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][date_suffix]" <?php if(isset($settings['date_suffix']) and $settings['date_suffix']) echo 'checked="checked"'; ?> /> <?php _e('Remove suffix from calendars', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>

                            <?php $weekdays = $this->main->get_weekday_i18n_labels(); ?>
                            <div class="mec-form-row">

                                <label class="mec-col-3" for="mec_settings_weekdays"><?php _e('Weekdays', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-8">
                                    <?php $mec_weekdays = $this->main->get_weekdays(); foreach($weekdays as $weekday): ?>
                                    <label for="mec_settings_weekdays_<?php echo $weekday[0]; ?>">
                                        <input type="checkbox" id="mec_settings_weekdays_<?php echo $weekday[0]; ?>" name="mec[settings][weekdays][]" value="<?php echo $weekday[0]; ?>" <?php echo (in_array($weekday[0], $mec_weekdays) ? 'checked="checked"' : ''); ?> />
                                        <?php echo $weekday[1]; ?>
                                    </label>
                                    <?php endforeach; ?>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Proceed with caution. Default is set to Monday, Tuesday, Wednesday, Thursday and Friday.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>

                            </div>

                            <div class="mec-form-row">

                                <label class="mec-col-3" for="mec_settings_weekends"><?php _e('Weekends', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-8">
                                    <?php $mec_weekends = $this->main->get_weekends(); foreach($weekdays as $weekday): ?>
                                    <label for="mec_settings_weekends_<?php echo $weekday[0]; ?>">
                                        <input type="checkbox" id="mec_settings_weekends_<?php echo $weekday[0]; ?>" name="mec[settings][weekends][]" value="<?php echo $weekday[0]; ?>" <?php echo (in_array($weekday[0], $mec_weekends) ? 'checked="checked"' : ''); ?> />
                                        <?php echo $weekday[1]; ?>
                                    </label>
                                    <?php endforeach; ?>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Proceed with caution. Default is set to Saturday and Sunday.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>

                            </div>

                        </div>

                        <div id="archive_options" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Archive Pages', 'modern-events-calendar-lite'); ?></h4>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_archive_title"><?php _e('Archive Page Title', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" id="mec_settings_archive_title" name="mec[settings][archive_title]" value="<?php echo ((isset($settings['archive_title']) and trim($settings['archive_title']) != '') ? $settings['archive_title'] : 'Events'); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value is Events", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_default_skin_archive"><?php _e('Archive Page Skin', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-8">
                                    <select id="mec_settings_default_skin_archive" name="mec[settings][default_skin_archive]" onchange="mec_archive_skin_style_changed(this.value);">
                                        <?php foreach($archive_skins as $archive_skin): ?>
                                            <option value="<?php echo $archive_skin['skin']; ?>" <?php if(isset($settings['default_skin_archive']) and $archive_skin['skin'] == $settings['default_skin_archive']) echo 'selected="selected"'; ?>><?php echo $archive_skin['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="mec-archive-skins mec-archive-custom-skins">
                                        <input type="text" placeholder="<?php esc_html_e('Put shortcode...', 'modern-events-calendar-lite'); ?>" id="mec_settings_custom_archive" name="mec[settings][custom_archive]" value='<?php echo ((isset($settings['custom_archive']) and trim($settings['custom_archive']) != '') ? $settings['custom_archive'] : ''); ?>' />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-full_calendar-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-yearly_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('Modern Style', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-monthly_view-skins">
                                        <select id="mec_settings_monthly_view_skin_archive" name="mec[settings][monthly_view_archive_skin]">
                                            <option value="classic" <?php if(isset($settings['monthly_view_archive_skin']) &&  $settings['monthly_view_archive_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['monthly_view_archive_skin']) &&  $settings['monthly_view_archive_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['monthly_view_archive_skin']) &&  $settings['monthly_view_archive_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="novel" <?php if(isset($settings['monthly_view_archive_skin']) &&  $settings['monthly_view_archive_skin'] == 'novel') echo 'selected="selected"'; ?>><?php echo esc_html__('Novel' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="simple" <?php if(isset($settings['monthly_view_archive_skin']) &&  $settings['monthly_view_archive_skin'] == 'simple') echo 'selected="selected"'; ?>><?php echo esc_html__('Simple' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-archive-skins mec-archive-weekly_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-daily_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-timetable-skins">
                                        <select id="mec_settings_timetable_skin_archive" name="mec[settings][timetable_archive_skin]">
                                            <option value="modern" <?php if(isset($settings['timetable_archive_skin']) &&  $settings['timetable_archive_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['timetable_archive_skin']) &&  $settings['timetable_archive_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-archive-skins mec-archive-masonry-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-list-skins">
                                        <select id="mec_settings_list_skin_archive" name="mec[settings][list_archive_skin]">
                                            <option value="classic" <?php if(isset($settings['list_archive_skin']) &&  $settings['list_archive_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="minimal" <?php if(isset($settings['list_archive_skin']) &&  $settings['list_archive_skin'] == 'minimal') echo 'selected="selected"'; ?>><?php echo esc_html__('Minimal' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['list_archive_skin']) &&  $settings['list_archive_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="standard" <?php if(isset($settings['list_archive_skin']) &&  $settings['list_archive_skin'] == 'standard') echo 'selected="selected"'; ?>><?php echo esc_html__('Standard' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="accordion" <?php if(isset($settings['list_archive_skin']) &&  $settings['list_archive_skin'] == 'accordion') echo 'selected="selected"'; ?>><?php echo esc_html__('Accordion' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-archive-skins mec-archive-grid-skins">
                                        <select id="mec_settings_grid_skin_archive" name="mec[settings][grid_archive_skin]">
                                            <option value="classic" <?php if(isset($settings['grid_archive_skin']) &&  $settings['grid_archive_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="minimal" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'minimal') echo 'selected="selected"'; ?>><?php echo esc_html__('Minimal' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="simple" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'simple') echo 'selected="selected"'; ?>><?php echo esc_html__('Simple' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="colorful" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'colorful') echo 'selected="selected"'; ?>><?php echo esc_html__('colorful' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="novel" <?php if(isset($settings['grid_archive_skin'])  &&  $settings['grid_archive_skin'] == 'novel') echo 'selected="selected"'; ?>><?php echo esc_html__('Novel' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-archive-skins mec-archive-agenda-skins">
                                        <input type="text" placeholder="<?php esc_html_e('Clean Style', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-archive-skins mec-archive-map-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value is Calendar/Monthly View", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_default_skin_category"><?php _e('Category Page Skin', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-8">
                                    <select id="mec_settings_default_skin_category" name="mec[settings][default_skin_category]" onchange="mec_category_skin_style_changed(this.value);">
                                        <?php foreach($category_skins as $category_skin): ?>
                                            <option value="<?php echo $category_skin['skin']; ?>" <?php if(isset($settings['default_skin_category']) and $category_skin['skin'] == $settings['default_skin_category']) echo 'selected="selected"'; if(!isset($settings['default_skin_category']) and $category_skin['skin'] == 'list') echo 'selected="selected"'; ?>><?php echo $category_skin['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="mec-category-skins mec-category-full_calendar-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-yearly_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('Modern Style', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-monthly_view-skins">
                                        <select id="mec_settings_monthly_view_skin_category" name="mec[settings][monthly_view_category_skin]">
                                            <option value="classic" <?php if(isset($settings['monthly_view_category_skin']) &&  $settings['monthly_view_category_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['monthly_view_category_skin']) &&  $settings['monthly_view_category_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['monthly_view_category_skin']) &&  $settings['monthly_view_category_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="novel" <?php if(isset($settings['monthly_view_category_skin']) &&  $settings['monthly_view_category_skin'] == 'novel') echo 'selected="selected"'; ?>><?php echo esc_html__('Novel' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="simple" <?php if(isset($settings['monthly_view_category_skin']) &&  $settings['monthly_view_category_skin'] == 'simple') echo 'selected="selected"'; ?>><?php echo esc_html__('Simple' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-category-skins mec-category-weekly_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-daily_view-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-timetable-skins">
                                        <select id="mec_settings_timetable_skin_category" name="mec[settings][timetable_category_skin]">
                                            <option value="modern" <?php if(isset($settings['timetable_category_skin']) &&  $settings['timetable_category_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['timetable_category_skin']) &&  $settings['timetable_category_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-category-skins mec-category-masonry-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-list-skins">
                                        <select id="mec_settings_list_skin_category" name="mec[settings][list_category_skin]">
                                            <option value="classic" <?php if(isset($settings['list_category_skin']) &&  $settings['list_category_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="minimal" <?php if(isset($settings['list_category_skin']) &&  $settings['list_category_skin'] == 'minimal') echo 'selected="selected"'; ?>><?php echo esc_html__('Minimal' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['list_category_skin']) &&  $settings['list_category_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="standard" <?php if(isset($settings['list_category_skin']) &&  $settings['list_category_skin'] == 'standard') echo 'selected="selected"'; ?>><?php echo esc_html__('Standard' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="accordion" <?php if(isset($settings['list_category_skin']) &&  $settings['list_category_skin'] == 'accordion') echo 'selected="selected"'; ?>><?php echo esc_html__('Accordion' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-category-skins mec-category-grid-skins">
                                        <select id="mec_settings_grid_skin_category" name="mec[settings][grid_category_skin]">
                                            <option value="classic" <?php if(isset($settings['grid_category_skin']) &&  $settings['grid_category_skin'] == 'classic') echo 'selected="selected"'; ?>><?php echo esc_html__('Classic' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="clean" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'clean') echo 'selected="selected"'; ?>><?php echo esc_html__('Clean' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="minimal" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'minimal') echo 'selected="selected"'; ?>><?php echo esc_html__('Minimal' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="modern" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'modern') echo 'selected="selected"'; ?>><?php echo esc_html__('Modern' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="simple" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'simple') echo 'selected="selected"'; ?>><?php echo esc_html__('Simple' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="colorful" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'colorful') echo 'selected="selected"'; ?>><?php echo esc_html__('colorful' , 'modern-events-calendar-lite'); ?></option>
                                            <option value="novel" <?php if(isset($settings['grid_category_skin'])  &&  $settings['grid_category_skin'] == 'novel') echo 'selected="selected"'; ?>><?php echo esc_html__('Novel' , 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </span>
                                    <span class="mec-category-skins mec-category-agenda-skins">
                                        <input type="text" placeholder="<?php esc_html_e('Clean Style', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <span class="mec-category-skins mec-category-map-skins">
                                        <input type="text" placeholder="<?php esc_html_e('There is no skins', 'modern-events-calendar-lite'); ?>" disabled />
                                    </span>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value is List View", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_category_events_method"><?php _e('Category Events Method', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_category_events_method" name="mec[settings][category_events_method]">
                                        <option value="1" <?php if(!isset($settings['category_events_method']) or (isset($settings['category_events_method']) and $settings['category_events_method'] == 1)) echo 'selected="selected"'; ?>><?php _e('Upcoming Events', 'modern-events-calendar-lite'); ?></option>
                                        <option value="2" <?php if(isset($settings['category_events_method']) and $settings['category_events_method'] == 2) echo 'selected="selected"'; ?>><?php _e('Expired Events', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value is Upcoming Events", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_archive_status"><?php _e('Events Archive Status', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_archive_status" name="mec[settings][archive_status]">
                                        <option value="1" <?php if(isset($settings['archive_status']) and $settings['archive_status'] == '1') echo 'selected="selected"'; ?>><?php _e('Enabled (Recommended)', 'modern-events-calendar-lite'); ?></option>
                                        <option value="0" <?php if(isset($settings['archive_status']) and !$settings['archive_status']) echo 'selected="selected"'; ?>><?php _e('Disabled', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("If you disable it, then you should create a page as archive page of MEC. Page's slug must equals to \"Main Slug\" of MEC. Also it will disable all of MEC rewrite rules.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                        </div>

                        <div id="slug_option" class="mec-options-fields">

                            <h4 class="mec-form-subtitle"><?php _e('Slugs/Permalinks', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_slug"><?php _e('Main Slug', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" id="mec_settings_slug" name="mec[settings][slug]" value="<?php echo ((isset($settings['slug']) and trim($settings['slug']) != '') ? $settings['slug'] : 'events'); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value is events. Valid characters are lowercase a-z, - character and numbers.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_category_slug"><?php _e('Category Slug', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" id="mec_settings_category_slug" name="mec[settings][category_slug]" value="<?php echo ((isset($settings['category_slug']) and trim($settings['category_slug']) != '') ? $settings['category_slug'] : 'mec-category'); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e("It's slug of MEC categories, you can change it to events-cat or something else. Default value is mec-category. Valid characters are lowercase a-z, - character and numbers.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                        </div>

                        <div id="event_options" class="mec-options-fields">

                            <h4 class="mec-form-subtitle"><?php _e('Event Details/Single Event Page', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_single_event_date_format1"><?php _e('Single Event Date Format', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" id="mec_settings_single_event_date_format1" name="mec[settings][single_date_format1]" value="<?php echo ((isset($settings['single_date_format1']) and trim($settings['single_date_format1']) != '') ? $settings['single_date_format1'] : 'M d Y'); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Default is M d Y', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_single_event_date_method"><?php _e('Date Method', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_single_event_date_method" name="mec[settings][single_date_method]">
                                        <option value="next" <?php echo (isset($settings['single_date_method']) and $settings['single_date_method'] == 'next') ? 'selected="selected"' : ''; ?>><?php _e('Next occurrence date', 'modern-events-calendar-lite'); ?></option>
                                        <option value="referred" <?php echo (isset($settings['single_date_method']) and $settings['single_date_method'] == 'referred') ? 'selected="selected"' : ''; ?>><?php _e('Referred date', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('"Referred date" shows the event date based on referred date in event list.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>                
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_single_event_single_style"><?php _e('Single Event Style', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_single_event_single_style" name="mec[settings][single_single_style]">
                                        <option value="default" <?php echo (isset($settings['single_single_style']) and $settings['single_single_style'] == 'default') ? 'selected="selected"' : ''; ?>><?php _e('Default Style', 'modern-events-calendar-lite'); ?></option>
                                        <option value="modern" <?php echo (isset($settings['single_single_style']) and $settings['single_single_style'] == 'modern') ? 'selected="selected"' : ''; ?>><?php _e('Modern Style', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Choose your single event style.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_single_event_booking_style"><?php _e('Booking Style', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_single_event_booking_style" name="mec[settings][single_booking_style]">
                                        <option value="default" <?php echo (isset($settings['single_booking_style']) and $settings['single_booking_style'] == 'default') ? 'selected="selected"' : ''; ?>><?php _e('Default', 'modern-events-calendar-lite'); ?></option>
                                        <option value="modal" <?php echo (isset($settings['single_booking_style']) and $settings['single_booking_style'] == 'modal') ? 'selected="selected"' : ''; ?>><?php _e('Modal', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Choose your Booking style.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="currency_option" class="mec-options-fields">

                            <h4 class="mec-form-subtitle"><?php _e('Currency Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_currency"><?php _e('Currency', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select name="mec[settings][currency]" id="mec_settings_currency" onchange="jQuery('#mec_settings_currency_symptom_container .mec-settings-currency-symptom-prev').html(this.value);">
                                        <?php foreach($currencies as $currency=>$currency_name): ?>
                                            <option value="<?php echo $currency; ?>" <?php echo ((isset($settings['currency']) and $settings['currency'] == $currency) ? 'selected="selected"' : ''); ?>><?php echo $currency_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_currency_symptom"><?php _e('Currency Sign', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" name="mec[settings][currency_symptom]" id="mec_settings_currency_symptom" value="<?php echo (isset($settings['currency_symptom']) ? $settings['currency_symptom'] : ''); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Default value will be \"currency\" if you leave it empty.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_currency_sign"><?php _e('Currency Position', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select name="mec[settings][currency_sign]" id="mec_settings_currency_sign">
                                        <option value="before" <?php echo ((isset($settings['currency_sign']) and $settings['currency_sign'] == 'before') ? 'selected="selected"' : ''); ?>><?php _e('Before $10', 'modern-events-calendar-lite'); ?></option>
                                        <option value="after" <?php echo ((isset($settings['currency_sign']) and $settings['currency_sign'] == 'after') ? 'selected="selected"' : ''); ?>><?php _e('After 10$', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_thousand_separator"><?php _e('Thousand Separator', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" name="mec[settings][thousand_separator]" id="mec_settings_thousand_separator" value="<?php echo (isset($settings['thousand_separator']) ? $settings['thousand_separator'] : ','); ?>" />
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_decimal_separator"><?php _e('Decimal Separator', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" name="mec[settings][decimal_separator]" id="mec_settings_decimal_separator" value="<?php echo (isset($settings['decimal_separator']) ? $settings['decimal_separator'] : '.'); ?>" />
                                </div>
                            </div>
                            <div class="mec-form-row">
                                <div class="mec-col-2">
                                    <label for="mec_settings_decimal_separator_status">
                                        <input type="hidden" name="mec[settings][decimal_separator_status]" value="1" />
                                        <input type="checkbox" name="mec[settings][decimal_separator_status]" id="mec_settings_decimal_separator_status" <?php echo ((isset($settings['decimal_separator_status']) and $settings['decimal_separator_status'] == '0') ? 'checked="checked"' : ''); ?> value="0" />
                                        <?php _e('No decimal', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div id="speakers_option" class="mec-options-fields">

                            <h4 class="mec-form-subtitle"><?php _e('Speakers Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <div class="mec-col-12">
                                    <label for="mec_settings_speakers_status">
                                        <input type="hidden" name="mec[settings][speakers_status]" value="0" />
                                        <input type="checkbox" name="mec[settings][speakers_status]" id="mec_settings_speakers_status" <?php echo ((isset($settings['speakers_status']) and $settings['speakers_status']) ? 'checked="checked"' : ''); ?> value="1" />
                                        <?php _e('Enable speakers feature', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div id="googlemap_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Google Maps Options', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][google_maps_status]" value="0" />
                                    <input onchange="jQuery('#mec_google_maps_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][google_maps_status]" <?php if(isset($settings['google_maps_status']) and $settings['google_maps_status']) echo 'checked="checked"'; ?> /> <?php _e('Show Google Maps on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_google_maps_container_toggle" class="<?php if((isset($settings['google_maps_status']) and !$settings['google_maps_status']) or !isset($settings['google_maps_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_google_maps_api_key"><?php _e('API Key', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_google_maps_api_key" name="mec[settings][google_maps_api_key]" value="<?php echo ((isset($settings['google_maps_api_key']) and trim($settings['google_maps_api_key']) != '') ? $settings['google_maps_api_key'] : ''); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3"><?php _e('Zoom level', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select name="mec[settings][google_maps_zoomlevel]">
                                            <?php for($i = 5; $i <= 21; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php if(isset($settings['google_maps_zoomlevel']) and $settings['google_maps_zoomlevel'] == $i) echo 'selected="selected"'; ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <a class="mec-tooltip" title="<?php esc_attr_e('For Google Maps module in single event page. In Google Maps skin, it will caculate the zoom level automatically based on event boundaries.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3"><?php _e('Google Maps Style', 'modern-events-calendar-lite'); ?></label>
                                    <?php $styles = $this->main->get_googlemap_styles(); ?>
                                    <div class="mec-col-4">
                                        <select name="mec[settings][google_maps_style]">
                                            <option value=""><?php _e('Default', 'modern-events-calendar-lite'); ?></option>
                                            <?php foreach($styles as $style): ?>
                                                <option value="<?php echo $style['key']; ?>" <?php if(isset($settings['google_maps_style']) and $settings['google_maps_style'] == $style['key']) echo 'selected="selected"'; ?>><?php echo $style['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3"><?php _e('Direction on single event', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select name="mec[settings][google_maps_get_direction_status]">
                                            <option value="0"><?php _e('Disabled', 'modern-events-calendar-lite'); ?></option>
                                            <option value="1" <?php if(isset($settings['google_maps_get_direction_status']) and $settings['google_maps_get_direction_status'] == 1) echo 'selected="selected"'; ?>><?php _e('Simple Method', 'modern-events-calendar-lite'); ?></option>
                                            <option value="2" <?php if(isset($settings['google_maps_get_direction_status']) and $settings['google_maps_get_direction_status'] == 2) echo 'selected="selected"'; ?>><?php _e('Advanced Method', 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_google_maps_date_format1"><?php _e('Lightbox Date Format', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_google_maps_date_format1" name="mec[settings][google_maps_date_format1]" value="<?php echo ((isset($settings['google_maps_date_format1']) and trim($settings['google_maps_date_format1']) != '') ? $settings['google_maps_date_format1'] : 'M d Y'); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e('Default value is M d Y', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3"><?php _e('Google Maps API', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <label>
                                            <input type="hidden" name="mec[settings][google_maps_dont_load_api]" value="0" />
                                            <input value="1" type="checkbox" name="mec[settings][google_maps_dont_load_api]" <?php if(isset($settings['google_maps_dont_load_api']) and $settings['google_maps_dont_load_api']) echo 'checked="checked"'; ?> /> <?php _e("Don't load Google Maps API library", 'modern-events-calendar-lite'); ?>
                                        </label>
                                        <a class="mec-tooltip" title="<?php esc_attr_e("Check it only if another plugin/theme is loading the Google Maps API", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div id="recaptcha_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Google Recaptcha Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][google_recaptcha_status]" value="0" />
                                    <input onchange="jQuery('#mec_google_recaptcha_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][google_recaptcha_status]" <?php if(isset($settings['google_recaptcha_status']) and $settings['google_recaptcha_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable Google Recaptcha', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_google_recaptcha_container_toggle" class="<?php if((isset($settings['google_recaptcha_status']) and !$settings['google_recaptcha_status']) or !isset($settings['google_recaptcha_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][google_recaptcha_booking]" value="0" />
                                        <input value="1" type="checkbox" name="mec[settings][google_recaptcha_booking]" <?php if(isset($settings['google_recaptcha_booking']) and $settings['google_recaptcha_booking']) echo 'checked="checked"'; ?> /> <?php _e('Enable on booking form', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][google_recaptcha_fes]" value="0" />
                                        <input value="1" type="checkbox" name="mec[settings][google_recaptcha_fes]" <?php if(isset($settings['google_recaptcha_fes']) and $settings['google_recaptcha_fes']) echo 'checked="checked"'; ?> /> <?php _e('Enable on "Frontend Event Submission" form', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_google_recaptcha_sitekey"><?php _e('Site Key', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_google_recaptcha_sitekey" name="mec[settings][google_recaptcha_sitekey]" value="<?php echo ((isset($settings['google_recaptcha_sitekey']) and trim($settings['google_recaptcha_sitekey']) != '') ? $settings['google_recaptcha_sitekey'] : ''); ?>" />
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_google_recaptcha_secretkey"><?php _e('Secret Key', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_google_recaptcha_secretkey" name="mec[settings][google_recaptcha_secretkey]" value="<?php echo ((isset($settings['google_recaptcha_secretkey']) and trim($settings['google_recaptcha_secretkey']) != '') ? $settings['google_recaptcha_secretkey'] : ''); ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="export_module_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Export Module Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][export_module_status]" value="0" />
                                    <input onchange="jQuery('#mec_export_module_options_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][export_module_status]" <?php if(isset($settings['export_module_status']) and $settings['export_module_status']) echo 'checked="checked"'; ?> /> <?php _e('Show export module (iCal export and add to Google calendars) on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_export_module_options_container_toggle" class="<?php if((isset($settings['export_module_status']) and !$settings['export_module_status']) or !isset($settings['export_module_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <ul id="mec_export_module_options" class="mec-form-row">
                                        <?php
                                        $event_options = array('googlecal'=>__('Google Calendar', 'modern-events-calendar-lite'), 'ical'=>__('iCal', 'modern-events-calendar-lite'));
                                        foreach($event_options as $event_key=>$event_option): ?>
                                        <li id="mec_sn_<?php echo esc_attr($event_key); ?>" data-id="<?php echo esc_attr($event_key); ?>" class="mec-form-row mec-switcher <?php echo ((isset($settings['sn'][$event_key]) and $settings['sn'][$event_key]) ? 'mec-enabled' : 'mec-disabled'); ?>">
                                            <label class="mec-col-3"><?php echo esc_html($event_option); ?></label>
                                            <div class="mec-col-2">
                                                <input class="mec-status" type="hidden" name="mec[settings][sn][<?php echo esc_attr($event_key); ?>]" value="<?php echo (isset($settings['sn'][$event_key]) ? $settings['sn'][$event_key] : '1'); ?>" />
                                                <label for="mec[settings][sn][<?php echo esc_attr($event_key); ?>]"></label>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="time_module_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Local Time Module', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][local_time_module_status]" value="0" />
                                    <input onchange="jQuery('#mec_local_time_module_options_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][local_time_module_status]" <?php if(isset($settings['local_time_module_status']) and $settings['local_time_module_status']) echo 'checked="checked"'; ?> /> <?php _e('Show event time based on local time of visitor on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_local_time_module_options_container_toggle" class="<?php if((isset($settings['local_time_module_status']) and !$settings['local_time_module_status']) or !isset($settings['local_time_module_status'])) echo 'mec-util-hidden'; ?>">
                            </div>
                        </div>

                        <div id="qrcode_module_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('QR Code Module', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][qrcode_module_status]" value="0" />
                                    <input onchange="jQuery('#mec_qrcode_module_options_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][qrcode_module_status]" <?php if(!isset($settings['qrcode_module_status']) or (isset($settings['qrcode_module_status']) and $settings['qrcode_module_status'])) echo 'checked="checked"'; ?> /> <?php _e('Show QR code of event in details page and booking invoice', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_qrcode_module_options_container_toggle" class="<?php if((isset($settings['qrcode_module_status']) and !$settings['qrcode_module_status']) or !isset($settings['qrcode_module_status'])) echo 'mec-util-hidden'; ?>">
                            </div>
                            <?php endif; ?>

                        </div>

                        <div id="weather_module_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Weather Module', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][weather_module_status]" value="0" />
                                    <input onchange="jQuery('#mec_weather_module_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][weather_module_status]" <?php if(isset($settings['weather_module_status']) and $settings['weather_module_status']) echo 'checked="checked"'; ?> /> <?php _e('Show weather module on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_weather_module_container_toggle" class="<?php if((isset($settings['weather_module_status']) and !$settings['weather_module_status']) or !isset($settings['weather_module_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_weather_module_api_key"><?php _e('API Key', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-8">
                                        <input type="text" name="mec[settings][weather_module_api_key]" id="mec_settings_weather_module_api_key" value="<?php echo ((isset($settings['weather_module_api_key']) and trim($settings['weather_module_api_key']) != '') ? $settings['weather_module_api_key'] : ''); ?>">
                                        <p><?php echo sprintf(__('You can get a free API Key from %s', 'modern-events-calendar-lite'), '<a target="_blank" href="https://darksky.net/dev/register">https://darksky.net/dev/register</a>'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div id="countdown_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Countdown Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][countdown_status]" value="0" />
                                    <input onchange="jQuery('#mec_count_down_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][countdown_status]" <?php if(isset($settings['countdown_status']) and $settings['countdown_status']) echo 'checked="checked"'; ?> /> <?php _e('Show countdown module on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_count_down_container_toggle" class="<?php if((isset($settings['countdown_status']) and !$settings['countdown_status']) or !isset($settings['countdown_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_countdown_list"><?php _e('Countdown Style', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select id="mec_settings_countdown_list" name="mec[settings][countdown_list]">
                                            <option value="default" <?php echo ((isset($settings['countdown_list']) and $settings['countdown_list'] == "default") ? 'selected="selected"' : ''); ?> ><?php _e('Plain Style', 'modern-events-calendar-lite'); ?></option>
                                            <option value="flip" <?php echo ((isset($settings['countdown_list']) and $settings['countdown_list'] == "flip") ? 'selected="selected"' : ''); ?> ><?php _e('Flip Style', 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="social_options" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Social Networks', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][social_network_status]" value="0" />
                                    <input onchange="jQuery('#mec_social_network_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][social_network_status]" <?php if(isset($settings['social_network_status']) and $settings['social_network_status']) echo 'checked="checked"'; ?> /> <?php _e('Show social network module', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_social_network_container_toggle" class="<?php if((isset($settings['social_network_status']) and !$settings['social_network_status']) or !isset($settings['social_network_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <ul id="mec_social_networks" class="mec-form-row">
                                        <?php foreach($socials as $social): ?>
                                            <li id="mec_sn_<?php echo esc_attr($social['id']); ?>" data-id="<?php echo esc_attr($social['id']); ?>" class="mec-form-row mec-switcher <?php echo ((isset($settings['sn'][$social['id']]) and $settings['sn'][$social['id']]) ? 'mec-enabled' : 'mec-disabled'); ?>">
                                                <label class="mec-col-3"><?php echo esc_html($social['name']); ?></label>
                                                <div class="mec-col-2">
                                                    <input class="mec-status" type="hidden" name="mec[settings][sn][<?php echo esc_attr($social['id']); ?>]" value="<?php echo (isset($settings['sn'][$social['id']]) ? $settings['sn'][$social['id']] : '1'); ?>" />
                                                    <label for="mec[settings][sn][<?php echo esc_attr($social['id']); ?>]"></label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="next_event_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Next Event Module', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][next_event_module_status]" value="0" />
                                    <input onchange="jQuery('#mec_next_previous_event_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][next_event_module_status]" <?php if(isset($settings['next_event_module_status']) and $settings['next_event_module_status']) echo 'checked="checked"'; ?> /> <?php _e('Show next event module on event page', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_next_previous_event_container_toggle" class="<?php if((isset($settings['next_event_module_status']) and !$settings['next_event_module_status']) or !isset($settings['next_event_module_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_next_event_module_method"><?php _e('Method', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select id="mec_settings_next_event_module_method" name="mec[settings][next_event_module_method]">
                                            <option value="occurrence" <?php echo ((isset($settings['next_event_module_method']) and $settings['next_event_module_method'] == 'occurrence') ? 'selected="selected"' : ''); ?>><?php _e('Next Occurrence of Current Event', 'modern-events-calendar-lite'); ?></option>
                                            <option value="event" <?php echo ((isset($settings['next_event_module_method']) and $settings['next_event_module_method'] == 'event') ? 'selected="selected"' : ''); ?>><?php _e('Next Occurrence of Other Events', 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_next_event_module_date_format1"><?php _e('Date Format', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_next_event_module_date_format1" name="mec[settings][next_event_module_date_format1]" value="<?php echo ((isset($settings['next_event_module_date_format1']) and trim($settings['next_event_module_date_format1']) != '') ? $settings['next_event_module_date_format1'] : 'M d Y'); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e('Default is M d Y', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="fes_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Frontend Event Submission', 'modern-events-calendar-lite'); ?></h4>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_time_format"><?php _e('Time Format', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_time_format" name="mec[settings][time_format]">
                                        <option value="12" <?php if(isset($settings['time_format']) and '12' == $settings['time_format']) echo 'selected="selected"'; ?>><?php _e('12 hours format with AM/PM', 'modern-events-calendar-lite'); ?></option>
                                        <option value="24" <?php if(isset($settings['time_format']) and '24' == $settings['time_format']) echo 'selected="selected"'; ?>><?php _e('24 hours format', 'modern-events-calendar-lite'); ?></option>
                                    </select>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("This option, affects the selection of Start/End time.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>

                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_fes_list_page"><?php _e('Events List Page', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_fes_list_page" name="mec[settings][fes_list_page]">
                                        <option value="">----</option>
                                        <?php foreach($pages as $page): ?>
                                            <option <?php echo ((isset($settings['fes_list_page']) and $settings['fes_list_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <p class="description"><?php echo sprintf(__('Put %s shortcode into the page.', 'modern-events-calendar-lite'), '<code>[MEC_fes_list]</code>'); ?></p>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_settings_fes_form_page"><?php _e('Add/Edit Events Page', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <select id="mec_settings_fes_form_page" name="mec[settings][fes_form_page]">
                                        <option value="">----</option>
                                        <?php foreach($pages as $page): ?>
                                            <option <?php echo ((isset($settings['fes_form_page']) and $settings['fes_form_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <p class="description"><?php echo sprintf(__('Put %s shortcode into the page.', 'modern-events-calendar-lite'), '<code>[MEC_fes_form]</code>'); ?></p>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_guest_status]" value="0" />
                                    <input onchange="jQuery('#mec_fes_guest_status_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][fes_guest_status]" <?php if(isset($settings['fes_guest_status']) and $settings['fes_guest_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable event submission by guest (Not logged-in) users', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_fes_guest_status_container_toggle" class="<?php if((isset($settings['fes_guest_status']) and !$settings['fes_guest_status']) or !isset($settings['fes_guest_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][fes_guest_name_email]" value="0" />
                                        <input value="1" type="checkbox" name="mec[settings][fes_guest_name_email]" <?php if(!isset($settings['fes_guest_name_email']) or (isset($settings['fes_guest_name_email']) and $settings['fes_guest_name_email'])) echo 'checked="checked"'; ?> /> <?php _e('Enable mandatory email and name for guest user', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                            </div>
                            <h4 class="mec-form-subtitle"><?php _e('Frontend Event Submission Sections', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_event_links]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_event_links]" <?php if(!isset($settings['fes_section_event_links']) or (isset($settings['fes_section_event_links']) and $settings['fes_section_event_links'])) echo 'checked="checked"'; ?> /> <?php _e('Event Links', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_cost]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_cost]" <?php if(!isset($settings['fes_section_cost']) or (isset($settings['fes_section_cost']) and $settings['fes_section_cost'])) echo 'checked="checked"'; ?> /> <?php echo $this->main->m('event_cost', __('Event Cost', 'modern-events-calendar-lite')); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_featured_image]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_featured_image]" <?php if(!isset($settings['fes_section_featured_image']) or (isset($settings['fes_section_featured_image']) and $settings['fes_section_featured_image'])) echo 'checked="checked"'; ?> /> <?php _e('Featured Image', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_categories]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_categories]" <?php if(!isset($settings['fes_section_categories']) or (isset($settings['fes_section_categories']) and $settings['fes_section_categories'])) echo 'checked="checked"'; ?> /> <?php _e('Event Categories', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_labels]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_labels]" <?php if(!isset($settings['fes_section_labels']) or (isset($settings['fes_section_labels']) and $settings['fes_section_labels'])) echo 'checked="checked"'; ?> /> <?php _e('Event Labels', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_event_color]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_event_color]" <?php if(!isset($settings['fes_section_event_color']) or (isset($settings['fes_section_event_color']) and $settings['fes_section_event_color'])) echo 'checked="checked"'; ?> /> <?php _e('Event Color', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_tags]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_tags]" <?php if(!isset($settings['fes_section_tags']) or (isset($settings['fes_section_tags']) and $settings['fes_section_tags'])) echo 'checked="checked"'; ?> /> <?php _e('Event Tags', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_location]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_location]" <?php if(!isset($settings['fes_section_location']) or (isset($settings['fes_section_location']) and $settings['fes_section_location'])) echo 'checked="checked"'; ?> /> <?php _e('Event Location', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_organizer]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_organizer]" <?php if(!isset($settings['fes_section_organizer']) or (isset($settings['fes_section_organizer']) and $settings['fes_section_organizer'])) echo 'checked="checked"'; ?> /> <?php _e('Event Organizer', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_speaker]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_speaker]" <?php if(isset($settings['fes_section_speaker']) and $settings['fes_section_speaker']) echo 'checked="checked"'; ?> /> <?php _e('Speakers', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_hourly_schedule]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_hourly_schedule]" <?php if(!isset($settings['fes_section_hourly_schedule']) or (isset($settings['fes_section_hourly_schedule']) and $settings['fes_section_hourly_schedule'])) echo 'checked="checked"'; ?> /> <?php _e('Hourly Schedule', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_booking]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_booking]" <?php if(!isset($settings['fes_section_booking']) or (isset($settings['fes_section_booking']) and $settings['fes_section_booking'])) echo 'checked="checked"'; ?> /> <?php _e('Booking Options', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_fees]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_fees]" <?php if(!isset($settings['fes_section_fees']) or (isset($settings['fes_section_fees']) and $settings['fes_section_fees'])) echo 'checked="checked"'; ?> /> <?php _e('Fees / Taxes Options', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_section_ticket_variations]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][fes_section_ticket_variations]" <?php if(!isset($settings['fes_section_ticket_variations']) or (isset($settings['fes_section_ticket_variations']) and $settings['fes_section_ticket_variations'])) echo 'checked="checked"'; ?> /> <?php _e('Ticket Variations / Options', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][fes_note]" value="0" />
                                    <input onchange="jQuery('#mec_fes_note_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][fes_note]" <?php if(isset($settings['fes_note']) and $settings['fes_note']) echo 'checked="checked"'; ?> /> <?php _e('Event Note', 'modern-events-calendar-lite'); ?>
                                </label>
                                <a class="mec-tooltip" title="<?php esc_attr_e("Users can put a note for editors while they're submitting the event. Also you can put %%event_note%% into the new event notification in order to get users' note in email.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                            </div>
                            <div id="mec_fes_note_container_toggle" class="<?php if((isset($settings['fes_note']) and !$settings['fes_note']) or !isset($settings['fes_note'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_fes_note_visibility"><?php _e('Visibility of Note', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select id="mec_settings_fes_note_visibility" name="mec[settings][fes_note_visibility]">
                                            <option <?php echo ((isset($settings['fes_note_visibility']) and $settings['fes_note_visibility'] == 'always') ? 'selected="selected"' : ''); ?> value="always"><?php _e('Always', 'modern-events-calendar-lite'); ?></option>
                                            <option <?php echo ((isset($settings['fes_note_visibility']) and $settings['fes_note_visibility'] == 'pending') ? 'selected="selected"' : ''); ?> value="pending"><?php _e('While event is not published', 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                    </div>
                                    <a class="mec-tooltip" title="<?php esc_attr_e("Event Note shows on Frontend Submission Form and Edit Event in backend.", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </div>
                            </div>
                        </div>

                        <div id="user_profile_options" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('User Profile', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <p><?php echo sprintf(__('Put %s shortcode into your desired page. Then users are able to see history of their bookings.', 'modern-events-calendar-lite'), '<code>[MEC_profile]</code>'); ?></p>
                            </div>
                        </div>

                        <div id="exceptional_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Exceptional days', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][exceptional_days]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][exceptional_days]" <?php if(isset($settings['exceptional_days']) and $settings['exceptional_days']) echo 'checked="checked"'; ?> /> <?php _e('Show exceptional days option on Add/Edit events page', 'modern-events-calendar-lite'); ?>
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Using this option you can include/exclude certain days to/from event occurrence dates.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </label>
                            </div>
                        </div>

                        <div id="additional_organizers" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Additional Organizers', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][additional_organizers]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][additional_organizers]" <?php if(!isset($settings['additional_organizers']) or (isset($settings['additional_organizers']) and $settings['additional_organizers'])) echo 'checked="checked"'; ?> /> <?php _e('Show additional organizers option on Add/Edit events page and single event page.', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                        </div>

                        <div id="additional_locations" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Additional locations', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][additional_locations]" value="0" />
                                    <input value="1" type="checkbox" name="mec[settings][additional_locations]" <?php if(!isset($settings['additional_locations']) or (isset($settings['additional_locations']) and $settings['additional_locations'])) echo 'checked="checked"'; ?> /> <?php _e('Show additional locations option on Add/Edit events page and single event page.', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                        </div>

                        <div id="booking_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Booking', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][booking_status]" value="0" />
                                    <input onchange="jQuery('#mec_booking_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][booking_status]" <?php if(isset($settings['booking_status']) and $settings['booking_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable booking module', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_booking_container_toggle" class="<?php if((isset($settings['booking_status']) and !$settings['booking_status']) or !isset($settings['booking_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_booking_date_format1"><?php _e('Date Format', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_booking_date_format1" name="mec[settings][booking_date_format1]" value="<?php echo ((isset($settings['booking_date_format1']) and trim($settings['booking_date_format1']) != '') ? $settings['booking_date_format1'] : 'Y-m-d'); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e('Default is Y-m-d', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_booking_maximum_dates"><?php _e('Maximum Dates', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="number" id="mec_settings_booking_maximum_dates" name="mec[settings][booking_maximum_dates]" value="<?php echo ((isset($settings['booking_maximum_dates']) and trim($settings['booking_maximum_dates']) != '') ? $settings['booking_maximum_dates'] : '6'); ?>" placeholder="<?php esc_attr_e('Default is 6', 'modern-events-calendar-lite'); ?>" min="1" />
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_booking_thankyou_page"><?php _e('Thank You Page', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select id="mec_settings_booking_thankyou_page" name="mec[settings][booking_thankyou_page]">
                                            <option value="">----</option>
                                            <?php foreach($pages as $page): ?>
                                                <option <?php echo ((isset($settings['booking_thankyou_page']) and $settings['booking_thankyou_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <a class="mec-tooltip" title="<?php esc_attr_e('User redirects to this page after booking. Leave it empty if you want to disable it.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <div class="mec-col-12">
                                        <label for="mec_settings_booking_first_for_all">
                                            <input type="hidden" name="mec[settings][booking_first_for_all]" value="0" />
                                            <input type="checkbox" name="mec[settings][booking_first_for_all]" id="mec_settings_booking_first_for_all" <?php echo ((!isset($settings['booking_first_for_all']) or (isset($settings['booking_first_for_all']) and $settings['booking_first_for_all'] == '1')) ? 'checked="checked"' : ''); ?> value="1" />
                                            <?php _e('Enable Express Attendees Form', 'modern-events-calendar-lite'); ?>
                                        </label>
                                        <a class="mec-tooltip" title="<?php esc_attr_e('Users are able to apply first attendee information for other attendees in the booking form.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <h5 class="mec-form-subtitle"><?php _e('Email verification', 'modern-events-calendar-lite'); ?></h5>
                                <div class="mec-form-row">
                                    <div class="mec-col-12">
                                        <label for="mec_settings_booking_auto_verify_free">
                                            <input type="hidden" name="mec[settings][booking_auto_verify_free]" value="0" />
                                            <input type="checkbox" name="mec[settings][booking_auto_verify_free]" id="mec_settings_booking_auto_verify_free" <?php echo ((isset($settings['booking_auto_verify_free']) and $settings['booking_auto_verify_free'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                            <?php _e('Auto verification for free bookings', 'modern-events-calendar-lite'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <div class="mec-col-12">
                                        <label for="mec_settings_booking_auto_verify_paid">
                                            <input type="hidden" name="mec[settings][booking_auto_verify_paid]" value="0" />
                                            <input type="checkbox" name="mec[settings][booking_auto_verify_paid]" id="mec_settings_booking_auto_verify_paid" <?php echo ((isset($settings['booking_auto_verify_paid']) and $settings['booking_auto_verify_paid'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                            <?php _e('Auto verification for paid bookings', 'modern-events-calendar-lite'); ?>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="mec-form-subtitle"><?php _e('Booking Confirmation', 'modern-events-calendar-lite'); ?></h5>
                                <div class="mec-form-row">
                                    <div class="mec-col-12">
                                        <label for="mec_settings_booking_auto_confirm_free">
                                            <input type="hidden" name="mec[settings][booking_auto_confirm_free]" value="0" />
                                            <input type="checkbox" name="mec[settings][booking_auto_confirm_free]" id="mec_settings_booking_auto_confirm_free" <?php echo ((isset($settings['booking_auto_confirm_free']) and $settings['booking_auto_confirm_free'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                            <?php _e('Auto confirmation for free bookings', 'modern-events-calendar-lite'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <div class="mec-col-12">
                                        <label for="mec_settings_booking_auto_confirm_paid">
                                            <input type="hidden" name="mec[settings][booking_auto_confirm_paid]" value="0" />
                                            <input type="checkbox" name="mec[settings][booking_auto_confirm_paid]" id="mec_settings_booking_auto_confirm_paid" <?php echo ((isset($settings['booking_auto_confirm_paid']) and $settings['booking_auto_confirm_paid'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                            <?php _e('Auto confirmation for paid bookings', 'modern-events-calendar-lite'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div id="coupon_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Coupons', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][coupons_status]" value="0" />
                                    <input onchange="jQuery('#mec_coupons_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][coupons_status]" <?php if(isset($settings['coupons_status']) and $settings['coupons_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable coupons module', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_coupons_container_toggle" class="<?php if((isset($settings['coupons_status']) and !$settings['coupons_status']) or !isset($settings['coupons_status'])) echo 'mec-util-hidden'; ?>">
                            </div>
                            <?php endif; ?>
                        </div>

                        <div id="taxes_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Taxes / Fees', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                            <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][taxes_fees_status]" value="0" />
                                    <input onchange="jQuery('#mec_taxes_fees_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][taxes_fees_status]" <?php if(isset($settings['taxes_fees_status']) and $settings['taxes_fees_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable taxes / fees module', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_taxes_fees_container_toggle" class="<?php if((isset($settings['taxes_fees_status']) and !$settings['taxes_fees_status']) or !isset($settings['taxes_fees_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <button class="button" type="button" id="mec_add_fee_button"><?php _e('Add Fee', 'modern-events-calendar-lite'); ?></button>
                                </div>
                                <div class="mec-form-row" id="mec_fees_list">
                                    <?php $i = 0; foreach($fees as $key=>$fee): if(!is_numeric($key)) continue; $i = max($i, $key); ?>
                                    <div class="mec-box" id="mec_fee_row<?php echo $i; ?>">
                                        <div class="mec-form-row">
                                            <input class="mec-col-12" type="text" name="mec[settings][fees][<?php echo $i; ?>][title]" placeholder="<?php esc_attr_e('Fee Title', 'modern-events-calendar-lite'); ?>" value="<?php echo (isset($fee['title']) ? $fee['title'] : ''); ?>" />
                                        </div>
                                        <div class="mec-form-row">
                                            <span class="mec-col-4">
                                                <input type="text" name="mec[settings][fees][<?php echo $i; ?>][amount]" placeholder="<?php esc_attr_e('Amount', 'modern-events-calendar-lite'); ?>" value="<?php echo (isset($fee['amount']) ? $fee['amount'] : ''); ?>" />
                                                <a class="mec-tooltip" title="<?php esc_attr_e('Fee amount, considered as fixed amount if you set the type to amount otherwise considered as percentage', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                            </span>
                                            <span class="mec-col-4">
                                                <select name="mec[settings][fees][<?php echo $i; ?>][type]">
                                                    <option value="percent" <?php echo ((isset($fee['type']) and $fee['type'] == 'percent') ? 'selected="selected"' : ''); ?>><?php _e('Percent', 'modern-events-calendar-lite'); ?></option>
                                                    <option value="amount" <?php echo ((isset($fee['type']) and $fee['type'] == 'amount') ? 'selected="selected"' : ''); ?>><?php _e('Amount (Per Ticket)', 'modern-events-calendar-lite'); ?></option>
                                                    <option value="amount_per_booking" <?php echo ((isset($fee['type']) and $fee['type'] == 'amount_per_booking') ? 'selected="selected"' : ''); ?>><?php _e('Amount (Per Booking)', 'modern-events-calendar-lite'); ?></option>
                                                </select>
                                            </span>
                                            <button class="button" type="button" id="mec_remove_fee_button<?php echo $i; ?>" onclick="mec_remove_fee(<?php echo $i; ?>);"><?php _e('Remove', 'modern-events-calendar-lite'); ?></button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="mec_new_fee_key" value="<?php echo $i+1; ?>" />
                            <div class="mec-util-hidden" id="mec_new_fee_raw">
                                <div class="mec-box" id="mec_fee_row:i:">
                                    <div class="mec-form-row">
                                        <input class="mec-col-12" type="text" name="mec[settings][fees][:i:][title]" placeholder="<?php esc_attr_e('Fee Title', 'modern-events-calendar-lite'); ?>" />
                                    </div>
                                    <div class="mec-form-row">
                                        <span class="mec-col-4">
                                            <input type="text" name="mec[settings][fees][:i:][amount]" placeholder="<?php esc_attr_e('Amount', 'modern-events-calendar-lite'); ?>" />
                                            <a class="mec-tooltip" title="<?php esc_attr_e('Fee amount, considered as fixed amount if you set the type to amount otherwise considered as percentage', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                        </span>
                                        <span class="mec-col-4">
                                            <select name="mec[settings][fees][:i:][type]">
                                                <option value="percent"><?php _e('Percent', 'modern-events-calendar-lite'); ?></option>
                                                <option value="amount"><?php _e('Amount (Per Ticket)', 'modern-events-calendar-lite'); ?></option>
                                                <option value="amount_per_booking"><?php _e('Amount (Per Booking)', 'modern-events-calendar-lite'); ?></option>
                                            </select>
                                        </span>
                                            <button class="button" type="button" id="mec_remove_fee_button:i:" onclick="mec_remove_fee(:i:);"><?php _e('Remove', 'modern-events-calendar-lite'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div id="ticket_variations_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Ticket Variations & Options', 'modern-events-calendar-lite'); ?></h4>

                            <?php if(!$this->main->getPRO()): ?>
                                <div class="info-msg"><?php echo sprintf(__("%s is required to use this feature.", 'modern-events-calendar-lite'), '<a href="'.$this->main->get_pro_link().'" target="_blank">'.__('Pro version of Modern Events Calendar', 'modern-events-calendar-lite').'</a>'); ?></div>
                            <?php else: ?>
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][ticket_variations_status]" value="0" />
                                        <input onchange="jQuery('#mec_ticket_variations_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][ticket_variations_status]" <?php if(isset($settings['ticket_variations_status']) and $settings['ticket_variations_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable ticket options module', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                                <div id="mec_ticket_variations_container_toggle" class="<?php if((isset($settings['ticket_variations_status']) and !$settings['ticket_variations_status']) or !isset($settings['ticket_variations_status'])) echo 'mec-util-hidden'; ?>">
                                    <div class="mec-form-row">
                                        <button class="button" type="button" id="mec_add_ticket_variation_button"><?php _e('Add Variation / Option', 'modern-events-calendar-lite'); ?></button>
                                    </div>
                                    <div class="mec-form-row" id="mec_ticket_variations_list">
                                        <?php $i = 0; foreach($ticket_variations as $key=>$ticket_variation): if(!is_numeric($key)) continue; $i = max($i, $key); ?>
                                            <div class="mec-box" id="mec_ticket_variation_row<?php echo $i; ?>">
                                                <div class="mec-form-row">
                                                    <input class="mec-col-12" type="text" name="mec[settings][ticket_variations][<?php echo $i; ?>][title]" placeholder="<?php esc_attr_e('Title', 'modern-events-calendar-lite'); ?>" value="<?php echo (isset($ticket_variation['title']) ? $ticket_variation['title'] : ''); ?>" />
                                                </div>
                                                <div class="mec-form-row">
                                                    <span class="mec-col-4">
                                                        <input type="text" name="mec[settings][ticket_variations][<?php echo $i; ?>][price]" placeholder="<?php esc_attr_e('Price', 'modern-events-calendar-lite'); ?>" value="<?php echo (isset($ticket_variation['price']) ? $ticket_variation['price'] : ''); ?>" />
                                                        <a class="mec-tooltip" title="<?php esc_attr_e('Option Price', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                                    </span>
                                                    <span class="mec-col-4">
                                                        <input type="number" min="0" name="mec[settings][ticket_variations][<?php echo $i; ?>][max]" placeholder="<?php esc_attr_e('Maximum Per Ticket', 'modern-events-calendar-lite'); ?>" value="<?php echo (isset($ticket_variation['max']) ? $ticket_variation['max'] : ''); ?>" />
                                                        <a class="mec-tooltip" title="<?php esc_attr_e('Maximum Per Ticket. Leave it blank for unlimited.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                                    </span>
                                                    <button class="button" type="button" id="mec_remove_ticket_variation_button<?php echo $i; ?>" onclick="mec_remove_ticket_variation(<?php echo $i; ?>);"><?php _e('Remove', 'modern-events-calendar-lite'); ?></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" id="mec_new_ticket_variation_key" value="<?php echo $i+1; ?>" />
                                    <div class="mec-util-hidden" id="mec_new_ticket_variation_raw">
                                        <div class="mec-box" id="mec_ticket_variation_row:i:">
                                            <div class="mec-form-row">
                                                <input class="mec-col-12" type="text" name="mec[settings][ticket_variations][:i:][title]" placeholder="<?php esc_attr_e('Title', 'modern-events-calendar-lite'); ?>" />
                                            </div>
                                            <div class="mec-form-row">
                                                <span class="mec-col-4">
                                                    <input type="text" name="mec[settings][ticket_variations][:i:][price]" placeholder="<?php esc_attr_e('Price', 'modern-events-calendar-lite'); ?>" />
                                                    <a class="mec-tooltip" title="<?php esc_attr_e('Option Price', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                                </span>
                                                <span class="mec-col-4">
                                                    <input type="number" min="0" name="mec[settings][ticket_variations][:i:][max]" placeholder="<?php esc_attr_e('Maximum Per Ticket', 'modern-events-calendar-lite'); ?>" value="1" />
                                                    <a class="mec-tooltip" title="<?php esc_attr_e('Maximum Per Ticket. Leave it blank for unlimited.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                                </span>
                                                <button class="button" type="button" id="mec_remove_ticket_variation_button:i:" onclick="mec_remove_ticket_variation(:i:);"><?php _e('Remove', 'modern-events-calendar-lite'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="buddy_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('BuddyPress Integration', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][bp_status]" value="0" />
                                    <input onchange="jQuery('#mec_bp_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][bp_status]" <?php if(isset($settings['bp_status']) and $settings['bp_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable BuddyPress Integration', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_bp_container_toggle" class="<?php if((isset($settings['bp_status']) and !$settings['bp_status']) or !isset($settings['bp_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][bp_attendees_module]" value="0" />
                                        <input value="1" type="checkbox" name="mec[settings][bp_attendees_module]" <?php if(isset($settings['bp_attendees_module']) and $settings['bp_attendees_module']) echo 'checked="checked"'; ?> /> <?php _e('Show "Attendees Module" in event details page', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_bp_attendees_module_limit"><?php _e('Attendees Limit', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_bp_attendees_module_limit" name="mec[settings][bp_attendees_module_limit]" value="<?php echo ((isset($settings['bp_attendees_module_limit']) and trim($settings['bp_attendees_module_limit']) != '') ? $settings['bp_attendees_module_limit'] : '20'); ?>" />
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label>
                                        <input type="hidden" name="mec[settings][bp_add_activity]" value="0" />
                                        <input value="1" type="checkbox" name="mec[settings][bp_add_activity]" <?php if(isset($settings['bp_add_activity']) and $settings['bp_add_activity']) echo 'checked="checked"'; ?> /> <?php _e('Add booking activity to user profile', 'modern-events-calendar-lite'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="mailchimp_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Mailchimp Integration', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label>
                                    <input type="hidden" name="mec[settings][mchimp_status]" value="0" />
                                    <input onchange="jQuery('#mec_mchimp_status_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][mchimp_status]" <?php if(isset($settings['mchimp_status']) and $settings['mchimp_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable Mailchimp Integration', 'modern-events-calendar-lite'); ?>
                                </label>
                            </div>
                            <div id="mec_mchimp_status_container_toggle" class="<?php if((isset($settings['mchimp_status']) and !$settings['mchimp_status']) or !isset($settings['mchimp_status'])) echo 'mec-util-hidden'; ?>">
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_mchimp_api_key"><?php _e('API Key', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_mchimp_api_key" name="mec[settings][mchimp_api_key]" value="<?php echo ((isset($settings['mchimp_api_key']) and trim($settings['mchimp_api_key']) != '') ? $settings['mchimp_api_key'] : ''); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_mchimp_list_id"><?php _e('List ID', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <input type="text" id="mec_settings_mchimp_list_id" name="mec[settings][mchimp_list_id]" value="<?php echo ((isset($settings['mchimp_list_id']) and trim($settings['mchimp_list_id']) != '') ? $settings['mchimp_list_id'] : ''); ?>" />
                                        <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                                <div class="mec-form-row">
                                    <label class="mec-col-3" for="mec_settings_mchimp_subscription_status"><?php _e('Subscription Status', 'modern-events-calendar-lite'); ?></label>
                                    <div class="mec-col-4">
                                        <select name="mec[settings][mchimp_subscription_status]" id="mec_settings_mchimp_subscription_status">
                                            <option value="subscribed" <?php if(isset($settings['mchimp_subscription_status']) and $settings['mchimp_subscription_status'] == 'subscribed') echo 'selected="selected"'; ?>><?php _e('Subscribe automatically', 'modern-events-calendar-lite'); ?></option>
                                            <option value="pending" <?php if(isset($settings['mchimp_subscription_status']) and $settings['mchimp_subscription_status'] == 'pending') echo 'selected="selected"'; ?>><?php _e('Subscribe by verification', 'modern-events-calendar-lite'); ?></option>
                                        </select>
                                        <a class="mec-tooltip" title="<?php esc_attr_e('If you choose "Subscribe by verification" then an email will send to user by mailchimp for subscription verification.', 'modern-events-calendar-lite'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="uploadfield_option" class="mec-options-fields">
                            <h4 class="mec-form-subtitle"><?php _e('Upload Field Options', 'modern-events-calendar-lite'); ?></h4>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_booking_form_upload_field_mime_types"><?php _e('Mime types', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="text" id="mec_booking_form_upload_field_mime_types" name="mec[settings][upload_field_mime_types]" placeholder="jpeg,jpg,png,pdf" value="<?php echo ((isset($settings['upload_field_mime_types']) and trim($settings['upload_field_mime_types']) != '') ? $settings['upload_field_mime_types'] : ''); ?>" />
                                </div>
                                <p class="description"><?php echo __('Split mime types with ",".', 'modern-events-calendar-lite'); ?> <br /> <?php esc_attr_e("Default: jpeg,jpg,png,pdf", 'modern-events-calendar-lite'); ?></p>
                            </div>
                            <div class="mec-form-row">
                                <label class="mec-col-3" for="mec_booking_form_upload_field_max_upload_size"><?php _e('Maximum file size', 'modern-events-calendar-lite'); ?></label>
                                <div class="mec-col-4">
                                    <input type="number" id="mec_booking_form_upload_field_max_upload_size" name="mec[settings][upload_field_max_upload_size]" value="<?php echo ((isset($settings['upload_field_max_upload_size']) and trim($settings['upload_field_max_upload_size']) != '') ? $settings['upload_field_max_upload_size'] : ''); ?>" />
                                </div>
                                <p class="description"><?php echo __('The unit is Megabyte "MB"', 'modern-events-calendar-lite'); ?></p>
                            </div>
                        </div>

                        <div class="mec-options-fields">
                            <?php wp_nonce_field('mec_options_form'); ?>
                            <button style="display: none;" id="mec_settings_form_button" class="button button-primary mec-button-primary" type="submit"><?php _e('Save Changes', 'modern-events-calendar-lite'); ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div id="wns-be-footer">
        <a id="" class="dpr-btn dpr-save-btn"><?php _e('Save Changes', 'modern-events-calendar-lite'); ?></a>
    </div>

</div>

<script type="text/javascript">
jQuery(document).ready(function()
{   
    jQuery('.WnTabLinks').each(function()
    {
        var ContentId = jQuery(this).attr('data-id');
         jQuery(this).click(function()
         {
            jQuery('.pr-be-group-menu-li').removeClass('active');
            jQuery(this).parent().addClass('active');
            jQuery(".mec-options-fields").hide();
            jQuery(".mec-options-fields").removeClass('active');
            jQuery("#"+ContentId+"").show();
            jQuery("#"+ContentId+"").addClass('active');
            jQuery('html, body').animate({
                scrollTop: jQuery("#"+ContentId+"").offset().top - 140
            }, 300);
        });
    });
   
    jQuery(".dpr-save-btn").on('click', function(event)
    {
        event.preventDefault();
        jQuery("#mec_settings_form_button").trigger('click');
    });    

    jQuery(".wns-be-sidebar .pr-be-group-menu-li").on('click', function(event)
    {
        jQuery(".wns-be-sidebar .pr-be-group-menu-li").removeClass('active');
        jQuery(this).addClass('active');
    });
});

var archive_value = jQuery('#mec_settings_default_skin_archive').val();
function mec_archive_skin_style_changed(archive_value)
{
    jQuery('.mec-archive-skins').hide();
    jQuery('.mec-archive-skins.mec-archive-'+archive_value+'-skins').show();
}
mec_archive_skin_style_changed(archive_value);

var category_value = jQuery('#mec_settings_default_skin_category').val();
function mec_category_skin_style_changed(category_value)
{
    jQuery('.mec-category-skins').hide();
    jQuery('.mec-category-skins.mec-category-'+category_value+'-skins').show();
}
mec_category_skin_style_changed(category_value);

jQuery("#mec_settings_form").on('submit', function(event)
{
    event.preventDefault();
    
    // Add loading Class to the button
    jQuery(".dpr-save-btn").addClass('loading').text("<?php echo esc_js(esc_attr__('Saved', 'modern-events-calendar-lite')); ?>");
    jQuery('<div class="wns-saved-settings"><?php echo esc_js(esc_attr__('Settings Saved!', 'modern-events-calendar-lite')); ?></div>').insertBefore('#wns-be-content');

    if(jQuery(".mec-purchase-verify").text() != '<?php echo esc_js(esc_attr__('Verified', 'modern-events-calendar-lite')); ?>')
    {
        jQuery(".mec-purchase-verify").text("<?php echo esc_js(esc_attr__('Checking ...', 'modern-events-calendar-lite')); ?>");
    } 
    
    var settings = jQuery("#mec_settings_form").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: ajaxurl,
        data: "action=mec_save_settings&"+settings,
        beforeSend: function () {
            jQuery('.wns-be-main').append('<div class="mec-loarder-wrap mec-settings-loader"><div class="mec-loarder"><div></div><div></div><div></div></div></div>');
        },
        success: function(data)
        {
            // Remove the loading Class to the button
            setTimeout(function()
            {
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'modern-events-calendar-lite')); ?>");
                jQuery('.wns-saved-settings').remove();
                jQuery('.mec-loarder-wrap').remove();
                if(jQuery(".mec-purchase-verify").text() != '<?php echo esc_js(esc_attr__('Verified', 'modern-events-calendar-lite')); ?>')
                {
                    jQuery(".mec-purchase-verify").text("<?php echo esc_js(esc_attr__('Please Refresh Page', 'modern-events-calendar-lite')); ?>");
                }
            }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            setTimeout(function()
            {
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'modern-events-calendar-lite')); ?>");
                jQuery('.wns-saved-settings').remove();
                jQuery('.mec-loarder-wrap').remove();
            }, 1000);
        }
    });
});
</script>