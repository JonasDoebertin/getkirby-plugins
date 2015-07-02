<?php if(!defined('KIRBY')) exit;

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', ' just go ahead and get your own license key ;-) ');

/*

---------------------------------------
Routing
---------------------------------------

Set up some additional routes here.

*/

c::set('routes', array(

    /*
        SITEMAP
        =======
        1. Reroute calls to "/sitemap" to "/sitemap.xml"
        2. Return "/sitemap" when fetching "sitemap.xml"
     */
    array(
        'pattern' => 'sitemap',
        'action'  => function() {
            go('sitemap.xml');
        }
    ),

    array(
        'pattern' => 'sitemap.xml',
        'action'  => function() {
            return site()->visit('sitemap');
        }
    ),

    /*
        SCHEDULER
        =========
        1. Add /schedule/trigger
        2. Add /schedule/run
     */
    array(
        'pattern' => 'schedule/trigger',
        'action'  => function() {
            return schedule()->trigger();
        },
    ),
    array(
        'pattern' => 'schedule/run',
        'action'  => function() {
            return schedule()->run();
        },
        'method' => 'POST',
    ),

    /*
        PLUGIN PAGES
        ============
     */
    array(
        'pattern' => '(.*)',
        'action' => function($slug) {

            // Check for homepage access
            if (empty($slug) or ($slug === '/')) {
                return site()->visit('home');
            }

            // Check if there's a plugin with this slug
            $plugin = page('plugins')->find($slug);
            if ($plugin !== false) {
                return site()->visit('plugins/' . $slug);
            }

            // Check if there's a page with that slug
            $page = site()->find($slug);
            if (($page !== false) and $page->isVisible()) {
                return site()->visit($slug);
            }

            return site()->visit('error');
        }
    ),

));

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('timezone', 'Europe/Berlin');
c::set('tinyurl.enabled', false);


/* Disable the output of debug information on production sites */
c::set('debug', false);

/*

---------------------------------------
Custom Configuration
---------------------------------------

Let's add some custom configuration options.

*/

c::set('environment', 'production');
c::set('sitemap.ignore', array());

c::set('app.new.duration', 30);
c::set('app.new.class', 'plugin--new');
c::set('app.featured.class', 'plugin--featured');
