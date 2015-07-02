<?php

namespace jdpowered\GetKirbyPlugins\Logic\Structures;

class Info
{
    /**
     * Text.
     * @var string
     */
    public $text;

    /**
     * Constructur.
     *
     * @method __construct
     * @param  string  $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

}
