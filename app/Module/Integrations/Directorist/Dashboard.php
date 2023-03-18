<?php
namespace searchAlert\Module\Integrations\Directorist;

use AazzTech\DirTheme\Helper as DirThemeHelper;
use \WP_Error;
use searchAlert\Base\Helper;
use \Directorist\Helper as Base_Helper;

class Dashboard {

     /**
     * Constuctor
     *
     */
    function __construct() {
		add_action( 'directorist_after_dashboard_navigation', [ $this, 'nav_link' ] );
        add_action( 'directorist_after_dashboard_contents', [ $this, 'nav_content' ] );

		add_action( 'wp_ajax_sl_delete_item', [ $this, 'delete_item' ] );

    }


	public function delete_item() {

		$data = [];
		if ( ! directorist_verify_nonce() ) {
			$data['error']   = __( 'Something is wrong! Please refresh and retry.', 'search-alert' );

			wp_send_json( $data, 200 );
        }

		$id = ! empty( $_POST['id'] ) ? directorist_clean( wp_unslash( $_POST['id'] ) ) : '';
		
		if ( ! $id ) {
			$data['error']   = __( 'Post ID is missing', 'search-alert' );

			wp_send_json( $data, 200 );
        }

		wp_delete_post( $id, true );

		$data['success']   = __( 'Successfully deleted!', 'search-alert' );

		wp_send_json( $data, 200 );
	}


    public function nav_link() { ?>
        <li class="directorist-tab__nav__item">
			<a href="" class="search-alert-nav-link directorist-tab__nav__link" id="saved_search_tab" target="saved_search">
				<span class="directorist_menuItem-text">
					<span class="directorist_menuItem-icon"><?php directorist_icon( 'las la-search' ); ?></span>
					 <?php esc_html_e( 'Saved Search', 'search-alert' ); ?> 
				</span>
			</a>
		</li>
    <?php }

    public function nav_content() {

		$searches = Helper\get_user_search();
        ?>
        <div class="directorist-tab__pane" id="saved_search">
			
			<div class="<?php Base_Helper::directorist_row(); ?>">

				<div class="<?php Base_Helper::directorist_column('lg-8'); ?>">
					<?php Helper\load_template( 'directorist/my_search', [ 'searches' => $searches ] ); ?>
				</div>
				<?php Helper\load_template( 'add-search' ); ?>
			</div>
			</div>
		</div>
        <?php

    }

 
}

