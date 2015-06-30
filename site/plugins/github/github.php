<?php

require_once 'Fetcher.php';

function github() {
    return \jdpowered\Github\Fetcher::getInstance();
}
