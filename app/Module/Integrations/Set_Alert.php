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

		add_action( 'atbdp_listing_contact_owner_submitted', array( $this, 'set_alert_on_contact_submitted' ) );
		
    }

    public function set_alert_on_contact_submitted( $data ) {
    
      if( 'on' !== $data['send_alert'] ) {
        return;
      }

      $post_title = ! empty( $data['post_id'] ) ? esc_html( get_the_title( $data['post_id'] ) ) : '';
      $email      = ! empty( $data['email'] ) ? search_alert_clean( wp_unslash( $data['email'] ) ) : '';
      $keywords   = explode(' ', $post_title);

      if( $keywords ) {
        foreach( $keywords as $keyword ) {
          $prepare_data = [
            'keyword' => $keyword,
            'email' => $email,
          ];
    
          Helper\process_post( $prepare_data );
        }
      }

    }

    public function set_alert() {

        if( ! Helper\verify_nonce( 'nonce' ) ) {
          wp_send_json( [ 'error' => esc_html__( 'Invalid nonce, please refresh the page try again', 'search-alert' ) ], 200 );
        }
  
        if( ! is_user_logged_in() ) {
          //request email
        }

        //lets insert keyword as a term and create a post for the user with this keyword
        $post_id = Helper\process_post( $_POST );

        if( is_wp_error( $post_id ) ) {
          wp_send_json( [ 'error' => esc_html__( 'Failed to saved', 'search-alert' ) ], 200 );
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



