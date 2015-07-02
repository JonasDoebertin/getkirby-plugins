<?php

namespace jdpowered\GetKirbyPlugins\Logic\Structures;

class Message
{
    public $user;

    public $repo;

    public function __construct($user, $repo)
    {
        $this->user = $user;
        $this->repo = $repo;
    }

    public function __toString()
    {
        return json_encode([
            'user' => $this->user,
            'repo' => $this->repo,
        ]);
    }
}
