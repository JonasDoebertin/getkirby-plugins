<?php

/*
    DATA PREPERATION
    ================
    1. Get ignored pages from config
    2. Get latest plugin content modification date
 */
$ignore = c::get('sitemap.ignore');
$lastMod = $pages->find('plugins')->children()->filterBy('draft', 'false')->sortBy('modified', 'desc')->first()->modified('c');


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

    <!-- homepage (use modification date of latest plugin modification)-->
    <url>
        <loc><?= $site->url() ?></loc>
        <priority>1</priority>
        <lastmod><?= $lastMod ?></lastmod>
    </url>

</urlset>
