// import 'CoreCSS/core-public.scss';
import './../../sass/core-public.scss';

(function ($) {

	var qs = function (a) {
		if (a == '') return {};
		var b = {};
	
		for (var i = 0; i < a.length; ++i) {
		  var p = a[i].split('=', 2);
		  if (p.length == 1) b[p[0]] = '';else b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, ' '));
		}
	
		return b;
	  }(window.location.search.substr(1).split('&'));


	// result pages
	$('body').on('click', '.searchalert_add', function(e){
		e.preventDefault();
		requet( '.searchalert_add' );
	});

	// inline form
	$('body').on('click', '.searchalert_add_form', function(e){
		e.preventDefault();
		var isUpdate = $('.search_alert_update').val();
		var data	 = {
			query: $('.search_alert_input').val(),
			delete: false,
			form: true,
		}

		if( ! data.query ) {
			return;
		}

		if( isUpdate ) {
			
			var updateData	 = {
				query: isUpdate,
				delete: true,
				form: false,
			}
			
			requet( '.searchalert_add_form', 'delete', updateData );

		}

		// console.log( data );
		// console.log( updateData );
		// return;
		requet( '.searchalert_add_form', '', data );
	});

	// delete form dashboard
	$('body').on('click', '.searchalert_delete', function(e){
		e.preventDefault();
		var data	 = {
			query: $(this).data("search-query"),
			delete: $(this).data("searchalert_delete_from_list"),
		}
		requet( '.searchalert_delete', 'delete', data );
	});

	// edit from dashboard
	$('body').on('click', '.searchalert_edit', function(e){
		e.preventDefault();

		$('.search_alert_input').val( $(this).data("search-query") );
		$('.search_alert_update').val( $(this).data("search-query") );
		$( '.searchalert_add_form' ).text( 'Update' );

	});

	// full form
	$('body').on('submit', '#searchalert-form', function(e){
		e.preventDefault();
		var data	 = {
			query: $( '.searchalert_keyword' ).val(),
			email: $( '.searchalert_email' ).val(),
			form: true,
			reload: false,
		}
		requet( '.searchalert_form_submit', '', data );
		$( '.searchalert_keyword' ).val('');
		$( '.searchalert_email' ).val('')
	});




	function requet( selector, task = 'add', data = [] ) {
		var elmText  	= ( task !== 'delete' ) ? searchAlert.deleteText : searchAlert.addText ;

		if( data.form ) {
			elmText = searchAlert.addText;
			$( selector ).text( 'Adding..' );
		}

		var directorist = qs.q ? qs.q : '';
		var geodirectory = qs.s ? qs.s : '';

		var query 		= directorist ? directorist : geodirectory;
		var query 		= query ? query : data.query ? data.query : '';

		var email 		= data.email ? data.email : '';

		var form_data 	= new FormData();

		form_data.append('action', 'update_search_notice');
		form_data.append('search_alert_nonce', searchAlert.nonce);
		form_data.append('task', task);
		form_data.append('query', query);
		form_data.append('email', email);

		$.ajax({
			method: 'POST',
			processData: false,
			contentType: false,
			url: searchAlert.ajaxurl,
			data: form_data,
			success: function success(response) {
				
				if( data.form ) {
					$( selector ).text( 'Saved' );
					setTimeout( function(){
						$( selector ).text( elmText );
						$('.search_alert_input').val('');
					}, 800 );
					if( ! data.reload ) {
						return;
					}
					window.location.reload();
					return;
				}
				
				if( task === 'add' ) {
					$( selector ).removeClass( 'searchalert_add' ).addClass( 'searchalert_delete' ).text( elmText );
				}else{
					if( ! data.delete ) {
						$( selector ).removeClass( 'searchalert_delete' ).addClass( 'searchalert_add' ).text( elmText );
					}else{
					$('#search-alert-item-to-remove-' + response.data ).remove();
					}
				}
			},
			error: function error( response ) {
				console.log( response );
			}
		});
	}
	
})(jQuery);