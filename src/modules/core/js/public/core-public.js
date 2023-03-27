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


	function requet( selector, task = 'add', data = [] ) {
		var elmText  	= ( task !== 'delete' ) ? searchAlert.i18.deleteText : searchAlert.i18.addText ;

		if( data.form ) {
			elmText = searchAlert.i18.addText;
			$( selector ).text( 'Adding..' );
		}

		var directorist = qs.q ? qs.q : '';
		var geodirectory = qs.s ? qs.s : '';

		var query 		= directorist ? directorist : geodirectory;
		var query 		= query ? query : data.query ? data.query : '';

		var email 		= data.email ? data.email : '';
		var user 		= data.user ? data.user : '';

		var form_data 	= new FormData();

		form_data.append('action', 'update_search_notice');
		form_data.append('search_alert_nonce', searchAlertf.nonce);
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



	//fresh start

	// result pages
	$('body').on('click', '.searchalert_add', function(e){
		e.preventDefault();

		var nonce = $( this ).data('nonce');

		const data = {
			action: 'directorist_save_search',
			keyword: qs.q ? qs.q : '',
			sl_category: qs.in_cat ? qs.in_cat : '',
			nonce: nonce,
		};

		$.post( searchAlert.ajaxurl, data, function (response) {

			if( ! response.error ) {
				// $( '.searchalert_add' ).html( 'Success! Alert saved for ' ).prop('disabled', true).css('cursor', 'not-allowed');
				$( '.searchalert_add' ).html( response.error ).prop('disabled', true).css('cursor', 'not-allowed');
			}else{
				$( '.searchalert_add' ).html( response );
			}


		});
	});




	$('body').on('submit', '#directorist_save_search', function (e) {
            
        e.preventDefault();
        var form_data = $( this ).serialize();
		$('#directorist-save-search-notice').html('<span class="directorist-alert directorist-alert-info">'+ searchAlert.i18.onRequest +'</span>');

        $.post(
            searchAlert.ajaxurl,
            form_data,
            function (response) {
                if ( response.error ) {
                    $('#directorist-save-search-notice').html('<span class="directorist-alert directorist-alert-danger">' + response.error + '</span>');
                } else {
                    $('#directorist-save-search-notice').html('<span class="directorist-alert directorist-alert-success">' + response.data + '</span>');
					setTimeout(() => {
						$( '#directorist-save-search-notice').html('');
                        // $( '.directorist_campaign_' + campaign_id ).empty().append( '<span class="directorist_badge dashboard-badge directorist_status_published">Sent</span>');
                    }, 1500);
				}
            },
            'json'
        );

    });

	// edit search
	$('body').on('click', '.directorist_sl_update', function (e) {

		e.preventDefault();

		let keyword = $( this ).data( 'keyword' );
		let id = $( this ).data( 'id' );
		let category = $( this ).data( 'category' );

		$( '#sl_category' ).val( category ).select2();
		$( '#keyword' ).val( keyword );
		$( '#search_id' ).val( id );

	});


	$('body').on('click', '.directorist_sl_delete', function (e) {
		e.preventDefault();

		var id = $( this ).data('id');
		var nonce = $( this ).data('nonce');

		const data = {
			action: 'sl_delete_item',
			id: id,
			directorist_nonce: nonce,
		};

		$.post( searchAlert.ajaxurl, data, function (response) {

			if( ! response.error ) {
			   
				$( '.sl_item_' + id ).fadeOut(300);
			}else{
				alert( response.error );
			}

		});

	});





	
})(jQuery);