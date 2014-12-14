

jQuery(function($) {

    /*
        Clamp plugin description texts
     */
    var pluginDescriptions = $('.js-plugin-description');

    pluginDescriptions.dotdotdot({
        ellipsis: '\u2026',
        watch: 'window'
    });


    /*
        Initialize Isotope
    */
   var plugins = $('.js-isotope');

   plugins.isotope({
       itemSelector: '.js-isotope-item',
       layoutMode: 'fitRows'
   });


});
