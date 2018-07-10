/*global wc_enhanced_select_params */
jQuery( function( $ ) {
    
    
  
       $(".pix-theme-icon_nav").each(function (i) {
        
 var IDEl =  $(this).attr('id')

 $(this).after("<div class='vc_preview_info';><i class='fa fa-info-circle' aria-hidden='true'></i></div><div class='vc_preview_obv';  ><img src='../wp-content/plugins/pixtheme-custom/images/" + IDEl + ".jpg'></div>");

});
    

	function getEnhancedSelectFormatString() {
		var formatString = {
			formatMatches: function( matches ) {
				if ( 1 === matches ) {
					return wc_enhanced_select_params.i18n_matches_1;
				}

				return wc_enhanced_select_params.i18n_matches_n.replace( '%qty%', matches );
			},
			formatNoMatches: function() {
				return wc_enhanced_select_params.i18n_no_matches;
			},
			formatAjaxError: function( jqXHR, textStatus, errorThrown ) {
				return wc_enhanced_select_params.i18n_ajax_error;
			},
			formatInputTooShort: function( input, min ) {
				var number = min - input.length;

				if ( 1 === number ) {
					return wc_enhanced_select_params.i18n_input_too_short_1;
				}

				return wc_enhanced_select_params.i18n_input_too_short_n.replace( '%qty%', number );
			},
			formatInputTooLong: function( input, max ) {
				var number = input.length - max;

				if ( 1 === number ) {
					return wc_enhanced_select_params.i18n_input_too_long_1;
				}

				return wc_enhanced_select_params.i18n_input_too_long_n.replace( '%qty%', number );
			},
			formatSelectionTooBig: function( limit ) {
				if ( 1 === limit ) {
					return wc_enhanced_select_params.i18n_selection_too_long_1;
				}

				return wc_enhanced_select_params.i18n_selection_too_long_n.replace( '%qty%', limit );
			},
			formatLoadMore: function( pageNumber ) {
				return wc_enhanced_select_params.i18n_load_more;
			},
			formatSearching: function() {
				return wc_enhanced_select_params.i18n_searching;
			}
		};

		return formatString;
	}

	$( 'body' )

		.on( 'wc_enhanced_select-init2', function() {



			// Regular select boxes
			$( ':input.wc_enhanced_select, :input.chosen_select' ).filter( ':not(.enhanced)' ).each( function() {
				var select2_args = $.extend({
					minimumResultsForSearch: 10,
					allowClear:  $( this ).data( 'allow_clear' ) ? true : false,
					placeholder: $( this ).data( 'placeholder' )
				}, getEnhancedSelectFormatString() );

				$( this ).select2( select2_args ).addClass( 'enhanced' );
			});

			$( ':input.wc_enhanced_select-nostd, :input.chosen_select_nostd' ).filter( ':not(.enhanced)' ).each( function() {
				var select2_args = $.extend({
					minimumResultsForSearch: 10,
					allowClear:  true,
					placeholder: $( this ).data( 'placeholder' )
				}, getEnhancedSelectFormatString() );

				$( this ).select2( select2_args ).addClass( 'enhanced' );
			});

			// Ajax product search box
			$( ':input.wc_product_search' ).filter( ':not(.enhanced)' ).each( function() {
				var select2_args = {
					allowClear:  $( this ).data( 'allow_clear' ) ? true : false,
					placeholder: $( this ).data( 'placeholder' ),
					minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '3',
					escapeMarkup: function( m ) {
						return m;
					},
					ajax: {
				        url:         wc_enhanced_select_params.ajax_url,
				        dataType:    'json',
				        quietMillis: 250,
				        data: function( term, page ) {
				            return {
								term:     term,
								action:   $( this ).data( 'action' ) || 'woocommerce_json_search_products_and_variations',
								security: wc_enhanced_select_params.search_products_nonce
				            };
				        },
				        results: function( data, page ) {
				        	var terms = [];
					        if ( data ) {
								$.each( data, function( id, text ) {
									terms.push( { id: id, text: text } );
								});
							}
				            return { results: terms };
				        },
				        cache: true
				    }
				};

				if ( $( this ).data( 'multiple' ) === true ) {
					select2_args.multiple = true;
					select2_args.initSelection = function( element, callback ) {
						var data     = $.parseJSON( element.attr( 'data-selected' ) );
						var selected = [];

						$( element.val().split( "," ) ).each( function( i, val ) {
							selected.push( { id: val, text: data[ val ] } );
						});
						return callback( selected );
					};
					select2_args.formatSelection = function( data ) {
						return '<div class="selected-option" data-id="' + data.id + '">' + data.text + '</div>';
					};
				} else {
					select2_args.multiple = false;
					select2_args.initSelection = function( element, callback ) {
						var data = {id: element.val(), text: element.attr( 'data-selected' )};
						return callback( data );
					};
				}

				select2_args = $.extend( select2_args, getEnhancedSelectFormatString() );

				$( this ).select2( select2_args ).addClass( 'enhanced' );
			});

			// Ajax customer search boxes
			$( ':input.wc-customer-search' ).filter( ':not(.enhanced)' ).each( function() {
				var select2_args = {
					allowClear:  $( this ).data( 'allow_clear' ) ? true : false,
					placeholder: $( this ).data( 'placeholder' ),
					minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '3',
					escapeMarkup: function( m ) {
						return m;
					},
					ajax: {
				        url:         wc_enhanced_select_params.ajax_url,
				        dataType:    'json',
				        quietMillis: 250,
				        data: function( term, page ) {
				            return {
								term:     term,
								action:   'woocommerce_json_search_customers',
								security: wc_enhanced_select_params.search_customers_nonce
				            };
				        },
				        results: function( data, page ) {
				        	var terms = [];
					        if ( data ) {
								$.each( data, function( id, text ) {
									terms.push( { id: id, text: text } );
								});
							}
				            return { results: terms };
				        },
				        cache: true
				    }
				};
				if ( $( this ).data( 'multiple' ) === true ) {
					select2_args.multiple = true;
					select2_args.initSelection = function( element, callback ) {
						var data     = $.parseJSON( element.attr( 'data-selected' ) );
						var selected = [];

						$( element.val().split( ',' ) ).each( function( i, val ) {
							selected.push( { id: val, text: data[ val ] } );
						});
						return callback( selected );
					};
					select2_args.formatSelection = function( data ) {
						return '<div class="selected-option" data-id="' + data.id + '">' + data.text + '</div>';
					};
				} else {
					select2_args.multiple = false;
					select2_args.initSelection = function( element, callback ) {
						var data = {id: element.val(), text: element.attr( 'data-selected' )};
						return callback( data );
					};
				}

				select2_args = $.extend( select2_args, getEnhancedSelectFormatString() );

				$( this ).select2( select2_args ).addClass( 'enhanced' );
			});
		})

		// WooCommerce Backbone Modal
		.on( 'wc_backbone_modal_before_remove', function() {
			$( ':input.wc_enhanced_select, :input.wc-product-search, :input.wc-customer-search' ).select2( 'close' );
		})

		.trigger( 'wc_enhanced_select-init' );

});

jQuery(function($){

	// post type toogle
	var postType = $('#post-formats-select').find('input:checked').val();
	if( postType == 0 ){
		$('#post_format .rwmb-meta-box .rwmb-field').not(':eq(0)').hide();
	}
	else{
		$('#post_format .rwmb-meta-box .rwmb-field').hide();
		$( 'label[for*="' + postType + '"]' ).closest('.rwmb-field').siblings('.rwmb-field').hide();
		$( 'label[for*="' + postType + '"]' ).closest('.rwmb-field').fadeIn();
	}
	$('#post-formats-select').find('input').change( function() {

		var postType = $(this).val();

		if ( postType == 0 ) {
			$('#post_format .rwmb-meta-box .rwmb-field').not(':eq(0)').hide();
			$('#post_format .rwmb-meta-box .rwmb-field').eq(0).show();
		}
		else{
			$( 'label[for*="' + postType + '"]' ).closest('.rwmb-field').siblings('.rwmb-field').hide();
			$( 'label[for*="' + postType + '"]' ).closest('.rwmb-field').fadeIn();
		}

	});

});

jQuery(document).ready(function($){

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
    var img_input;

    // Runs when the image button is clicked.
    $('.pix-image-upload').click(function(e){

	    img_input = $('#'+$(this).data('input'));
        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
	        $(img_input).val(media_attachment.url);
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });
});

