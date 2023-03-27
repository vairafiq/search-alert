<?php

namespace searchAlert\Module\Integrations;

use searchAlert\Base\Helper;
use WP_Query;

class Send_Alert
{

    /**
     * Constuctor
     *
     */
    function __construct()
    {
        add_action('transition_post_status', array($this, 'new_post_alert_lookup'), 10, 3);
        // add_action( 'init', array( $this, 'testing' ) );

    }

    public function testing()
    {

        // var_dump( has_term( $category, 'at_biz_dir-category', $post_id ) );
        // die;


        $keywords = explode(' ', 'this is rafiq');
        // $keywords = explode( ' ', 'bmw for sell!!');


        $args = [
            'post_type' => 'esl_search_alerts',
            'post_status' => 'publish',
            'fields' => 'ids',
            'meta_key' => '_sent_at',
            'meta_compare' => 'NOT EXISTS',
            'orderby' => 'ASC',
            'posts_per_page'=> -1
        ];

        if (!empty($keywords)) {
            $args['tax_query'] = [
               [
                'taxonomy' => 'esl_keyword',
                'field'    => 'name',
                'terms'    => $keywords,
                'include_children' => false,
               ]
            ];
        }

        $alerts = new WP_Query($args);
        $alerts = $alerts->posts;
        $all_email_subscribers = [];

        foreach ($alerts as $alert) {
            $author_id = get_post_field( 'post_author', $alert );
            $user = get_user_by( 'id', $author_id );
            $user_email = ! is_wp_error( $user ) ? $user->user_email : '';
            array_push($all_email_subscribers, $user_email);
        }

          e_var_dump([
            'alerts' => $alerts,
            // 'options' => Helper\get_options(),
            // 'email_subscribers' => $all_email_subscribers,
            'keywords' => $keywords,
            // 'post' => $alert,
          ]);
          die;
    }

    public function my_custom_search_template($template)
    {
        global $wp_query;
        if (!$wp_query->is_search) {
            return $template;
        }

        Helper\get_template('search');
    }

    public function new_post_alert_lookup($new_status, $old_status, $post)
    {

        if (!$post) {
            return;
        }

        if( 'publish' !== $new_status ) {
            return;
        }

        if (!Helper\get_option('enable_search_alert', true)) {
            return;
        }

        if (!Helper\post_type_allow(get_post_type($post))) {
            return;
        }

        $post_id = $post->ID;

        $is_admin = ( isset( $_REQUEST['_locale'] ) || is_admin() ) ? true : false;

        // var_dump([
        //     '1st' => !Helper\get_option('enable_search_alert', true),
        //     '2nd' => !Helper\post_type_allow(get_post_type($post)),
        //     'new_status' => $new_status,
        //     'old_status' => $old_status,
        //     // 'post' => $post,//auto-draft
        //     'is_admin' => $is_admin,
        //     'boll' =>  $is_admin && ('publish' !== $old_status),
        // ]);
        // die;

        if ( $is_admin && ('publish' !== $old_status) ) {
            $this->send_notice($post, $post_id);
            return;
        }
        if ( !$is_admin && ('private' === $old_status) ) {
            $this->send_notice($post, $post_id);
        }
    }

    public function send_notice($post, $post_id)
    {

        $keywords = explode(' ', get_the_title($post_id));
        
        $args = [
            'post_type' => 'esl_search_alerts',
            'post_status' => 'publish',
            'fields' => 'ids',
            'orderby' => 'ASC',
            'posts_per_page'=> -1
        ];

        if (!empty($keywords)) {
            $args['tax_query'] = [
               [
                'taxonomy' => 'esl_keyword',
                'field'    => 'name',
                'terms'    => $keywords,
                'include_children' => false,
               ]
            ];
        }

        $alerts = new WP_Query($args);
        $alerts = $alerts->posts;

        foreach ($alerts as $alert) {

            $category = get_post_meta( $alert, 'sl_category', true );

            if( $category && ! has_term( $category, 'at_biz_dir-category', $post_id ) ) {
                continue;
            }

            $author_id = get_post_field( 'post_author', $alert );
            $user = get_user_by( 'id', $author_id );
            $user_email = ! is_wp_error( $user ) ? $user->user_email : '';
            $this->email($user_email, $post, [ 'alert' => $alert ] );

            update_post_meta( $alert, '_sent_at', date( 'Y-m-d H:i' ) );
            
        }
    }

    public function email($to, $post, $data = [] )
    {
        $post_link = get_the_permalink($post);
        $post_link = sprintf('<a href="%s" style="color: #1b83fb;">%s</a>', $post_link, $post_link);
        $subject = Helper\get_option('emailSubject', 'New Post Available for {{KEYWORD}}');
        $body = Helper\get_option('emailBody', 'Hi there, The post you were searching is just found! Let\'s check this out {{POST_LINK}}');

        $subject = self::replace_in_content($subject, $post, $data );
        $body = self::replace_in_content($body, $post, $data );

        $content = self::email_html($subject, $body);

        wp_mail($to, $subject, $content,  $this->get_email_headers());
    }


    public static function replace_in_content($content, $post = null, $args = [])
    {
        $site_name      = get_option('blogname');
        $site_url       = site_url();
        $date_format    = get_option('date_format');
        $time_format    = get_option('time_format');
        $current_time   = current_time('timestamp');
        $post_link      = get_the_permalink($post);
        $keyword        = '';

        if( ! empty( $args['alert'] ) ) {
            $keyword_term   = get_the_terms( $args['alert'], 'esl_keyword' );
            $keyword        = ! is_wp_error( $keyword_term[0] ) ? $keyword_term[0]->name : '';
        }

        $find_replace = array(

            '{{SITE_NAME}}'         => $site_name,
            '{{SITE_LINK}}'         => sprintf('<a href="%s" style="color: #1b83fb;">%s</a>', $site_url, $site_name),
            '{{SITE_URL}}'          => sprintf('<a href="%s" style="color: #1b83fb;">%s</a>', $site_url, $site_url),
            '{{TODAY}}'             => date_i18n($date_format, $current_time),
            '{{NOW}}'               => date_i18n($date_format . ' ' . $time_format, $current_time),
            '{{POST_LINK}}'         => sprintf('<a href="%s" style="color: #1b83fb;">%s</a>', $post_link, $post_link),
            '{{KEYWORD}}'           => ucfirst( $keyword ),
        );

        $c = nl2br(strtr($content, $find_replace));
        // we do not want to use br for line break in the order details markup. so we removed that from bulk replacement.

        return $c;
    }

    /**
     * Get the email header eg. From: and Reply-to:
     *
     * @since 3.1.0
     * @param array $data [optional] The array of name and the reply to email
     * @return string It returns the header of the email that contains From: $name and Reply to: $email
     */
    public function get_email_headers($data = array())
    {
        $email    = get_option( 'admin_email' );
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n <{$email}>\r\nReply-To: {$email}\r\n";

        return $headers;
    }

    /**
     * Get Mail HTML
     *
     * @param string $subject
     * @param string $message
     * @return string Email row html
     */
    public static function email_html($subject, $message)
    {
        $header = '';
        $footer = '';
        //   $email_header_color = Helper\get_option('emailHeaderColor', '#6551f2');
        //   $allow_email_header = Helper\get_option('enableEmailHeader', true );
        //   $allow_email_footer = Helper\get_option('enableEmailFooter', true );
        //   $author = "<a target='_blank' href='https://exlac.com/'>Exlac</a>";
        $email_header_color = '#6551f2';
        $allow_email_header = true;
        $allow_email_footer = Helper\get_option('email_footer', true);
        $author = "<a target='_blank' href='" . get_bloginfo('url') . "'>" . get_bloginfo('name') . "</a>";

        if ($allow_email_footer) {
            $footer = '<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
          <tr>
              <td valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="100%">
                      <tr>
                          <td colspan="2" valign="middle" id="credit" style="display: flex; justify-content: center; align-items: center">
                              ' . sprintf(wp_kses_post(wpautop(wptexturize(apply_filters('search_alert_email_footer_text', '<span style=\'font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; font-weight: 500;\'>Built with <i style="margin: 0 4px; position: relative; top: 2px;"> ❤️ </i> by %s</span>')))), $author) . '
                          </td>
                      </tr>
                  </table>
              </td>
          </tr>
      </table>';
        }
        if ($allow_email_header) {
            $header = '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style=\'background-color: ' . $email_header_color . '; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 20px 20px 0 0;\'>
                          <tr>
                              <td id="header_wrapper" style="padding: 20px 30px; display: block;">
                                  <h1 style=\'font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 20px; font-weight: 500; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; color: #ffffff;\'>' . $subject . '</h1>
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
                                                                    <div id="body_content_inner" style=\'color: #636363; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 16px; line-height: 0%; text-align: left;\'>
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
