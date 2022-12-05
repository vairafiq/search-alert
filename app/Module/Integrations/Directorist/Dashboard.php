<?php
namespace searchAlert\Module\Integrations\Directorist;

use AazzTech\DirTheme\Helper as DirThemeHelper;
use \WP_Error;
use searchAlert\Base\Helper;

class Dashboard {

     /**
     * Constuctor
     *
     */
    function __construct() {
		add_action( 'directorist_after_dashboard_navigation', [ $this, 'nav_link' ] );
        add_action( 'directorist_after_dashboard_contents', [ $this, 'nav_content' ] );
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
        
        $user_id    = get_current_user_id();   
		$query_searched   = get_user_meta( $user_id, '_esl_at_biz_dir', true ); 
		$args = [
			'meta_key' => '_search_by',
			'meta_value' => $user_id,
			'meta_compare' => 'LIKE',
			'posts_per_page' => '-1',
		];
		$searches = Helper\get_search( $args );
        ?>
        <div <?php echo esc_attr( apply_filters( 'wallet_dashboard_content_div_attributes', 'class="directorist-tab__pane" id="saved_search"' ) ); ?>>
		<div class="directorist-favourite-items-wrap">

			<div class="directorist-favourirte-items">

				<?php Helper\load_template( 'add-search' )?>

				<?php if ( $searches ): ?>
					<hr>
					<div class="directorist-dashboard-items-list">
						<?php foreach ( $searches as $item ): 
							$keyword = get_post_meta( $item, '_keyword', true );
							?>

							<div class="directorist-dashboard-items-list__single" id="search-alert-item-to-remove-<?php echo esc_attr( $item); ?>">

								<div class="directorist-dashboard-items-list__single--info">

									<div class="directorist-listing-content">
										<h4 class="directorist-listing-title"><?php echo esc_html( $keyword );?></h4>
									</div>

								</div>

								<div class="directorist-dashboard-items-list__single--action">
									<a href="#" class="searchalert_edit" data-searchalert_edit_from_list="1" data-search-query="<?php echo esc_attr( $keyword ); ?>">
										<span class="directorist-favourite-remove-text"><?php esc_html_e( 'Edit', 'search-alert' ); ?></span>
									</a>
									|
									<a href="#" class="searchalert_delete" data-searchalert_delete_from_list="1" data-search-query="<?php echo esc_attr( $keyword ); ?>">
										<span class="directorist-favourite-remove-text"><?php esc_html_e( 'Remove', 'search-alert' ); ?></span>
									</a>
									
								</div>

							</div>

						<?php endforeach; ?>

					</div>

				<?php else: ?>

					<div class="directorist-notfound"><?php esc_html_e( 'Nothing found!', 'search-alert' ); ?></div>

				<?php endif; ?>

			</div>

			</div>
        </div>
        <?php

    }

 
}

