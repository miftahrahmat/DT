/*! Auxin Pro Tools - v1.0.0 (2018-06-13)
 *  All required plugins 
 *  http://averta.net/phlox/
 */



/*! 
 * 
 * ================== public/assets/js/src/module.protools.js =================== 
 **/ 

;(function($){

    // on document ready
    $(function(){

        // Auxin Countdown Element
        $.fn.AuxinCountDown = function(){
            var $wrapper = $(this).find('.aux-countdown-wrapper '),
                data = {
                    year     : $wrapper.data('countdown-year'),
                    month    : $wrapper.data('countdown-month'),
                    day      : $wrapper.data('countdown-day'),
                    hour     : $wrapper.data('countdown-hour'),
                    min      : $wrapper.data('countdown-min'),
                    sec      : $wrapper.data('countdown-sec')
                },

                targetDate = new Date(data.year,data.month,data.day,data.hour,data.min,data.sec);
                $year      = $wrapper.find('.aux-countdown-year'),
                $month     = $wrapper.find('.aux-countdown-month'),
                $day       = $wrapper.find('.aux-countdown-day'),
                $hour      = $wrapper.find('.aux-countdown-hour'),
                $min       = $wrapper.find('.aux-countdown-min'),
                $sec       = $wrapper.find('.aux-countdown-sec');
                
            setInterval( function(){
                var diffTime = ( Date.parse(targetDate) - Date.parse(new Date() ) );
                    diffTime = diffTime / 1000 ;

                $year.text( Math.floor( diffTime /  ( 31536000 ) ) ); // 1 year = 3153600 second
                $month.text( Math.floor( ( diffTime / 2592000 ) % 12 ) ); // 1 month = 2592000 second
                $day.text( Math.floor( ( diffTime / 86400 ) % 365 ) ); // 1 day = 86400 second
                $hour.text( Math.floor( ( diffTime / 3600 ) % 24 ) ); // 1 hour = 3600 second
                $min.text( Math.floor( ( diffTime / 60 ) % 60 ) ); // 1 min  = 60 second
                $sec.text( Math.floor( ( diffTime ) % 60 ) );

            },1000 )
            
        }

        $('.aux-widget-countdown').each(function(){
            $(this).AuxinCountDown();
        });


    });

})(jQuery);