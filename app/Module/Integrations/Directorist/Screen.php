<?php
namespace searchAlert\Module\Integrations\Directorist;

use \WP_Error;
use searchAlert\Base\Helper;

class Screen {

     /**
     * Constuctor
     *
     */
    function __construct() {
		add_filter( 'directorist_listings_found_text', array( $this, 'directorist_listings_found_text' ) );

    }

    public function directorist_listings_found_text( $text ){
		$template = '';
		if( isset( $_GET['q'] ) || isset( $_GET['in_cat'] ) ) {
		ob_start();
		Helper\load_template( 'search', $text );
		$template = ob_get_clean();
		}
		return $text . $template;
	}

    public function shortcodes() {
		add_shortcode( 'search_alert_google_login_button', array( $this, 'search_alert_login_btn' ) );
	}

	public function search_alert_login_btn(){
		if ( !is_user_logged_in() && Helper\guard() ) {
			$html = '<div class="g_id_signin"
			data-type="standard"
			data-shape="rectangular"
			data-theme="outline"
			data-text="continue_with"
			data-size="large"
			data-logo_alignment="center">
			</div>';
			return $html;
		}
		return '';
	}


    public function search_alert_one_tap_widget() {
		$nonce = wp_create_nonce( 'search-alert-login-widget' );
		if ( !is_user_logged_in() && Helper\guard() ) {
			$emailBody = Helper\get_option('emailBody');
			$attributes = Helper\widget_attributes();
			?>
			<div id="g_id_onload"
				data-client_id="<?php echo esc_attr( $emailBody );?>"
				data-wpnonce="<?php echo esc_attr( $nonce );?>"
				<?php 
				foreach( $attributes as $attr => $value ) { ?>
				data-<?php echo esc_attr( $attr ); ?>="<?php echo esc_attr( $value); ?>"
				<?php } ?>		
			>
			</div>
			<?php
		}
	}

 
}

