<?php
$version = NULL;
if($this->getPRO())
{
    // Get MEC New Update
    $envato = $this->getEnvato();

    $v = $envato->get_MEC_info('version');
    $version = isset($v->version) ? $v->version : NULL;
}
?>
<div id="webnus-dashboard" class="wrap about-wrap">
    <div class="welcome-head w-clearfix">
        <div class="w-row">
            <div class="w-col-sm-9">
                <h1> <?php echo __('Addons', 'modern-events-calendar-lite'); ?> </h1>
                <div class="w-welcome">
                    <!-- <div class="addons-page-links link-to-purchase"><a href="https://webnus.net/dox/modern-events-calendar/" target="_blank"><?php esc_html_e('How to Purchase' , 'modern-events-calendar-lite'); ?></a></div>
                    <div class="addons-page-links link-to-install-addons"><a href="https://webnus.net/dox/modern-events-calendar/video-tutorials/" target="_blank"><?php esc_html_e('Install Addons' , 'modern-events-calendar-lite'); ?></a></div> -->
                    <div class="addons-page-notice">
                        <p>
                        <?php echo __( '<strong>Note:</strong> All addons are provided for the Pro version as well, however, you cannot install and use them on the Lite version too.', 'modern-events-calendar-lite'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-col-sm-3">
                <img src="<?php echo plugin_dir_url(__FILE__ ) . '../../../assets/img/mec-logo-w.png'; ?>" />
                <span class="w-theme-version"><?php echo __('Version', 'modern-events-calendar-lite'); ?> <?php echo MEC_VERSION; ?></span>
            </div>
        </div>
    </div>
    <div class="welcome-content w-clearfix extra">
    <?php if(current_user_can('read')): ?>
        <div class="w-row">
            <div class="w-col-sm-3"><!-- Woocommerce -->
                <div class="w-box addon">
                    <div class="w-box-child mec-addon-box">
                        <div class="mec-addon-box-head">
                            <div class="mec-addon-box-title"><a href="#"><span><?php esc_html_e('WooCommerce Integration' , 'modern-events-calendar-lite'); ?></span></a></div>
                            <!-- <div class="mec-addon-box-version"><span><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></span></div> -->
                        </div>
                        <div class="mec-addon-box-body">
                            <div class="mec-addon-box-content">
                                <p><?php esc_html_e('You can use WooCommerce cart to purchase tickets, it means that each ticket is defined as a product. You can purchase ticket and WooCommerce products at the same time.' , 'modern-events-calendar-lite'); ?></p>
                            </div>
                        </div>
                        <div class="mec-addon-box-footer">
                            <!-- <a class="mec-addon-box-purchase" href="#"><i class="mec-sl-basket-loaded"></i><span>Purchase</span></a>
                            <a class="mec-addon-box-intro" href="#" data-lity=""><i class="mec-sl-control-play"></i>Introduction</a> -->
                            <div class="mec-addon-box-comingsoon" href="#" data-lity=""><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="w-col-sm-3"><!-- Shortcode Builder -->
                <div class="w-box addon">
                    <div class="w-box-child mec-addon-box">
                        <div class="mec-addon-box-head">
                            <div class="mec-addon-box-title"><a href="#"><span><?php esc_html_e('Elementor Shortcode Builder' , 'modern-events-calendar-lite'); ?></span></a></div>
                            <!-- <div class="mec-addon-box-version"><span><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></span></div> -->
                        </div>
                        <div class="mec-addon-box-body">
                            <div class="mec-addon-box-content">
                                <p><?php esc_html_e('It enables you to create shortcodes in Elementor Live Editor. Adding this widget to your pages allows previewing the events and placing the shortcodes in pages with ease.' , 'modern-events-calendar-lite'); ?></p>
                            </div>
                        </div>
                        <div class="mec-addon-box-footer">
                            <!-- <a class="mec-addon-box-purchase" href="#"><i class="mec-sl-basket-loaded"></i><span>Purchase</span></a>
                            <a class="mec-addon-box-intro" href="#" data-lity=""><i class="mec-sl-control-play"></i>Introduction</a> -->
                            <div class="mec-addon-box-comingsoon" href="#" data-lity=""><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-col-sm-3"><!-- Form Builder -->
                <div class="w-box addon">
                    <div class="w-box-child mec-addon-box">
                        <div class="mec-addon-box-head">
                            <div class="mec-addon-box-title"><a href="#"><span><?php esc_html_e('Elementor Form Builder' , 'modern-events-calendar-lite'); ?></span></a></div>
                            <!-- <div class="mec-addon-box-version"><span><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></span></div> -->
                        </div>
                        <div class="mec-addon-box-body">
                            <div class="mec-addon-box-content">
                                <p><?php esc_html_e('Use this Add-on to build your form in Elementor Editor. It allows you to use many different type of fields and rearrange them by drag and drop and modify their styles.' , 'modern-events-calendar-lite'); ?></p>
                            </div>
                        </div>
                        <div class="mec-addon-box-footer">
                            <!-- <a class="mec-addon-box-purchase" href="#"><i class="mec-sl-basket-loaded"></i><span>Purchase</span></a>
                            <a class="mec-addon-box-intro" href="#" data-lity=""><i class="mec-sl-control-play"></i>Introduction</a> -->
                            <div class="mec-addon-box-comingsoon" href="#" data-lity=""><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-col-sm-3"><!-- Single Builder -->
                <div class="w-box addon">
                    <div class="w-box-child mec-addon-box">
                        <div class="mec-addon-box-head">
                            <div class="mec-addon-box-title"><a href="#"><span><?php esc_html_e('Elementor Single Builder' , 'modern-events-calendar-lite'); ?></span></a></div>
                            <!-- <div class="mec-addon-box-version"><span><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></span></div> -->
                        </div>
                        <div class="mec-addon-box-body">
                            <div class="mec-addon-box-content">
                                <p><?php esc_html_e('It provides you with the ability to edit single event page using Elementor. Manage the position of all elements in the Single page and in desktops, mobiles and tablets as well.' , 'modern-events-calendar-lite'); ?></p>
                            </div>
                        </div>
                        <div class="mec-addon-box-footer">
                            <!-- <a class="mec-addon-box-purchase" href="#"><i class="mec-sl-basket-loaded"></i><span>Purchase</span></a>
                            <a class="mec-addon-box-intro" href="#" data-lity=""><i class="mec-sl-control-play"></i>Introduction</a> -->
                            <div class="mec-addon-box-comingsoon" href="#" data-lity=""><?php esc_html_e('Coming Soon' , 'modern-events-calendar-lite'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>