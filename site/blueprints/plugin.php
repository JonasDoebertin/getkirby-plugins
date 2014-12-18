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
        width: 1/2
    draft:
        label: Draft
        type: toggle
        text: yes/no
        required: true
        width: 1/4
    created:
        label: Added
        type: date
        format: MM/DD/YYYY
        default: today
        required: true
        width: 1/4
    subtitle:
        label: Subtitle
        type:  text
        required: true
        width: 1/2
    featured:
        label: Featured Plugin
        type: toggle
        text: yes/no
        required: true
        width: 1/4
    icon:
        label: Icon
        type: select
        default: generic
        options:
            kirby: Kirby Logo
            coffee: Coffee
            image: Image
            video: Video
            tags: Tags
            payment: Payment
            location: Location
            calendar: Calendar
            mobile: Mobile
            users: Users
            quotes: Quotes
            generic: Generic
            cloud: Cloud
            link: Link / Anchor
            star: Star
            heart: Heart
            loop: Loop / Repeat / Retweet
            panel: Panel
            formatting: Formatting
            text: Text
            tags: Tags
            twitter: Twitter Logo
            feed: Feed / RSS
            time: Time
            search: Search
        width: 1/4
    description:
        label: Description
        type:  textarea
        width: 3/4
        required: true
    type:
        label: Plugin Type
        type: checkboxes
        options:
            general: General Plugin
            kirbytext: KirbyText Extension
            field: Field Extension
            panel: Panel Extension
        width: 1/4
        columns: 1
    authorname:
        label: Author Name
        type: text
        required: true
        width: 1/2
    downloadtitle:
        label: Download Link Title
        type: text
        required: true
        width: 1/2
    authorlink:
        label: Author Link
        type: url
        required: true
        width: 1/2
    downloadlink:
        label: Download Link
        type: url
        required: true
        width: 1/2
