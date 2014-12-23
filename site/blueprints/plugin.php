<?php if(!defined('KIRBY')) exit ?>

title:   Plugin
pages:   false
files:   false
preview: false
fields:
    title:
        label:    Name
        type:     text
        required: true
        width:    1/2
    draft:
        label:    Draft
        type:     toggle
        text:     yes/no
        required: true
        width:    1/4
        default:  true
    created:
        label:    Added
        type:     date
        format:   MM/DD/YYYY
        default:  today
        required: true
        width:    1/4
    subtitle:
        label:    Subtitle
        type:     text
        required: true
        width:    1/2
    featured:
        label:    Featured Plugin
        type:     toggle
        text:     yes/no
        required: true
        width:    1/4
        default:  false
    icon:
        label:    Icon
        type:     select
        default:  generic
        options:
            calendar: Calendar
            cloud:      Cloud
            coffee:     Coffee
            feed:       Feed / RSS
            formatting: Formatting
            generic:    Generic
            heart:      Heart
            image:      Image
            kirby:      Kirby Logo
            link:       Link / Anchor
            location:   Location
            loop:       Loop / Repeat / Retweet
            markup:     Markup
            mobile:     Mobile
            panel:      Panel
            payment:    Payment
            quotes:     Quotes
            search:     Search
            star:       Star
            tags:       Tags
            text:       Text
            time:       Time
            twitter:    Twitter Logo
            users:      Users
            video:      Video
        width:    1/4
    description:
        label:    Description
        type:     textarea
        width:    3/4
        required: true
    type:
        label:    Plugin Type
        type:     checkboxes
        options:
            general:   General Plugin
            kirbytext: KirbyText Extension
            field:     Field Extension
            panel:     Panel Extension
        width:    1/4
        columns:  1
    authorname:
        label:    Author Name
        type:     text
        required: true
        width:    1/2
    downloadtitle:
        label:    Download Link Title
        type:     text
        required: true
        width:    1/2
    authorlink:
        label:    Author Link
        type:     url
        required: true
        width:    1/2
    downloadlink:
        label:    Download Link
        type:     url
        required: true
        width:    1/2
