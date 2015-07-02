<?php

return function($site, $pages, $page) {

    // Get latest release & plugin info
    $release = fetch()->cached('release', $page->repository());
    $info    = fetch()->cached('info', $page->repository());

    return array(
        'release' => $release,
        'info'    => $info,
    );
};
