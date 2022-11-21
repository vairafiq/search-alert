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

<div class="searchalert search_alert_add_subscriber_container">

	<input class="subscriber_email" type="text" placeholder="<?php _e('Add new subscriber','search-alert'); ?>">
	<a href="" name="searchalert" data-keyword="<?php echo esc_attr( $keyword ); ?>" class="search_alert_add_subscriber">
		<?php  esc_html_e( 'Add', 'search-alert' ); ?>
	</a>
	
</div>
