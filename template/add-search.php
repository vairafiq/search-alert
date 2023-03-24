<?php
/**
 * The template for displaying set alert
 *
 *
 * @package searchAlert
 * @since serchAlert 1.0.0
 */

 use searchAlert\Base\Helper as HL;

 $categories = get_terms([
	'taxonomy' => 'at_biz_dir-category',
	'hide_empty' => false
]);

?>


<div class="<?php HL\searchalert_column('lg-4'); ?>">
	<form action="#" id="directorist_save_search" method="post">
		<div class="directorist-user-profile-edit">

			<div class="directorist-card directorist-user-profile-box">

				<div class="directorist-card__header">
					<h4 class="directorist-card__header--title"><?php esc_html_e( 'Add New Keyword', 'search-alert' ); ?></h4>
				</div>

				<div class="directorist-card__body">

					<div class="directorist-user-info-wrap">

						<div class="directorist-form-group">
							<label for="keyword"><?php esc_html_e( 'Keyword', 'search-alert' ); ?></label>
							<input class="directorist-form-element" id="keyword" type="text" name="keyword" placeholder="<?php esc_html_e( 'Best Company', 'search-alert' ); ?>">
						</div>

						<?php if( ! is_user_logged_in() ) : ?>

						<div class="directorist-form-group">
							<label for="email"><?php esc_html_e( 'Email', 'search-alert' ); ?></label>
							<input class="directorist-form-element" id="email" type="text" name="email" placeholder="<?php esc_html_e( 'example@mail.com', 'search-alert' ); ?>">
						</div>

						<?php endif; ?>

						<?php if( class_exists( 'Directorist_Base' ) ) :?>
						<div class="directorist-form-group">
							<label for="sl_category"><?php esc_html_e( 'Category', 'search-alert' ); ?></label>
							<select style="width: 100%; height: 46px" class="directorist-form-element directorist-select" name="sl_category" id="sl_category">
								<option value=""><?php esc_html_e( 'Select Category', 'search-alert' ) ?></option>
								<?php 
								foreach( $categories as $key => $data ) : 
									?>
									<option value="<?php echo esc_attr( $data->term_id ); ?>"><?php echo esc_html( $data->name ); ?></option>
									<?php endforeach;
								?>
							</select>
						</div>
						<?php endif; ?>

						<input type="hidden" name="action" value="directorist_save_search">
						<input type="hidden" name="search_id" id="search_id" value="">
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( HL\get_nonce_key() ); ?>">

						<button type="submit" class="directorist-btn directorist-btn-lg directorist-btn-dark directorist-btn-profile-save"><?php esc_html_e( 'Add New', 'search-alert' ); ?></button>
						<div id="directorist-save-search-notice"></div>
					</div>

				</div>

			</div>

		</div>
	</form>
</div>
