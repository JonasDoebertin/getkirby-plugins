<?php if(!defined('KIRBY')) exit ?>

title: Site Information
pages: true
fields:
    title:
        label: Title
        type:  text
        width: 1/2
    heading:
        label: Heading
        type:  text
        width: 1/2
    social:
        label: Social Networks
        type:  structure
        entry: >
            <strong>{{username}}</strong> (Icon: {{icon}})<br />
            {{link}}
        fields:
            username:
                label: Username
                type:  text
            icon:
                label:   Icon
                type:    select
                default: twitter
                options:
                    twitter: Twitter
            link:
                label: Link
                type: url
        width:  1/2
    description:
        label: Meta Description
        type:  textarea
        width: 1/2
    copyright:
        label: Copyright
        type:  textarea
        width: 1/2
    footerlinks:
        label: Footer Links
        type:  structure
        entry: >
            <strong>{{title}}</strong><br />
            {{href}}
        fields:
            title:
                label: Title
                type:  text
            href:
                label: Link
                type: url
        width:  1/2
    googleverification:
        label: Google Site Verification Code
        type:  text
        width: 1/2
