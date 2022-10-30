<?php

namespace searchAlert\Module\Settings_Panel;

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
            Asset\Init::class,
            Rest_API\Init::class,
        ];
    }

}