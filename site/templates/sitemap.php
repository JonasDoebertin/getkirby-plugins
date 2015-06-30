<?php

/*
    DATA PREPERATION
    ================
    1. Get ignored pages from config
    2. Get latest plugin content modification date
    3. Get all plugins
 */
$ignore = c::get('sitemap.ignore');
$lastMod = $pages->find('plugins')->children()->filterBy('draft', 'false')->sortBy('modified', 'desc')->first()->modified('c');
$plugins = $pages->find('plugins')->children()->filterBy('draft', 'false')->sortBy('uid', 'asc');


/*
    SITEMAP STRUCTURE
    =================
    1. Send correct content type header
    2. Print XML tag (would break PHP parsing, if added below)
 */
header('Content-type: text/xml; charset="utf-8"');
echo '<?xml version="1.0" encoding="utf-8"?>';

?>


<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php /* homepage (use modification date of latest plugin modification) */ ?>
    <url>
        <loc><?= $site->url() ?></loc>
        <priority>0.75</priority>
        <lastmod><?= $lastMod ?></lastmod>
    </url>

    <?php /* TODO: about */ ?>

    <?php /* plugins */ ?>
    <?php foreach ($plugins as $plugin): ?>
        <url>
            <loc><?= url($plugin->uid()) ?></loc>
            <priority>1</priority>
            <lastmod><?= $plugin->modified('c') ?></lastmod>
        </url>
    <?php endforeach ?>

</urlset>
