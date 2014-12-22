

jQuery(function($) {

    /**
     * #RETINA.JS
     */
    Retina.configure({
        retinaImageSuffix: '-2x'
    });

    /**
     * #DOTDOTDOT.JS
     */
    var pluginDescriptions = $('.js-plugin-description');

    pluginDescriptions.dotdotdot({
        ellipsis: '\u2026',
        watch: 'window'
    });


    /**
     * #ISOTOPE
     * [1] Initialize Isotope
     * [2] Recalculate positions after pageload
     * [3] Make filter links work
     */
   var isotopeContainer = $('.js-isotope'),
       isotopeFilters   = $('.js-isotope-filter');

   isotopeContainer.isotope({
       itemSelector: '.js-isotope-item',
       layoutMode:   'fitRows'
   });

    setTimeout(function() {
        isotopeContainer.isotope('layout');
    }, 300);

   isotopeFilters.on('click', function(e){
        e.preventDefault();
        isotopeContainer.isotope({filter: $(this).attr('data-filter')});
        isotopeFilters.attr('data-active', 'false');
        $(this).attr('data-active', 'true');
    });


});
