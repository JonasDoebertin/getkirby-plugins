<?php if(!defined('KIRBY')) exit ?>

title: Plugin
pages: false
files: false
preview: false
fields:
    title:
        label: Name
        type:  text
        required: true
    subtitle:
        label: Subtitle
        type:  text
        required: true
    description:
        label: Description
        type:  textarea
        width: 1/2
        required: true
    featured:
        label: Featured Plugin
        type: toggle
        text: on/off
        width: 1/2
