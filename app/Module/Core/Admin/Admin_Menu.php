<?php

namespace searchAlert\Module\Core\Admin;

use searchAlert\Base\Helper;

class Admin_Menu {

    public function __construct() {
        // add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'init', [ $this, 'register_new_post_types' ] );

        add_filter( 'manage_esl_search_alerts_posts_columns', array( $this, 'new_columns' ) );
        add_action( 'manage_esl_search_alerts_posts_custom_column', array( $this, 'columns_content' ), 10, 2 );

        add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );

    }

    public function post_row_actions( $actions, $post ) {
        if( ! $post ) {
            return;
        }
        if( $post->post_type === 'esl_search_alerts' ) {
            unset( $actions['edit'] );
            unset( $actions['view'] );
            unset( $actions['inline hide-if-no-js'] );

            return $actions;
        }

        return $actions;
    }


    public function new_columns() {
        $columns = [
            'cb'        => '<input type="checkbox" />',
            'keyword'   => __('Keyword', 'directorist'),
            'search_by' => __('Subscribed Users', 'directorist'),
            'no_of_search'    => __('Total Seach', 'directorist'),
            'date'      => __('Date', 'directorist'),
        ];
        return $columns;
    }

    public function columns_content( $column, $post_id ) {
        echo '</select>';
        switch ( $column ) {
            case 'keyword' :
                echo esc_html( get_post_meta( $post_id, '_keyword', true ) );
                break;
            case 'search_by' :
                $search_by = get_post_meta( $post_id, '_search_by', true );
                $email_subscriber = get_post_meta( $post_id );
                var_dump($email_subscriber);
                echo ! empty( $search_by ) ? esc_html( count( $search_by ) ) : 0;
                break;
            case 'no_of_search' :
                $total = get_post_meta( $post_id, '_number_of_search', true );
                echo ! empty( $total ) ? esc_html( $total ) : 0;
                break;
            case 'status' :
                $status = get_post_status( $post_id );
                echo esc_attr( ucfirst( $status ) );
                break;
            case 'date' :
                $t           = get_the_time('U');
                $date_format = get_option('date_format');
                echo date_i18n($date_format, $t);
                break;

        }
    }

    /**
     * Registar custom post type for search alert
     * All the alert will be stored here
     */

    public function register_new_post_types() {
        $labels = array(
            'name'               => _x( 'Search Alerts', 'Plural Name of Search Alert', 'search-alert' ),
            'singular_name'      => _x( 'Search Alert', 'Singular Name of Search Alert', 'search-alert' ),
            'menu_name'          => __( 'Search Alerts', 'search-alert' ),
            'name_admin_bar'     => __( 'Search Alert', 'search-alert' ),
            'parent_item_colon'  => __( 'Parent Search Alert:', 'search-alert' ),
            'all_items'          => __( 'All Alerts', 'search-alert' ),
            'add_new_item'       => __( 'Add New alert', 'search-alert' ),
            'add_new'            => __( 'Add New alert', 'search-alert' ),
            'new_item'           => __( 'New alert', 'search-alert' ),
            'edit_item'          => __( 'Edit alert', 'search-alert' ),
            'update_item'        => __( 'Update alert', 'search-alert' ),
            'view_item'          => __( 'View alert', 'search-alert' ),
            'search_items'       => __( 'Search alert', 'search-alert' ),
            'not_found'          => __( 'No Alerts found', 'search-alert' ),
            'not_found_in_trash' => __( 'Not Alerts found in Trash', 'search-alert' ),
        );

        $args = array(
            'label'               => __( 'Search Alert', 'search-alert' ),
            'description'         => __( 'Search Alerts', 'search-alert' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'author' ),
            'show_in_rest'         => true,
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => current_user_can( 'manage_options' ) ? true : false, // show the menu only to the admin
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-bell',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'map_meta_cap'        => true, // set this true, otherwise, even admin will not be able to edit this post. WordPress will map cap from edit_post to edit_at_biz_dir etc,
            'menu_position'       => 5,
            'capabilities' => array(
                'create_posts'   => 'do_not_allow',
            ),
        );
        register_post_type( 'esl_search_alerts', $args );
    }
    public function admin_menu() { 
        add_submenu_page( 'edit.php?post_type=esl_search_alerts', __( 'Settings', 'search-alert' ), __( 'Settings', 'search-alert' ), 'manage_options', 'esl-settings', [$this, 'search_alert_config'] );
    }

    public function search_alert_config() {
        Helper\get_the_view( 'admin-ui/settings' );
    }

    public function pro() {
        Helper\get_the_view( 'admin-ui/integrations' );
    }

}
