jQuery(document).ready(function($) 
{
	/**
	 * @param state - (object) current object { name_of_param : value }
	 * @param value - (string) part of url like: &name_of_param=value
	 * @param title - (string) title
	 */
	function pix_change_url(state, title ){
		title = title || '';
		var data = {
            action: 'process_reservation',
            nonce: pixadAjax.nonce
        };
		var currentState = history.state == null ? {} : history.state;
		var url_str = '';

        $.extend( currentState, state );
        $.each( currentState, function( key, val ) {
            if(val != '')
				url_str = url_str + "&" + key + "=" + val;
		});
		url_str = url_str.replace('&','?');
        history.pushState(currentState, title, url_str);

		$.extend( data, currentState );

		return data;

	}

	function goToByScroll(id){
	    $('html,body').animate({
	        scrollTop: $('#pix-sorting').offset().top - 110
	    }, 700);
	}

	function showAjaxLoader(){
		//goToByScroll();
		$('.pix-ajax-loader').addClass('ajax-loading');
	}

	function hideAjaxLoader(){
		$('.pix-ajax-loader').removeClass('ajax-loading');
		pageClick();
	}

    $('#jelect-page').on( 'change', function (e) {
        showAjaxLoader();
        e.preventDefault();

		var state = { 'per_page' : this.value }
		var data = pix_change_url(state, 'per page');

        $.get( pixadAjax.url, data, function( response ){
                //console.log('AJAX response : ',response.data);
                $('#pixad-listing').html(response.data);
                hideAjaxLoader();
        });
    });

    $('#jelect-sort').on( 'change', function (e) {
        showAjaxLoader();
        e.preventDefault();

		var state = { 'order' : this.value }
		var data = pix_change_url(state, 'order');

        $.get( pixadAjax.url, data, function( response ){
                //console.log('AJAX response : ',response.data);
                $('#pixad-listing').html(response.data);
                hideAjaxLoader();
        });
    });

	function pageClick() {
		$('.pixad-paging li a').click(function (e) {
			e.preventDefault();
			showAjaxLoader();

			var state = {'paged': $(this).data('page')}
			var data = pix_change_url(state, 'paged');
			//console.log(data);

			$.get(pixadAjax.url, data, function (response) {
				//console.log('AJAX response : ',response.data);
				$('#pixad-listing').html(response.data);
				hideAjaxLoader();
			});
		});
	}

	$("input[name^='pixad-']").on( 'change', function (e) {
        showAjaxLoader();
        e.preventDefault();
	    var args = {};
	    var args_str = '';
	    var type = $(this).data('type'); // check - checkbox, number - input with int, text - input with string, jelect - select
	    var field = $(this).data('field');
		//console.log('type : ',type);
		//console.log('field : ',field);
        if(type == 'check'){
			$("[name^='pixad-"+field+"']").each(function(key,val) {
				if( $(this).prop( "checked" ) ){
					args_str = args_str + ',' + $(this).val();
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			}
			else
				args[field] = '';
        }
        if(type == 'number'){
			$("[name^='pixad-"+field+"']").each(function(key,val) {
				if( Number($(this).val())>=0 ){
					args_str = args_str + ',' + Number($(this).val());
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			}
			else
				args[field] = '';
        }
        if(type == 'jelect'){
	        args_str = $('#pixad-'+field).val();
			if(args_str.length > 0) {
				args[field] = args_str;
			}
			else
				args[field] = '';
        }
		//console.log('args data : ',args);
		var data = pix_change_url(args, 'filter');
		console.log('AJAX data : ',data);
        $.get( pixadAjax.url, data, function( response ){
            console.log('AJAX response : ',response.data);
            $('#pixad-listing').html(response.data);
            hideAjaxLoader();
        });

    });

    $('#pixad-filter').on( 'click', function (e) {
        showAjaxLoader();
        //return 1;
        e.preventDefault();
	    var args = {};
	    var filter = $('.pixad-filter');
	    $('.pixad-filter').each(function(i,elem) {
	        var args_str = '';
	        var type = $(this).data('type'); // check - checkbox, number - input with int, text - input with string, jelect - select
	        var field = $(this).data('field');
	        if(type == 'check'){
	            $(this).find("[name*='pixad-']").each(function(key,val) {
					if( $(this).prop( "checked" ) ){
						args_str = args_str + ',' + $(this).val();
					}
				});
				if(args_str.length > 0) {
					args_str = args_str.replace(',', '');
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }
	        if(type == 'number'){
	            $(this).find("[name*='pixad-']").each(function(key,val) {
					if( Number($(this).val())>=0 ){
						args_str = args_str + ',' + Number($(this).val());
					}
				});
				if(args_str.length > 0) {
					args_str = args_str.replace(',', '');
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }
	        if(type == 'jelect'){
		        args_str = $('#pixad-'+field).val();
				if(args_str.length > 0) {
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }
		});

		var data = pix_change_url(args, 'filter');
		//onsole.log('AJAX data : ',data);
        $.get( pixadAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            $('#pixad-listing').html(response.data);
            hideAjaxLoader();
        });

    });

    $('#pixad-reset-button').on('click', function (e) {
        e.preventDefault();
		window.location.href = $(this).data('href');
    });

});