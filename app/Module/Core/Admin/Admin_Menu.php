<?php

namespace searchAlert\Module\Core\Admin;

use searchAlert\Base\Helper;

class Admin_Menu {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'init', [ $this, 'register_new_post_types' ] );

        add_filter( 'manage_esl_search_alerts_posts_columns', array( $this, 'new_columns' ) );
        add_action( 'manage_esl_search_alerts_posts_custom_column', array( $this, 'columns_content' ), 10, 2 );
        
        add_action( 'manage_posts_extra_tablenav', array( $this, 'add_extra_button' ) );

        add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );

    }

    public function add_extra_button() {
        global $post_type_object;
        if ($post_type_object->name === 'esl_search_alerts') {
            Helper\get_template( 'import' );
        }
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
            'author'   => __('Author', 'directorist'),
            'keyword'   => __('Keyword', 'directorist'),
            'category'   => __('Category', 'directorist'),
            'sent_at' => __('Status', 'directorist'),
            'date'      => __('Date', 'directorist'),
        ];
        return $columns;
    }

    public function columns_content( $column, $post_id ) {

        $keyword_term = get_the_terms( $post_id, 'esl_keyword' );
        $keyword = ! is_wp_error( $keyword_term[0] ) ? $keyword_term[0]->name : '';
        $sent_at = get_post_meta($post_id, '_sent_at', true );
        $category = get_post_meta($post_id, 'sl_category', true );
        $category_term = get_term_by( 'id', $category, ATBDP_CATEGORY );
        $cat_name = ! is_wp_error( $category_term ) && is_object( $category_term ) ? $category_term->name : '';

        $post_date = get_post_time( 'Y-m-d H:i', false, $post_id );
        
        $time = strtotime( $sent_at );
        $time = $sent_at ? date('Y-m-d H:i',$time) : '';
        echo '</select>';
        switch ( $column ) {
            case 'author':
                $args = array(
                    'post_type' => get_post_field( 'post_type' ),
                    'author'    => get_post_field( 'post_author' ),
                );
                printf(
                    '<a href="%1$s" title="%2$s">%3$s</a>',
                    esc_url( add_query_arg( $args, 'edit.php' ) ),
                    /* translators: 1: Author name */
                    sprintf( esc_attr_x( 'Filter by %1$s', 'Author filter link', 'directorist' ), get_the_author() ),
                    get_the_author()
                );
                break;
            case 'keyword' :
                echo esc_html( $keyword );
                break;
            case 'category' :
                echo esc_html( $cat_name );
                break;
            case 'sent_at' :
                
                if( ! $time ) { ?>
                    <span class="directorist_badge dashboard-badge directorist_status_pending">
                        <?php esc_html_e( 'Waiting', 'directorist' ); ?>
                    </span>
                    
                <?php }else{
                    echo '<span class="directorist_badge dashboard-badge directorist_status_published">' . __( 'Sent', 'directorist' ) . '</span>';
                    echo '<br><span>@' . $time . '</span>';
                }

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


        $labels = array(
            'name'              => _x( 'Keywords', 'Keyword general name', 'directorist' ),
            'singular_name'     => _x( 'Keyword', 'Keyword singular name', 'directorist' ),
            'search_items'      => __( 'Search keyword', 'directorist' ),
            'all_items'         => __( 'All Keywords', 'directorist' ),
            'parent_item'       => __( 'Parent keyword', 'directorist' ),
            'parent_item_colon' => __( 'Parent keyword:', 'directorist' ),
            'edit_item'         => __( 'Edit keyword', 'directorist' ),
            'update_item'       => __( 'Update keyword', 'directorist' ),
            'add_new_item'      => __( 'Add New keyword', 'directorist' ),
            'new_item_name'     => __( 'New keyword Name', 'directorist' ),
            'menu_name'         => __( 'Keywords', 'directorist' ),
        );

        $args        = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'public'            => true,
            'show_in_nav_menus' => true,
        );

        register_taxonomy( 'esl_keyword', 'esl_search_alerts', $args );

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
