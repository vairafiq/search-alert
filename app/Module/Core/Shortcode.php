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
      $atts = shortcode_atts(
          array(
              'form_type' => '',
          ),
          $atts
      );

      $form_type = !empty($atts['form_type']) ? $atts['form_type'] : 'inline';
      $heading = !empty($atts['heading']) ? $atts['heading'] : __( 'Register Today', 'searchalert' );
      $data = [
        'form_type' => $form_type,
        'heading' => $heading,
      ];

      ob_start();

      if( 'inline' === $form_type ) {
        Helper\get_template( 'add-search', $data );
      }
      if( 'full' === $form_type ) {
        Helper\get_template( 'add-search-form', $data );
      }

      return ob_get_clean();
    }
}

