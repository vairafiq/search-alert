<?php

namespace searchAlert\Module\Integrations\GeoDirectory;

use searchAlert\Base\Helper;
use function searchAlert\Base\Helper\search_alert_clean;
class Controller {

     /**
     * Constuctor
     *
     */
    function __construct() {
		add_action( 'wp_ajax_update_search_notice', array( $this, 'update_search_notice' ) );
		add_action( 'wp_ajax_nopriv_update_search_notice', array( $this, 'update_search_notice' ) );
    }

    public function update_search_notice() {

      if( ! Helper\verify_nonce() ) {
        wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
      }

      if( ! is_user_logged_in() ) {
        //request email
      }

      $search = ! empty( $_POST['query'] ) ? search_alert_clean( wp_unslash( $_POST['query'] ) ) : '';
      $task   = ! empty( $_POST['task'] ) ? search_alert_clean( wp_unslash( $_POST['task'] ) ) : '';

      $args = [
        'post_title' => 'New search for ' . $search,
        'meta_input' => [
          '_search_by' => [ get_current_user_id() ],
          '_number_of_search' => 1,
          '_keyword' => $search,
        ],
      ];

    $user_search = Helper\update_search( $args, $task );
    
    if( is_wp_error( $user_search ) ) {
      wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
    }
     
    wp_send_json_success( $user_search, 200 );

    }	
 
}

