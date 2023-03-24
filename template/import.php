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

<div class="searchalert search_alert_import">
      <input type="file" accept=".csv" class="searchalert_import_file"></input>
	<input type="submit" name="searchalert_import" id="post-query-submit" class="button searchalert_import" value="<?php esc_html_e( 'Import Subscribers from CSV', 'search-alert' ); ?>">	
</div>

