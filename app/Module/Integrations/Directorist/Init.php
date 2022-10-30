<?php

namespace searchAlert\Module\Integrations\Directorist;

use searchAlert\Helper;

class Init {

    /**
     * Constuctor
     *
     */
    function __construct() {

        // Register Enqueuers
        $enqueuers = $this->get_assets_enqueuers();
        Helper\Serve::register_services( $enqueuers );

    }

    private function get_assets_enqueuers() {
        return [
            Screen::class,
            Controller::class,
            Dashboard::class,
        ];
    }
}