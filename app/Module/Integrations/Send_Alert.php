<?php

namespace searchAlert\Module\Integrations;

use Directorist\Asset_Loader\Helper as Asset_LoaderHelper;
use Directorist\Helper as DirectoristHelper;
use \WP_Error;
use \Google_Client;
use \WP_User;
use searchAlert\Base\Helper;
use WP_Query;

use function searchAlert\Base\Helper\search_alert_clean;
use function WPWaxCustomerSupportApp\Base\Helper\get_option;

class Send_Alert {

     /**
     * Constuctor
     *
     */
    function __construct() {
		add_action( 'transition_post_status', array( $this, 'new_post_alert_lookup' ), 10, 3 );
		// add_action( 'init', array( $this, 'testing' ) );
		
    }

    public function testing() {

        $keywords = explode( ' ', 'bmw for sell!!');
        // $keywords = explode( ' ', 'bmw for sell!!');

        $alerts = new WP_Query([
            'post_type' => 'esl_search_alerts',
            'post_status' => 'publish',
            's' => $keywords,
            'post_per_page' => -1,
            'fields' => 'ids',
          ]);
          $alerts = $alerts->posts;
          $all_subscribers = [];
          foreach( $alerts as $alert ) {
            $subscribers = get_post_meta( $alert, '_search_by', true );
            if( ! empty( $subscribers ) ) {
                foreach( $subscribers as $subscriber ) {
                    array_push( $all_subscribers, $subscriber );
                }
            }

          }
          var_dump([
            // 'post' => $alert,
            'subscribers' => array_unique( $all_subscribers ),
            'keywords' => $keywords,
            // 'post' => $alert,
          ]);
          die;
    }

    public function my_custom_search_template( $template ) {
      global $wp_query;
      if ( !$wp_query->is_search ) {
        return $template;
      }

      Helper\get_template( 'search' );
    }

    public function new_post_alert_lookup( $new_status, $old_status, $post ) {

        if( ! $post ) {
            return;
        }
        $post_id = $post->ID;

        if( is_admin() && ( ( 'publish' === $new_status ) && ( 'publish' !== $old_status ) ) ) {
            $this->send_notice( $post, $post_id );
            return;

        }
        if( ! is_admin() && ( ( 'publish' === $new_status ) && ( 'private' === $old_status ) ) ) {
            $this->send_notice( $post, $post_id );
        }
    }

    public function send_notice( $post, $post_id ) {

        $keywords = explode( ' ', get_the_title( $post_id ) );
        $alerts = new WP_Query([
            'post_type' => 'esl_search_alerts',
            'post_status' => 'publish',
            's' => $keywords,
            'post_per_page' => -1,
            'fields' => 'ids',
          ]);
          $alerts = $alerts->posts;
          $all_subscribers = [];
          $all_email_subscribers = [];
          foreach( $alerts as $alert ) {
            $subscribers = get_post_meta( $alert, '_search_by', true );
            $email_subscribers = get_post_meta( $alert, '_email_subscriber', true );
            if( ! empty( $subscribers ) ) {
                foreach( $subscribers as $subscriber ) {
                    array_push( $all_subscribers, $subscriber );
                }
            }
            if( ! empty( $email_subscribers ) ) {
                foreach( $email_subscribers as $subscriber ) {
                    array_push( $all_email_subscribers, $subscriber );
                }
            }

          }

        if( ! empty( $all_subscribers ) ) {
            foreach( array_unique( $all_subscribers ) as $subscriber ) {
                $email =  get_the_author_meta( 'user_email', $subscriber );
                $this->email( $email, $post );
                }
          }

        if( ! empty( $all_email_subscribers ) ) {
            foreach( array_unique( $all_email_subscribers ) as $subscriber ) {
                    $this->email( $subscriber, $post );
                }
          }
    
          
    }

    public function email( $to, $post ) {
        $post_link = get_the_permalink( $post );
        $post_link = sprintf( '<a href="%s" style="color: #1b83fb;">%s</a>', $post_link, $post_link );
        $subject = 'New post available';
        $body = 'Hi there, The post you were searching is just found! Let\'s check this out ' . $post_link ;
        $content = self::email_html( $subject, $body );

        wp_mail( $to, $subject, $content,  $this->get_email_headers() );
    }
    
    /**
		 * Get the email header eg. From: and Reply-to:
		 *
		 * @since 3.1.0
		 * @param array $data [optional] The array of name and the reply to email
		 * @return string It returns the header of the email that contains From: $name and Reply to: $email
		 */
		public function get_email_headers( $data = array() ) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
      $headers .= 'From: abc@gmail.com' . "\r\n";
      return $headers;
		}

     /**
     * Get Mail HTML
     *
     * @param string $subject
     * @param string $message
     * @return string Email row html
     */
    public static function email_html($subject, $message){
      $header = '';
      $footer = '';
    //   $email_header_color = Helper\get_option('emailHeaderColor', '#6551f2');
    //   $allow_email_header = Helper\get_option('enableEmailHeader', true );
    //   $allow_email_footer = Helper\get_option('enableEmailFooter', true );
    //   $author = "<a target='_blank' href='https://exlac.com/'>Exlac</a>";
      $email_header_color = '#6551f2';
      $allow_email_header = true;
      $allow_email_footer = true;
      $author = "<a target='_blank' href='". get_bloginfo( 'url' ) ."'>". get_bloginfo( 'name' ) ."</a>";

      if ( $allow_email_footer ){
          $footer = '<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
          <tr>
              <td valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="100%">
                      <tr>
                          <td colspan="2" valign="middle" id="credit" style="display: flex; justify-content: center; align-items: center">
                              ' . sprintf( wp_kses_post( wpautop( wptexturize( apply_filters( 'search_alert_email_footer_text', '<span style=\'font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; font-weight: 500;\'>Built with <i style="margin: 0 4px; position: relative; top: 2px;"> ❤️ </i> by %s</span>' ) ) ) ), $author ) . '
                          </td>
                      </tr>
                  </table>
              </td>
          </tr>
      </table>';
      }
      if ( $allow_email_header ){
          $header = '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style=\'background-color: '.$email_header_color.'; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 20px 20px 0 0;\'>
                          <tr>
                              <td id="header_wrapper" style="padding: 20px 30px; display: block;">
                                  <h1 style=\'font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 20px; font-weight: 500; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; color: #ffffff;\'>'.$subject.'</h1>
                              </td>
                          </tr>
                      </table>';
  }

      return '<!DOCTYPE html>
  <html lang="en-US">
      <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Directorist</title>
      </head>
      <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="padding: 0;">
          <div id="wrapper" dir="ltr" style="background-color: #f7f7f7; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
              <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                  <tr>
                      <td align="center" valign="top">
                          <div id="template_header_image">
                          </div>
                          <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: #ffffff; border: 1px solid #dedede; box-shadow: 0 20px 50px rgba(0,0,0,.10); border-radius: 20px;">
                              <tr>
                                  <td align="center" valign="top">
                                      <!-- Header -->
                                      '.$header.'
                                      <!-- End Header -->
                                  </td>
                              </tr>
                              <tr>
                                  <td align="center" valign="top">
                                      <!-- Body -->
                                      <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                          <tr>
                                              <td valign="top" id="body_content" style="background-color: #ffffff; border-radius: 20px;">
                                                  <!-- Content -->
                                                  <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                      <tr>
                                                          <td valign="top" style="padding: 50px 30px;">
                                                              <div id="body_content_inner" style=\'color: #636363; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 16px; line-height: 150%; text-align: left;\'>
                                                                  '.$message.'
                                                              </div>
                                                          </td>
                                                      </tr>
                                                  </table>
                                                  <!-- End Content -->
                                              </td>
                                          </tr>
                                      </table>
                                      <!-- End Body -->
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
            
                  <tr>
                      <td align="center" valign="top">
                          <!-- Footer -->
                          '. $footer .'
                          <!-- End Footer -->
                      </td>
                  </tr>
              </table>
          </div>
      </body>
  </html>';
  }
 
}

