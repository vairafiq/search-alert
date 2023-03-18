<?php
/**
 * The template for displaying set alert
 *
 *
 * @package searchAlert
 * @since serchAlert 1.0.0
 */
use searchAlert\Base\Helper as HL;

?>
<small class="searchalert_wrapper">
	<a href="" data-nonce="<?php echo wp_create_nonce( HL\get_nonce_key() ); ?>" name="searchalert" class="searchalert_add">
		<?php  esc_html_e( 'Set Search Alert', 'search-alert' ); ?>
	</a>
</small>