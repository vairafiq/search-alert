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


	$('body').on('click', '.searchalert_add', function(e){
		e.preventDefault();
		requet( '.searchalert_add' );
	});

	$('body').on('click', '.searchalert_delete', function(e){
		e.preventDefault();
		var data	 = {
			category: $(this).data("search-category"),
			query: $(this).data("search-query"),
		}
		requet( '.searchalert_delete', 'delete', data );
	});

	


	function requet( selector, task = 'add', data = [] ) {
		var elmText  	= ( task !== 'delete' ) ? searchAlert.deleteText : searchAlert.addText ;
		var directorist = qs.q ? qs.q : '';
		var geodirectory = qs.s ? qs.s : '';
		var query 		= directorist ? directorist : geodirectory;
		var query 		= query ? query : data.query ? data.query : '';
		var category 	= qs.in_cat ? qs.in_cat : data.category ? data.category : '';
		var form_data 	= new FormData();
		form_data.append('action', 'update_search_notice');
		form_data.append('search_alert_nonce', searchAlert.nonce);
		form_data.append('task', task);
		form_data.append('query', query);
		form_data.append('category', category);

		$.ajax({
			method: 'POST',
			processData: false,
			contentType: false,
			url: searchAlert.ajaxurl,
			data: form_data,
			success: function success(response) {
				if( task === 'add' ) {
					$( selector ).removeClass( 'searchalert_add' ).addClass( 'searchalert_delete' ).text( elmText );
				}else{
					$( selector ).removeClass( 'searchalert_delete' ).addClass( 'searchalert_add' ).text( elmText );
				}
				console.log( response );
			},
			error: function error( response ) {
				console.log( response );
			}
		});
	}
	
	

})(jQuery);