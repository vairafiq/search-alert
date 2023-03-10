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

        $features = [ Send_Alert::class,  Set_Alert::class ];

        if( class_exists( "Directorist_Base" ) ) {
            array_push( $features,Directorist\Init::class );
        }

        if( class_exists( "GeoDirectory" ) ) {
            array_push( $features,GeoDirectory\Init::class );
        }
        return $features;

    }

}