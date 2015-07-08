<?php

/*
    DATA PREPERATION
    ================
    1. Get all visible plugins
 */
$items = $page->rootpage()->toPage()->children()->filterBy('draft', 'false');


/*
    Feed STRUCTURE
    =================
    1. Send feed markup
 */
echo $items->feed(array(
  'title'       => $page->title()->html(),
  'link'        => url('/'),
  'url'         => $page->url(),
  'datefield'   => 'created',
));
