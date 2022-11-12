<?php
/**
 * The template for displaying set alert
 *
 *
 * @package searchAlert
 * @since serchAlert 1.0.0
 */

use searchAlert\Base\Helper;

?>

<div class="searchalert search_alert_add_search">

	<input class="search_alert_input" type="text" placeholder="<?php _e('Add new keywore','search-alert'); ?>">
	<input class="search_alert_update" type="hidden">
	<a href="" name="searchalert" class="searchalert_add_form">
		<?php  esc_html_e( 'Set Alert', 'search-alert' ); ?>
	</a>
	
</div>
