<?php

namespace searchAlert\Module\Core;

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

        $this->setup_page();

    }

    public function setup_page() {
        register_activation_hook( )
    }

    /**
     * Controllers
     *
     * @return array
     */
    protected function get_controllers() {
        return [
            Asset\Init::class,
            Admin\Init::class,
            Rest_API\Init::class,
        ];
    }

}