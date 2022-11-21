<?php

namespace searchAlert\Module\Core;

use searchAlert\Base\Helper;
use function searchAlert\Base\Helper\search_alert_clean;

class Import {

     /**
     * Constuctor
     *
     */
    function __construct() {
		
		add_action( 'wp_ajax_import_subscribers', array( $this, 'import_subscribers' ) );
		add_action( 'wp_ajax_nopriv_import_subscribers', array( $this, 'import_subscribers' ) );
		
    }

    public function import_subscribers() {

        if( ! Helper\verify_nonce() ) {
          wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
        }

        $file = ! empty( $_FILES['csv_file']['tmp_name'] ) ? $_FILES['csv_file']['tmp_name'] : ''; 

        if( ! $file ) {
          wp_send_json_error( esc_html__( 'File is required', 'search-alert' ) );
        }

        $csv_data = array_map( 'str_getcsv', file( $file ) );

        array_walk($csv_data , function(&$x) use ($csv_data) {
          $x = array_combine($csv_data[0], $x);
        });
        
        /** 
        *
        * array_shift = remove first value of array 
        * in csv file header was the first value
        * 
        */
        array_shift($csv_data);

        // $args = [];
        foreach( $csv_data as $data ) {
          $keyword = ! empty( $data['keyword'] ) ? $data['keyword'] : '';
          // $action  = ! empty( $data['action'] ) ? $data['action'] : '';
          $action  = 'add';
          $email   = ! empty( $data['email'] ) ? explode( ',', $data['email'] ) : '';

          $args = [
            'post_title' => 'New search for ' . $keyword,
            'meta_input' => [
              '_email_subscriber' => $email,
              '_number_of_search' => 1,
              '_keyword' => $keyword,
            ],
          ];

          $user_search = Helper\update_search( $args, $action );
          if( is_wp_error( $user_search ) ) {
            continue;
          }

        }       
      wp_send_json_success( $user_search, 200 );
  
      }	
 
}

