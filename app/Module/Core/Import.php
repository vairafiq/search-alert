<?php

namespace searchAlert\Module\Core;

use searchAlert\Base\Helper;
use function searchAlert\Base\Helper\search_alert_clean;
use searchAlert\Module\Integrations\Set_Alert;

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

        $file = ! empty( $_FILES['csv_file']['tmp_name'] ) ? $_FILES['csv_file']['tmp_name'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash

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
          $category = ! empty( $data['category'] ) ? $data['category'] : '';
          $email   = ! empty( $data['email'] ) ? explode( ',', $data['email'] ) : '';
          
          if( ! $keyword ) {
            continue;
          }       
          if( ! $email ) {
            continue;
          }

          $args = [
            'sl_category' => $category,
            'keyword' => $keyword,
            'email' => $email,
          ];

          $post_id = Helper\import_subscribers( $args );
          // wp_send_json( $post_id );

          if( is_wp_error( $post_id ) ) {
            continue;
          }

        }   

        wp_send_json_success( __( 'Successfully Imported'), 200 );
  
      }	
 
}

