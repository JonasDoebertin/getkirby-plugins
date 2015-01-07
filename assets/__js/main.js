

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

    /*
        [1] Initialize Isotope
     */
    isotopeContainer.isotope({
        itemSelector: '.js-isotope-item',
        layoutMode:   'fitRows'
    });

    /*
        [2] Recalculate positions after pageload
     */
    setTimeout(function() {
        isotopeContainer.isotope('layout');
    }, 300);

    /*
        [3] Make filter links work
     */
    isotopeFilters.on('click', function(e){

        var value = $(this).attr('data-filter');

        e.preventDefault();
        isotopeContainer.isotope({filter: value});
        isotopeFilters.attr('data-active', 'false');
        $(this).attr('data-active', 'true');

        /*
            Tracking will be enabled for production sites only
         */
        if(Config.environment == 'production'){
            _paq.push(['trackEvent', 'Filter', (value == '*') ? 'Reset' : 'Set', (value !== '*') ? value : '']);
        }

    });


});
