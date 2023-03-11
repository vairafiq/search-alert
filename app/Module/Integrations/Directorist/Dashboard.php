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

		$categories = get_terms([
			'taxonomy' => ATBDP_CATEGORY,
			'hide_empty' => false
		]);

		$searches = Helper\get_user_search();
        ?>
        <div class="directorist-tab__pane" id="saved_search">
			
			<div class="<?php Base_Helper::directorist_row(); ?>">

				<div class="<?php Base_Helper::directorist_column('lg-8'); ?>">
					<?php Helper\load_template( 'directorist/my_search', [ 'searches' => $searches ] ); ?>
				</div>
				<?php Helper\load_template( 'add-search', [ 'categories' => $categories ] ); ?>
			</div>
			</div>
		</div>
        <?php

    }

 
}

