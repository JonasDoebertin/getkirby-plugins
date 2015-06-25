<?php if(!defined('KIRBY')) exit ?>

title:   Plugin
pages:   false
files:   false
preview: false
fields:
    headline1:
        label:    Name & Title
        type:     headline
    title:
        label:    Name
        type:     text
        required: true
        width:    1/2
    subtitle:
        label:    Subtitle
        type:     text
        required: true
        width:    1/2

    headline2:
        label:    Descriptions & Texts
        type:     headline
    description:
        label:    Description
        type:     textarea
        required: true
        buttons:  false
    text:
        label:    Main Text
        type:     markdown
        header1:  h4
        header2:  h5
        required: true

    headline3:
        label:    Author Information
        type:     headline
    authorname:
        label:    Author Name
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

    headline4:
        label:    Settings
        type:     headline
    draft:
        label:    Draft
        type:     toggle
        text:     yes/no
        required: true
        width:    1/4
        default:  true
        columns:  1
    featured:
        label:    Featured Plugin
        type:     toggle
        text:     yes/no
        required: true
        width:    1/4
        default:  false
        columns:  1
    created:
        label:    Added
        type:     date
        format:   MM/DD/YYYY
        default:  today
        required: true
        width:    1/4
        columns:  1
    icon:
        label:    Icon
        type:     select
        default:  generic
        sort:     asc
        options:
            music:      Audio / Music
            magic:      Magic
            instagram:  Instagram Logo
            share:      Sharing
            paint:      Theme / Paint / Style
            kirby:      Kirby Logo
            coffee:     Coffee
            image:      Image
            video:      Video
            tags:       Tags
            payment:    Payment
            location:   Location
            calendar:   Calendar
            mobile:     Mobile
            users:      Users
            quotes:     Quotes
            time:       Time
            search:     Search
            generic:    Generic
            cloud:      Cloud
            link:       Link / Anchor
            star:       Star
            heart:      Heart
            loop:       Loop / Repeat / Retweet
            panel:      Panel
            formatting: Formatting
            text:       Text
            markup:     Markup
            twitter:    Twitter Logo
            feed:       Feed / RSS
        width:    1/4
    type:
        label:    Plugin Type
        type:     checkboxes
        options:
            general:   General Plugin
            kirbytext: KirbyText
            field:     Page Content
            panel:     Panel Field
            widget:    Panel Widget
        width:    1/2
        columns:  2
