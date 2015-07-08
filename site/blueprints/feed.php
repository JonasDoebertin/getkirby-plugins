<?php if(!defined('KIRBY')) exit ?>

title:     Feed
pages:
    template:
        - feed
files:     false
preview:   false
deletable: false
fields:
    title:
        label: Title
        type:  text
    rootpage:
        label: Feed Root pages
        type: page
