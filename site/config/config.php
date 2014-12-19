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

c::set('license', 'put your license key here');

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
        1. Reroute calls to "/sitemap.xml" to "/sitemap"
     */
    array(
        'pattern' => 'sitemap.xml',
        'action'  => function() {
            return site()->visit('sitemap');
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

c::set('sitemap.ignore', array());

/*
    Disable the output of debug information on production sites
 */
c::set('debug', false);
