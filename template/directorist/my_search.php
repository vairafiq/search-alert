<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

use searchAlert\Base\Helper;


if ( ! defined( 'ABSPATH' ) ) exit;
                  
?>

<div class="directorist-user-dashboard-tabcontent" style="margin-top: 0;">
	<div class="directorist-listing-table directorist-table-responsive">

		<table class="directorist-table">

			<thead>
				<tr>

					<th class="directorist-table-listing"><?php esc_html_e( 'Keyword', 'directorist' ); ?></th>
					
					<th class="directorist-table-ex-date"><?php esc_html_e( 'Date', 'directorist' ); ?></th>
																					
					<th class="directorist-table-status"><?php esc_html_e( 'Status', 'directorist' ); ?></th>

				</tr>
			</thead>

			<tbody class="directorist-dashboard-listings-tbody">
				<?php 
				if ( $searches ) {
					
					foreach( $searches as $search ){

						$keyword_term = get_the_terms( $search, 'esl_keyword' );
						$keyword = ! is_wp_error( $keyword_term[0] ) ? $keyword_term[0]->name : '';
						$sent_at = get_post_meta($search, '_sent_at', true );
						$category = get_post_meta($search, 'sl_category', true );
						$category_term = get_term_by( 'id', $category, 'at_biz_dir-category' );
						$cat_name = ! is_wp_error( $category_term ) && is_object( $category_term ) ? $category_term->name : '';

						$post_date = get_post_time( 'Y-m-d H:i', false, $search );
						
						$time = strtotime( $sent_at );
						$time = $sent_at ? date('Y-m-d H:i',$time) : '';
						?>
						<tr class="sl_item_<?php echo $search; ?>" data-id="<?php echo $search; ?>">
											
							<td>
								<div class="directorist-listing-table-listing-info">
				
									<div class="directorist-listing-table-listing-info__content">
				
										<h4 class="directorist-title"><?php echo esc_html( $keyword ); ?></h4>
										
									</div>
				
								</div>
								<?php 
										if( $cat_name ) :
										?>
										<small class="directorist-title"><?php echo esc_html( $cat_name ); ?></small>
										<?php endif; ?>
							</td>
			
				
							<td>
								<?php echo esc_html( $post_date ); ?>
							</td>

							<td>
								<span class="directorist_sharing_<?php echo esc_attr( $search ); ?>">
									<?php
									if( ! $time ) { ?>
										<span class="directorist_badge dashboard-badge directorist_status_pending">
											<?php esc_html_e( 'Waiting', 'directorist' ); ?>
										</span>
										<br>
										<small><a style="color: red;" target="_blank" class="" href="<?php echo esc_url( site_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact Admin', 'directorist' ); ?></a></small>
										
									<?php }else{
										echo '<span class="directorist_badge dashboard-badge directorist_status_published">' . __( 'Sent', 'directorist' ) . '</span>';
										echo '<br><span>@' . $time . '</span>';
									}
									?>
								</span>
							</td>

							<td>
								<div class="directorist-actions">
				
									<a href="" class="directorist_sl_update" data-keyword="<?php echo esc_attr( $keyword ); ?>" data-category="<?php echo ! is_wp_error( $category_term ) ? esc_html( $category_term->term_id ) : ''; ?>" data-id="<?php echo esc_attr( $search ); ?>" class="directorist-link-btn"><?php directorist_icon( 'las la-edit' ); ?></a> |
									<a href="" class="directorist_sl_delete" data-nonce="<?php echo esc_attr( wp_create_nonce( directorist_get_nonce_key() ) ); ?>" data-id="<?php echo esc_attr( $search ); ?>" class="directorist-link-btn"><?php directorist_icon( 'las la-trash' ); ?></a>
				
								</div>
							</td>
											
						</tr>
						<?php
					}
				}
				else {
					?>
					<tr><td colspan="5"><?php esc_html_e( 'No items found', 'directorist' ); ?></td></tr>
					<?php
				}
				?>
			</tbody>

		</table>

		<?php do_action( 'directorist_dashboard_after_loop' ); ?>

		<div class="directorist-dashboard-pagination">
			<?php //echo wp_kses_post( $dashboard->listing_pagination() ); ?>
		</div>

	</div>
</div>

