

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
   var isotopeContainer = $('.js-isotope'),
       isotopeFilters   = $('.js-isotope-filter');

   isotopeContainer.isotope({
       itemSelector: '.js-isotope-item',
       layoutMode:   'fitRows'
   });

   isotopeFilters.on('click', function(e){
        e.preventDefault();
        isotopeContainer.isotope({filter: $(this).attr('data-filter')});
        isotopeFilters.attr('data-active', 'false');
        $(this).attr('data-active', 'true');
    });


});
