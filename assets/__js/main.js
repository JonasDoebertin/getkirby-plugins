

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
       isotopeFilters   = $('.js-isotope-filters');

   isotopeContainer.isotope({
       itemSelector: '.js-isotope-item',
       layoutMode:   'fitRows'
   });

   isotopeFilters.on('click', '.js-isotope-filter', function(e){
        e.preventDefault();
        isotopeContainer.isotope({filter: $(this).attr('data-filter')});
    });


});
