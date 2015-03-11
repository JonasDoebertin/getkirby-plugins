<?php

/*
    DATA PREPERATION
    ================
    1. Get all visible plugins
 */
$plugins = $pages
    ->find('plugins')->children()
    ->filterBy('draft', 'false')
    ->sortBy('created', 'desc');


/*
    Feed STRUCTURE
    =================
    1. Send feed markup
 */
echo $plugins->feed(array(
  'title'       => 'Latest Plugins & Extensions',
  'link'        => url('/'),
  'url'         => url('/feed'),
  'datefield'   => 'created',
));
