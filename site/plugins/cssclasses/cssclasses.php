<?php

class CssClasses {

    public static function pluginAttributes($plugin)
    {
        $classes = ' [ ';

        if($plugin->featured()->bool())
        {
            $classes .= ' plugin--featured ';
        }

        if((strtotime($plugin->created()) + 60 * 60 * 24 * c::get('app.new.duration', 30)) > time())
        {
            $classes .= ' plugin--new ';
        }

        return $classes . ' ] ';
    }

    public static function pluginType($plugin)
    {
        $classes = '';

        foreach($plugin->type()->split(',') as $type)
        {
            $classes .= ' js-isotope-item-' . $type . ' ';
        }

        return $classes;
    }

}
