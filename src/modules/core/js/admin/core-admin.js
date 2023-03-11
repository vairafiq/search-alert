import 'CoreCSS/core-admin.scss';

(function ($) {

	
	// full form
	$('body').on('click', '.search_alert_add_subscriber', function(e){
		e.preventDefault();
		var data	 = {
			query: $( this ).data( 'keyword' ),
			email: $( this ).siblings( '.subscriber_email' ).val(),
			form: true,
			reload: true,
		}
		requet( $( this ), '', data );
	});

	$('body').on('click', '.helpgent_unsubscribe', function(e){
		e.preventDefault();
		var parentElement = $(this).parent();
		var data	 = {
			query: parentElement.data( 'keyword' ),
			email: parentElement.data( 'email' ),
			user: parentElement.data( 'user' ),
			form: false,
			delete: true,

		}

		$( this ).find( '.helpgent_remove_icon' ).removeClass( 'remove-tag-icon' ).text('...');

		// helpgent_remove_icon
		
		requet( parentElement, 'delete', data );
	});

	// import subscriber
	$('body').on('click', '.searchalert_import', function(e){
		e.preventDefault();
		var form_data 	= new FormData();
		// var file = $('.searchalert_import_file').val();
		var file = $('.searchalert_import_file')[0].files[0];

		if( ! file ) {
			alert( 'File is required');
			return;
		}
		// console.log( file );
		form_data.append('action', 'import_subscribers');
		form_data.append('search_alert_nonce', searchAlert.nonce);
		form_data.append('csv_file', file);

		$( this ).val( 'Importing in progress...' );

		$.ajax({
			method: 'POST',
			processData: false,
			contentType: false,
			url: searchAlert.ajaxurl,
			data: form_data,
			success: function success(response) {
				$( this ).val( 'Successfully imported. Redirecting...' );
				window.location.reload();
			},
			error: function error( response ) {
				console.log( response );
			}
		});

	});





	function requet( selector, task = 'add', data = [] ) {

		var elmText  	= ( task !== 'delete' ) ? searchAlert.deleteText : searchAlert.addText ;

		if( data.form ) {
			elmText = searchAlert.addText;
			selector.text( 'Adding..' );
		}

		var query 		= data.query ? data.query : '';
		var email 		= data.email ? data.email : '';
		var user 		= data.user ? data.user : '';

		var form_data 	= new FormData();

		form_data.append('action', 'update_search_notice');
		form_data.append('search_alert_nonce', searchAlert.nonce);
		form_data.append('task', task);
		form_data.append('query', query);
		form_data.append('email', email);
		form_data.append('user', user);

		$.ajax({
			method: 'POST',
			processData: false,
			contentType: false,
			url: searchAlert.ajaxurl,
			data: form_data,
			success: function success(response) {
				
				if( data.form ) {
					selector.text( 'Saved' );
					setTimeout( function(){
						selector.text( elmText );
						$('.search_alert_input').val('');
					}, 800 );
					if( ! data.reload ) {
						return;
					}
					window.location.reload();
					return;
				}
				
				if( task === 'add' ) {
					selector.removeClass( 'searchalert_add' ).addClass( 'searchalert_delete' ).text( elmText );
				}else{
					if( ! data.delete ) {
						selector.removeClass( 'searchalert_delete' ).addClass( 'searchalert_add' ).text( elmText );
					}else{
					$('#search-alert-item-to-remove-' + response.data ).remove();
					selector.remove();
					}
				}
			},
			error: function error( response ) {
				console.log( response );
			}
		});
	}
	
})(jQuery);