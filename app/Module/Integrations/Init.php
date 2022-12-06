<?php

namespace searchAlert\Module\Integrations;

use searchAlert\Helper;

class Init {

    /**
     * Constuctor
     *
     * @return void
     */
    public function __construct() {
        // Register Controllers
        $controllers = $this->get_controllers();
        Helper\Serve::register_services( $controllers );

    }

    /**
     * Controllers
     *
     * @return array
     */
    protected function get_controllers() {
        return [
            Directorist\Init::class,
            GeoDirectory\Init::class,
            Send_Alert::class,
            Set_Alert::class,
        ];
    }

}