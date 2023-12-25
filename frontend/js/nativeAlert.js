(function ($) {
 
    $.fn.nativeAlert = function(options) {
 
        var settings = $.extend({
            duration : 3000,
            type: "primary",
            content : 'Test'
        }, options );
 
        setTimeout( function(){
          $(this.selector).html('');
          //alert('shit');
        }, settings.duration);

        return $(this.selector).html('<div class="alert alert-'+settings.type+'">'+settings.content+'</div>');

 
    };
 
}( jQuery ));