<?php if(!defined('KIRBY')) exit ?>

title: Text Page
pages: true
files: true
fields:
    headline1:
        label:    Title & Subtitle
        type:     headline
    title:
        label:    Title
        type:     text
        required: true
        width:    1/2
    subtitle:
        label:    Subtitle
        type:     text
        required: true
        width:    1/2

    headline2:
        label:    Content
        type:     headline
    text:
        label:    Text
        type:     markdown
