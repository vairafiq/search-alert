<?php

namespace searchAlert\Module\Integrations;

use searchAlert\Base\Helper;
use function searchAlert\Base\Helper\search_alert_clean;

class Set_Alert {

     /**
     * Constuctor
     *
     */
    function __construct() {
		
		add_action( 'wp_ajax_update_search_notice', array( $this, 'update_search_notice' ) );
		add_action( 'wp_ajax_nopriv_update_search_notice', array( $this, 'update_search_notice' ) );
  
    add_action( 'wp_ajax_directorist_save_search', array( $this, 'set_alert' ) );
		add_action( 'wp_ajax_nopriv_directorist_save_search', array( $this, 'set_alert' ) );
		
    }

    public function set_alert() {

        if( ! Helper\verify_nonce( 'nonce' ) ) {
          wp_send_json_error( esc_html__( 'Invalid nonce, please refresh the page try again', 'search-alert' ), 400 );
        }
  
        if( ! is_user_logged_in() ) {
          //request email
        }

        //lets insert keyword as a term and create a post for the user with this keyword
        $post_id = $this->process_post( $_POST );

        if( is_wp_error( $post_id ) ) {
          wp_send_json_error( esc_html__( 'Failed to saved', 'search-alert' ), 400 );
        }

        wp_send_json_success(esc_html__( 'Successfully saved', 'search-alert' ), 200);



      //   $args = [
      //     'post_title' => 'New search for ' . $search,
      //     'meta_input' => [
      //       '_search_by'        => [ $user ],
      //       '_email_subscriber' => [ $email ],
      //       '_number_of_search' => 1,
      //       '_keyword' => $search,
      //     ],
      //   ];
      //   if( empty( $email ) ) {
      //     unset( $args['meta_input']['_email_subscriber'] );
      //   }
      //   if( empty( $user ) ) {
      //     unset( $args['meta_input']['_search_by'] );
      //   }
  
      // $user_search = Helper\update_search( $args, $task );
      
      // if( is_wp_error( $user_search ) ) {
      //   wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
      // }
       
      // wp_send_json_success( $user_search, 200 );
  
    }	

    public function process_post( $data ) {

        $keyword       = ! empty( $data['keyword'] ) ? search_alert_clean( wp_unslash( $data['keyword'] ) ) : '';
        $sl_category   = ! empty( $data['sl_category'] ) ? search_alert_clean( wp_unslash( $data['sl_category'] ) ) : '';
        
        if( ! $keyword ) {
            wp_send_json_error( esc_html__( 'Keyword is missing', 'search-alert' ), 400 );
        }

        unset( $data['action'] );
        unset( $data['nonce'] );


        $args = [
          'post_type' => 'esl_search_alerts',
          'post_status' => 'publish',
          'post_title' => 'Search Alert for ' . $keyword,
          'tax_input'    => [ "esl_keyword" => $keyword ],
          'meta_input' => $data,
          'post_author' => get_current_user_id(),
        ];

        if( $data['search_id'] ) {

          $args['ID'] = $data['search_id'];
          $post_id = wp_update_post( $args );

        }else{

          $post_id = wp_insert_post( $args );

        }

        $term    = wp_insert_term( $keyword, 'esl_keyword' );
        
        if( is_wp_error( $term ) ) {
          if ( $term->get_error_code() === 'term_exists' ) {
						// When term exists, error data should contain existing term id.
						$term_id = $term->get_error_data();
					}
        }else{
          $term_id = $term['term_id'];
        }

        wp_set_object_terms( $post_id, $term_id, 'esl_keyword' );

        return $post_id;
    
    }

    public function update_search_notice() {

        if( ! Helper\verify_nonce() ) {
          wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
        }
  
        if( ! is_user_logged_in() ) {
          //request email
        }
  
        $search = ! empty( $_POST['query'] ) ? search_alert_clean( wp_unslash( $_POST['query'] ) ) : '';
        $email  = ! empty( $_POST['email'] ) ? search_alert_clean( wp_unslash( $_POST['email'] ) ) : '';
        $user   = ! empty( $_POST['user'] ) ? search_alert_clean( wp_unslash( $_POST['user'] ) ) : '';
        $task   = ! empty( $_POST['task'] ) ? search_alert_clean( wp_unslash( $_POST['task'] ) ) : '';
        
        if( ! $search ) {
            wp_send_json_error( esc_html__( 'Keyword is missing', 'search-alert' ) );
        }
    
        $args = [
          'post_title' => 'New search for ' . $search,
          'meta_input' => [
            '_search_by'        => [ $user ],
            '_email_subscriber' => [ $email ],
            '_number_of_search' => 1,
            '_keyword' => $search,
          ],
        ];
        if( empty( $email ) ) {
          unset( $args['meta_input']['_email_subscriber'] );
        }
        if( empty( $user ) ) {
          unset( $args['meta_input']['_search_by'] );
        }
  
      $user_search = Helper\update_search( $args, $task );
      
      if( is_wp_error( $user_search ) ) {
        wp_send_json_error( esc_html__( 'Failde to saved', 'search-alert' ) );
      }
       
      wp_send_json_success( $user_search, 200 );
  
    }	
 
}

