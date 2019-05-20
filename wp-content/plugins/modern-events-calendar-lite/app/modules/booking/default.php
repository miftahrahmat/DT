<?php
/** no direct access **/
defined('MECEXEC') or die();

// PRO Version is required
if(!$this->getPRO()) return;

// MEC Settings
$settings = $this->get_settings();

// Booking module is disabled
if(!isset($settings['booking_status']) or (isset($settings['booking_status']) and !$settings['booking_status'])) return;

$event = $event[0];
$uniqueid = (isset($uniqueid) ? $uniqueid : $event->data->ID);

$tickets = isset($event->data->tickets) ? $event->data->tickets : array();
$dates = isset($event->dates) ? $event->dates : $event->date;

// No Dates
if(!count($dates)) return;

// No Tickets
if(!count($tickets)) return;

// Generate JavaScript code of Booking Module
$javascript = '<script type="text/javascript">
jQuery("#mec_book_form'.$uniqueid.'").on("submit", function(event)
{
    event.preventDefault();
    mec_book_form_submit'.$uniqueid.'();
});

var mec_tickets_availability_ajax'.$uniqueid.' = false;
function mec_get_tickets_availability'.$uniqueid.'(event_id, date)
{
    // Add loading Class to the ticket list
    jQuery(".mec-event-tickets-list").addClass("loading");
    jQuery(".mec-event-tickets-list input").prop("disabled", true);
    
    // Abort previous request
    if(mec_tickets_availability_ajax'.$uniqueid.') mec_tickets_availability_ajax'.$uniqueid.'.abort();
    
    mec_tickets_availability_ajax'.$uniqueid.' = jQuery.ajax(
    {
        type: "GET",
        url: "'.admin_url('admin-ajax.php', NULL).'",
        data: "action=mec_tickets_availability&event_id="+event_id+"&date="+date,
        dataType: "JSON",
        success: function(data)
        {
            // Remove the loading Class to the ticket list
            jQuery("#mec_booking'.$uniqueid.' .mec-event-tickets-list").removeClass("loading");
            jQuery("#mec_booking'.$uniqueid.' .mec-event-tickets-list input").prop("disabled", false);

            // Set Total Booking Limit
            if(typeof data.availability.total != "undefined") jQuery("#mec_booking'.$uniqueid.' #mec_book_form_tickets_container'.$uniqueid.'").data("total-booking-limit", data.availability.total);
            
            for(ticket_id in data.availability)
            {
                var limit = data.availability[ticket_id];
                
                jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id).addClass(".mec-event-ticket"+limit);
                
                // There are some available spots
                if(limit != "0")
                {
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-ticket-available-spots").removeClass("mec-util-hidden");
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-ticket-unavailable-spots").addClass("mec-util-hidden");
                }
                // All spots are sold.
                else
                {
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-ticket-available-spots").addClass("mec-util-hidden");
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-ticket-unavailable-spots").removeClass("mec-util-hidden");
                }
                
                if(limit == "-1")
                {
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").attr("max", "");
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-event-ticket-available span").html("'.esc_html__("Unlimited", 'modern-events-calendar-lite').'");
                }
                else
                {
                    var cur_count = jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").val();
                    if(cur_count > limit) jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").val(limit);
                    
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").attr("max", limit);
                    jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-event-ticket-available span").html(limit);
                }
            }
            
            for(ticket_id in data.prices)
            {
                var price_label = data.prices[ticket_id];
                
                jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-event-ticket-price").html(price_label);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the ticket list
            jQuery("#mec_booking'.$uniqueid.' .mec-event-tickets-list").removeClass("loading");
        }
    });
}

function mec_check_tickets_availability'.$uniqueid.'(ticket_id, count)
{
    var total = jQuery("#mec_book_form_tickets_container'.$uniqueid.'").data("total-booking-limit");
    var max = jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").attr("max");
    
    var sum = 0;
    jQuery("#mec_booking'.$uniqueid.' .mec-book-ticket-limit").each(function()
    {
        sum += parseInt(jQuery(this).val(), 10);
    });
    
    if(total != "-1" && max > (total - (sum - count))) max = (total - (sum - count));
    
    if(parseInt(count) > parseInt(max)) jQuery("#mec_booking'.$uniqueid.' #mec_event_ticket"+ticket_id+" .mec-book-ticket-limit").val(max);
}

function mec_toggle_first_for_all'.$uniqueid.'()
{
    var status = jQuery("#mec_book_first_for_all'.$uniqueid.'").is(":checked") ? true : false;
    
    if(status)
    {
        jQuery("#mec_booking'.$uniqueid.' .mec-book-ticket-container:not(:first-child)").addClass("mec-util-hidden");
    }
    else
    {
        jQuery("#mec_booking'.$uniqueid.' .mec-book-ticket-container").removeClass("mec-util-hidden");
    }
}

function mec_label_first_for_all'.$uniqueid.'()
{
    var input = jQuery("#mec_book_first_for_all'.$uniqueid.'");
    if (!input.is(":checked")) {
        input.prop("checked", true);
        mec_toggle_first_for_all'.$uniqueid.'();
    } else {
        input.prop("checked", false);
        mec_toggle_first_for_all'.$uniqueid.'();
    }
}

function mec_book_form_submit'.$uniqueid.'()
{
    var step = jQuery("#mec_book_form'.$uniqueid.' input[name=step]").val();
    
    // Validate Checkboxes and Radio Buttons on Booking Form
    if(step == 2)
    {
        var valid = true;
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-field-name.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][name]\']").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-field-email.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][email]\']").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-checkbox.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"][]\']").is(":checked"))
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-radio.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"]\']:checked").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-agreement.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"]\']:checked").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-tel.mec-reg-mandatory, .mec-book-ticket-container .mec-book-reg-field-email.mec-reg-mandatory, .mec-book-ticket-container .mec-book-reg-field-text.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' input[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"]\']").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-select.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' select[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"]\']").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        jQuery("#mec_book_form'.$uniqueid.' .mec-book-ticket-container .mec-book-reg-field-textarea.mec-reg-mandatory").filter(":visible").each(function(i)
        {
            var ticket_id = jQuery(this).data("ticket-id");
            var field_id = jQuery(this).data("field-id");
            
            if(!jQuery("#mec_book_form'.$uniqueid.' textarea[name=\'book[tickets]["+ticket_id+"][reg]["+field_id+"]\']").val())
            {
                valid = false;
                jQuery(this).addClass("mec-red-notification");
            }
            else jQuery(this).removeClass("mec-red-notification");
        });
        
        if(!valid) return false;
    }

    // Add loading Class to the button
    jQuery("#mec_book_form'.$uniqueid.' button[type=submit]").addClass("loading");
    jQuery("#mec_booking_message'.$uniqueid.'").removeClass("mec-success mec-error").hide();
       
    var fileToUpload = false;
    
    var data = jQuery("#mec_book_form'.$uniqueid.'").serialize();
    jQuery.ajax({
        type: "POST",
        url: "'.admin_url('admin-ajax.php', NULL).'",
        data: new FormData(jQuery("#mec_book_form'.$uniqueid.'")[0]),
        dataType: "JSON",
        processData: false,
        contentType: false,
        cache: false,
        success: function(data)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form'.$uniqueid.' button[type=submit]").removeClass("loading");
            
            if(data.success)
            {
                jQuery("#mec_booking'.$uniqueid.'").html(data.output);
                jQuery("#mec_book_form'.$uniqueid.'").off("submit").on("submit", function(event)
                {
                    event.preventDefault();
                    mec_book_form_submit'.$uniqueid.'();
                });
                
                // Show Invoice Link
                if(typeof data.data.invoice_link != "undefined" && data.data.invoice_link != "")
                {
                    jQuery("#mec_booking'.$uniqueid.'").append("<a class=\"mec-invoice-download\" href=\""+data.data.invoice_link+"\">'.esc_js(__('Download Invoice', 'modern-events-calendar-lite')).'</a>");
                }
                
                // Redirect to thank you page
                if(typeof data.data.redirect_to != "undefined" && data.data.redirect_to != "")
                {
                    setTimeout(function(){window.location.href = data.data.redirect_to;}, 2000);
                }
            }
            else
            {
                jQuery("#mec_booking_message'.$uniqueid.'").addClass("mec-error").html(data.message).show();
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form'.$uniqueid.' button[type=submit]").removeClass("loading");
        }
    });
}

function mec_book_apply_coupon'.$uniqueid.'()
{
    // Add loading Class to the button
    jQuery("#mec_book_form_coupon'.$uniqueid.' button[type=submit]").addClass("loading");
    jQuery("#mec_booking'.$uniqueid.' .mec-book-form-coupon .mec-coupon-message").removeClass("mec-success mec-error").hide();
    
    var data = jQuery("#mec_book_form_coupon'.$uniqueid.'").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: "'.admin_url('admin-ajax.php', NULL).'",
        data: data,
        dataType: "JSON",
        success: function(data)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form_coupon'.$uniqueid.' button[type=submit]").removeClass("loading");
            
            if(data.success)
            {
                // It converts to free booking because of applied coupon
                if(data.data.price_raw === 0)
                {
                    jQuery("#mec_booking'.$uniqueid.' .mec-book-form-gateways").hide();
                    jQuery("#mec_book_form_free_booking'.$uniqueid.'").show();
                }
                
                jQuery("#mec_booking'.$uniqueid.' .mec-book-form-coupon .mec-coupon-message").addClass("mec-success").html(data.message).show();
                
                jQuery("#mec_booking'.$uniqueid.' .mec-book-price-details .mec-book-price-detail-typediscount").remove();
                jQuery("#mec_booking'.$uniqueid.' .mec-book-price-details").append(data.data.price_details);
                
                jQuery("#mec_booking'.$uniqueid.' .mec-book-price-total").html(data.data.price);
                jQuery("#mec_booking'.$uniqueid.' #mec_do_transaction_paypal_express_form"+data.data.transaction_id+" input[name=amount]").val(data.data.price_raw);
            }
            else
            {
                jQuery("#mec_booking'.$uniqueid.' .mec-book-form-coupon .mec-coupon-message").addClass("mec-error").html(data.message).show();
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form_coupon'.$uniqueid.' button[type=submit]").removeClass("loading");
        }
    });
}

function mec_book_free'.$uniqueid.'()
{
    // Add loading Class to the button
    jQuery("#mec_book_form_free_booking'.$uniqueid.' button[type=submit]").addClass("loading");
    jQuery("#mec_booking_message'.$uniqueid.'").removeClass("mec-success mec-error").hide();
    
    var data = jQuery("#mec_book_form_free_booking'.$uniqueid.'").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: "'.admin_url('admin-ajax.php', NULL).'",
        data: data,
        dataType: "JSON",
        success: function(data)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form_free_booking'.$uniqueid.' button[type=submit]").removeClass("loading");
            
            if(data.success)
            {
                jQuery("#mec_booking'.$uniqueid.'").html(data.output);
                
                // Show Invoice Link
                if(typeof data.data.invoice_link != "undefined" && data.data.invoice_link != "")
                {
                    jQuery("#mec_booking'.$uniqueid.'").append("<a class=\"mec-invoice-download\" href=\""+data.data.invoice_link+"\">'.esc_js(__('Download Invoice', 'modern-events-calendar-lite')).'</a>");
                }
                
                // Redirect to thank you page
                if(typeof data.data.redirect_to != "undefined" && data.data.redirect_to != "")
                {
                    setTimeout(function(){window.location.href = data.data.redirect_to;}, 2000);
                }
            }
            else
            {
                jQuery("#mec_booking_message'.$uniqueid.'").addClass("mec-error").html(data.message).show();
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            jQuery("#mec_book_form_free_booking'.$uniqueid.' button[type=submit]").removeClass("loading");
        }
    });
}

function mec_check_variation_min_max'.$uniqueid.'(variation)
{
    var value = parseInt(jQuery(variation).val());
    var max = parseInt(jQuery(variation).prop("max"));
    var min = parseInt(jQuery(variation).prop("min"));
    
    if(value > max) jQuery(variation).val(max);
    if(value < min) jQuery(variation).val(min);
}
</script>';

// Include javascript code into the footer
if($this->is_ajax()) echo $javascript;
else $factory->params('footer', $javascript);
?>
<div class="mec-booking" id="mec_booking<?php echo $uniqueid; ?>">
    <?php
        include MEC::import('app.modules.booking.steps.tickets', true, true);
    ?>
</div>
<div id="mec_booking_message<?php echo $uniqueid; ?>" class="mec-util-hidden"></div>