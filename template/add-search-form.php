<?php
/**
 * The template for displaying set alert
 *
 *
 * @package searchAlert
 * @since serchAlert 1.0.0
 */

?>

<div id="searchalert-form-container">
  <h3 class="header"><?php echo esc_html( $heading ); ?></h3>
    <form id="searchalert-form">
		<input type="text" class="searchalert_keyword" placeholder="<?php esc_attr_e( 'Keyword', 'searchalert' ); ?>"></input>
		<input type="text" class="searchalert_email" placeholder="<?php esc_attr_e( 'Email', 'searchalert' ); ?>"></input>
		<button class="searchalert_form_submit" type="submit"><?php esc_html_e( 'Set Search Alert', 'searchalert' ); ?></button>
    </form>
</div>
