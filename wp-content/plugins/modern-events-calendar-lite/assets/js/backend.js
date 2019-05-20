jQuery(document).ready(function($)
{
    // Check validation of grid skin event count
    $('#mec_skin_grid_count').keyup(function()
    {
        var valid = false;
        if($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == '4' || $(this).val() == '6' || $(this).val() == '12')
        {
            valid = true;
        };
        
        if(valid === false)
        {
            $(this).addClass('bootstrap_unvalid');
            $('.mec-tooltiptext').css('visibility','visible');
        }
        else
        {
            $(this).removeClass('bootstrap_unvalid');
            $('.mec-tooltiptext').css('visibility', 'hidden');
        };
    });

    // MEC Accordion
    $('.mec-accordion li').on('click', function()
    {
        var key = $(this).data('key');
        var status = $(this).data('status');

        // Open the accordion
        if(status === 'close')
        {
            $(this).parent().find('ul').hide();

            $('#mec-acc-'+key).show();
            $(this).data('status', 'open');
        }
        // Close the opened accordion
        else
        {
            $('#mec-acc-'+key).hide();
            $(this).data('status', 'close');
        }
    });

    // MEC Select, Deselect, Toggle
    $(".mec-select-deselect-actions li").on('click', function()
    {
        var target = $(this).parent().data('for');
        var action = $(this).data('action');
        
        if(action === 'select-all')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = true;
            });
        }
        else if(action === 'deselect-all')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = false;
            });
        }
        else if(action === 'toggle')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = !this.checked;
            });
        }
    });

    // MEC image popup switcher
    if ($('.mec-sed-method-wrap').length > 0)
    {
        $('.mec-sed-method-wrap').each(function() {
            var sed_value = $(this).find('[id*="_sed_method_field"]').val();
            if (sed_value == 'm1') {
                $(this).siblings('.mec-image-popup-wrap').show();
            }
        });
    }
    
    // MEC Single Event Display Method Switcher
    $(".mec-sed-methods li").on('click', function()
    {
        var target = $(this).parent().data('for');
        var method = $(this).data('method');
        
        // Set the Method
        $(target).val(method);
        
        // Set the active method
        $(this).parent().find('li').removeClass('active');
        $(this).addClass('active');

        // Display Image popup section
        if ( method == 'm1' ) {
            $('.mec-image-popup-wrap').show();
        } else {
            $('.mec-image-popup-wrap').hide();
        }
    });
    
    // Initialize WP Color Picker
    $('.mec-color-picker').wpColorPicker();
    
    // Initialize MEC Skin Switcher
    $('#mec_skin').on('change', function()
    {
        mec_skin_toggle();
    });
    
    mec_skin_toggle();
    
    $('.mec-switcher').on('click', 'label[for*="mec[settings]"]', function(event)
    {
        var id = $(this).closest('.mec-switcher').data('id');
        var status = $('#mec_sn_'+id+' .mec-status').val();

        if(status === '1')
        {
            $('#mec_sn_'+id+' .mec-status').val(0);
            $('#mec_sn_'+id).removeClass('mec-enabled').addClass('mec-disabled');
        }
        else
        {
            $('#mec_sn_'+id+' .mec-status').val(1);
            $('#mec_sn_'+id).removeClass('mec-disabled').addClass('mec-enabled');
        }

    });
    
    // MEC Checkbox Toggle (Used in Date Filter Options)
    $('.mec-checkbox-toggle').on('change', function()
    {
        var id = $(this).attr('id');
        $(".mec-checkbox-toggle:not(#"+id+")").attr('checked', false);
    });

    // MEC Setting Sticky
    if ($('.wns-be-container').length > 0)
    {
        var stickyNav = function () {
            var stickyNavTop = $('.wns-be-container').offset().top;
            var scrollTop = $(window).scrollTop();
            var width = $('.wns-be-container').width();
            if (scrollTop > stickyNavTop) {
                $('#wns-be-infobar').addClass('sticky');
                $('#wns-be-infobar').css({
                    'width' : width,
                });
            } else {
                $('#wns-be-infobar').removeClass('sticky');
            }
        };
        stickyNav();
        $(window).scroll(function () {
            stickyNav();
        });

        $("#mec-search-settings").typeWatch({
            wait: 400, // 750ms
            callback: function (value) {
                var elements = [];
                if (!value || value == "") {
                    //console.log('value');
                    $('.mec-options-fields').hide();
                    $('.mec-options-fields').removeClass('active');
                    $('#general_option.mec-options-fields').show();
                    $('#general_option.mec-options-fields').addClass('active');
                    $('.pr-be-group-menu-li').removeClass('active');
                    $('.wns-be-group-menu-li .subsection .pr-be-group-menu-li:first').addClass('active');
                } else {
                    $("#mec_settings_form .mec-options-fields").filter(function () {
                        var search_label = $(this).find('label.mec-col-3').text().toLowerCase();
                        var search_title = $(this).find('h4.mec-form-subtitle').text().toLowerCase();
                        if ((!search_label || search_label == "") && (!search_title || search_title == "")) {
                            return false;
                        }
                        if ($(this).find('label.mec-col-3').text().toLowerCase().indexOf(value) > -1 || $(this).find('h4.mec-form-subtitle').text().toLowerCase().indexOf(value) > -1) {
                            $('.mec-options-fields').hide();
                            $('.mec-options-fields').removeClass('active');
                            elements.push($(this));
                        }
                    });

                    $.each(elements, function (i, searchStr) {
                        searchStr.show();
                        searchStr.addClass('active')
                    });
                }

            }
        });
    }

    

    // Import Settings
    function CheckJSON(text) {
        if (typeof text != 'string')
            text = JSON.stringify(text);
        try {
            JSON.parse(text);
            return true;
        } catch (e) {
            return false;
        }
    }
    $('.mec-import-settings').on('click', function (e) {
        e.preventDefault();
        var value = $(this).parent().find('.mec-import-settings-content').val();
        if ( CheckJSON(value) || value == '' ) {
            value = jQuery.parseJSON($(this).parent().find('.mec-import-settings-content').val());
        } else {
            value = 'No-JSON';
        }
        $.ajax({
            url: mec_admin_localize.ajax_url,
            type: 'POST',
            data: {
                action: 'import_settings',
                nonce: mec_admin_localize.ajax_nonce,
                content: value,
            },
            beforeSend: function () {
                $('.mec-import-settings-wrap').append('<div class="mec-loarder-wrap"><div class="mec-loarder"><div></div><div></div><div></div></div></div>');
                $('.mec-import-options-notification').find('.mec-message-import-error').remove()
                $('.mec-import-options-notification').find('.mec-message-import-success').remove()
            },
            success: function (response) {
                $('.mec-import-options-notification').append(response);
                $('.mec-loarder-wrap').remove();
                $('.mec-import-settings-content').val('');
            },
        });
    });

    /* MEC activation */
    if ($('#MECActivation').length > 0)
    {
        var LicenseType = $('#MECActivation input.checked[type=radio][name=MECLicense]').val();
        $('#MECActivation input[type=radio][name=MECLicense]').change(function () {
            $('#MECActivation').find('input').removeClass('checked');
            $(this).addClass('checked');
            LicenseType = $(this).val();
        });
        
        $('#MECActivation input[type=submit]').on('click', function(e){
            e.preventDefault();
            $('.wna-spinner-wrap').remove();
            $('#MECActivation').find('.MECLicenseMessage').text(' ');
            $('#MECActivation').find('.MECPurchaseStatus').removeClass('PurchaseError');
            $('#MECActivation').find('.MECPurchaseStatus').removeClass('PurchaseSuccess');
            var PurchaseCode = $('#MECActivation input[type=password][name=MECPurchaseCode]').val();
            var information = { LicenseTypeJson: LicenseType, PurchaseCodeJson: PurchaseCode };
            $.ajax({
                url: mec_admin_localize.ajax_url,
                type: 'POST',
                data: {
                    action: 'activate_license',
                    nonce: mec_admin_localize.ajax_nonce,
                    content: information,
                },
                beforeSend: function () {
                    $('.LicenseField').append('<div class="wna-spinner-wrap"><div class="wna-spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div>');
                },
                success: function (response) {
                    if (response == 'success')
                    {
                        $('.wna-spinner-wrap').remove();
                        $('#MECActivation').find('.MECPurchaseStatus').addClass('PurchaseSuccess');
                    }
                    else
                    {
                        $('.wna-spinner-wrap').remove();
                        $('#MECActivation').find('.MECPurchaseStatus').addClass('PurchaseError');
                        $('#MECActivation').find('.MECLicenseMessage').append(response);
                    }
                },
            });
        });
    }
});

function mec_skin_toggle()
{
    var skin = jQuery('#mec_skin').val();
    
    jQuery('.mec-skin-options-container').hide();
    jQuery('#mec_'+skin+'_skin_options_container').show();
    
    jQuery('.mec-search-form-options-container').hide();
    jQuery('#mec_'+skin+'_search_form_options_container').show();

    // Show/Hide Filter Options
    if(skin === 'countdown' || skin === 'cover' || skin === 'available_spot')
    {
        jQuery('#mec_meta_box_calendar_filter').hide();
        jQuery('#mec_meta_box_calendar_no_filter').show();
    }
    else
    {
        jQuery('#mec_meta_box_calendar_no_filter').hide();
        jQuery('#mec_meta_box_calendar_filter').show();
    }

    // Show/Hide Search Widget Options
    if(skin === 'countdown' || skin === 'cover' || skin === 'available_spot' || skin === 'masonry' || skin === 'carousel' || skin === 'slider')
    {
        jQuery('#mec_calendar_search_form').hide();
    }
    else
    {
        jQuery('#mec_calendar_search_form').show();
    }
    
    // Show/Hide Ongoing Events
    if(skin === 'list' || skin === 'grid') jQuery('#mec_date_ongoing_filter').show();
    else
    {
        jQuery("#mec_show_only_ongoing_events").attr('checked', false);
        jQuery('#mec_date_ongoing_filter').hide();
    }

    // Show/Hide Expired Events
    if(skin === 'map')
    {
        jQuery("#mec_show_only_past_events").attr('checked', false);
        jQuery('#mec_date_only_past_filter').hide();
    }
    else jQuery('#mec_date_only_past_filter').show();
    
    // Trigger change event of skin style in order to show/hide related fields
    jQuery('#mec_skin_'+skin+'_style').trigger('change');
}

function mec_skin_style_changed(skin, style)
{
    jQuery('.mec-skin-'+skin+'-date-format-container').hide();
    jQuery('#mec_skin_'+skin+'_date_format_'+style+'_container').show();
}