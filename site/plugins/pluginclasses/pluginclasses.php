<?php

function pluginclasses($plugin)
{
    $classes = ' ';

    if($plugin->featured()->bool())
    {
        $classes .= 'plugin--featured ';
    }

    if((strtotime($plugin->created()) + 60 * 60 * 24 * 30) > time())
    {
        $classes .= 'plugin--new ';
    }
    return $classes;
}
