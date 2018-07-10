/*
| ----------------------------------------------------------------------------------
| TABLE OF CONTENT
| ----------------------------------------------------------------------------------

-Filter accordion
-PRICE RANGE
*/


(function ($) {
$(document).ready(function() {

	"use strict";

	function updateProductGrid(response){
		$('.catalog-portfolio').html($(response).find('.catalog-portfolio').html());
		updateCatNav(response);
		updatePaging(response)
	}

	function updateCatNav(response){
		$('#filter').html($(response).find('#filter').html());
	}

	function updatePaging(response){
		if (typeof($(response).find('.pagination').html()) == 'undefined'){
		    $('.pagination').html("");
	    }else{
	        if (typeof($('.pagination').html()) == 'undefined')
	            $('#shop-catalog-view').after("<nav class='pagination'></nav>");
		    $('.pagination').html($(response).find('.pagination').html());
	    }
	}


	function hideAjaxLoader(){
	    $('.catalog-portfolio').removeClass('ajax-loading');
	}

	function showAjaxLoader(){
	    $('.catalog-portfolio').addClass('ajax-loading');
	}
/*
	$('#jelect-page').on( 'change', function (e) {
		showAjaxLoader();
		e.preventDefault();

		$.ajax({
			type: "POST",
		    url: pixadScript.pluginsUrl + '/pix-auto-deal/includes/functions_ajax.php',
		    data: "autos_per_page="+this.value,
		    success: function( response ){
				alert(response);
		        updateProductGrid(response);

		        //update browser history (IE doesn't support it)
		        if ( !navigator.userAgent.match(/msie/i) ) {
		            window.history.pushState({"pageTitle":response.pageTitle},"", href);
		        }

		        hideAjaxLoader();
		    }

		});
	    console.log( this.value + ' | ' + this.dataset.text );
	});

	$('#jelect-sort').on( 'change', function (e) {
	    console.log( this.value + ' | ' + this.dataset.text );
	});
	*/
});

}(jQuery));
