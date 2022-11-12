<?php

namespace searchAlert\Module\Core;

use searchAlert\Base\Helper;

class Shortcode {

     /**
     * Constuctor
     *
     */
    function __construct() {
		// add_shortcode( 'searchalert', array( $this, 'set_alert_form' ) );
		add_action( 'init', array( $this, 'shortcode' ) );
		
    }

    public function shortcode() {
        add_shortcode( 'searchalert', array( $this, 'set_alert_form' ) );
    }

    public function set_alert_form( $atts ) {
      Helper\get_template( 'add-search' );
    }
}

