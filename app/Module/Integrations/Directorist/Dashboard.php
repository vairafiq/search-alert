<?php
namespace searchAlert\Module\Integrations\Directorist;

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
        ?>
        <div <?php echo apply_filters( 'wallet_dashboard_content_div_attributes', 'class="directorist-tab__pane" id="saved_search"' ); ?>>
		<div class="directorist-favourite-items-wrap">

			<div class="directorist-favourirte-items">

				<?php if ( $query_searched['query'] || $query_searched['category'] ): ?>

					<div class="directorist-dashboard-items-list">
						<?php foreach ( $query_searched['query'] as $item ): ?>

							<div class="directorist-dashboard-items-list__single">

								<div class="directorist-dashboard-items-list__single--info">

									<div class="directorist-listing-content">
										<h4 class="directorist-listing-title"><strong><?php esc_html_e( 'Listing: ', 'search-alert'); ?></strong><?php echo esc_html( $item );?></h4>
									</div>

								</div>

								<div class="directorist-dashboard-items-list__single--action">
								<a href="#" class="searchalert_delete" data-search-query="<?php echo esc_attr( $item ); ?>">
										<span class="directorist-favourite-remove-text"><?php esc_html_e( 'Remove', 'search-alert' ); ?></span>
									</a>
								</div>

							</div>

						<?php endforeach; ?>

						<?php foreach ( $query_searched['category'] as $item ): 
							$term = get_term_by( is_numeric( $item ) ? 'id' : 'slug', $item, ATBDP_CATEGORY );
							$category_name = ! is_wp_error( $term ) ? $term->name : '';
							?>

							<div class="directorist-dashboard-items-list__single">

								<div class="directorist-dashboard-items-list__single--info">

									<div class="directorist-listing-content">
										<h4 class="directorist-listing-title"><strong><?php esc_html_e( 'Category: ', 'search-alert'); ?></strong><?php echo esc_html( $category_name );?></h4>
									</div>

								</div>

								<div class="directorist-dashboard-items-list__single--action>
									<a href="#" class="searchalert_delete" data-search-category="<?php echo esc_attr( $item ); ?>">
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

