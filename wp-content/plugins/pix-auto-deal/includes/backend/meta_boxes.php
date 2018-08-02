<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Auto Classifieds Meta Boxes
 *
 * $id
 * $title
 * $callback
 * $post_type
 * $context
 * $priority
 * $callback_args 
 *
 * @since 0.1
 */

function add_pixad_auto_meta_boxes() {
	add_meta_box( 'pixad_auto_details', esc_html__( 'Auto Details', 'pixautodeal' ), 'pixad_auto_details', 'pixad-autos', 'normal', 'high' ); // Auto details metabox
	add_meta_box( 'pixad_auto_gallery', esc_html__( 'Gallery', 'pixautodeal' ), 'pixad_auto_gallery', 'pixad-autos', 'side', 'low' );
	add_meta_box( 'pixad_auto_feature', esc_html__( 'Auto Label', 'pixautodeal'), 'pixad_auto_feature', 'pixad-autos', 'side', 'low');
	add_meta_box( 'pixad_auto_sidebar', esc_html__( 'Specs Sidebar Layout', 'pixautodeal'), 'pixad_auto_sidebar', 'pixad-autos', 'side', 'low');
	add_meta_box( 'pixad_auto_videos', esc_html__( 'Auto Video', 'pixautodeal' ), 'pixad_auto_videos', 'pixad-autos', 'side', 'low' );
	add_meta_box( 'pixad_auto_contacts', esc_html__( 'Contact Info', 'pixautodeal' ), 'pixad_auto_contacts', 'pixad-autos', 'normal', 'low' );
	add_meta_box( 'pixad_auto_banner_content', esc_html__( 'Banner', 'pixautodeal' ), 'pixad_auto_banner_content', 'pixad-autos', 'normal', 'low' );

}
// The function that outputs the metabox html
function pixad_auto_gallery() {
    global $post;
    // Here we get the current images ids of the gallery
    $values = get_post_custom($post->ID);

    if(isset($values['pixad_auto_gallery'])) {
        // The json decode and base64 decode return an array of image ids
        $ids = json_decode(base64_decode($values['pixad_auto_gallery'][0]));
    }
    else {
        $ids = array();
    }
    wp_nonce_field('pixad_meta_box_nonce', 'meta_box_nonce'); // Security
    // Implode the array to a comma separated list
    $cs_ids = is_array($ids) ? implode(",", $ids) : '';
    // We display the gallery
    $html  = do_shortcode('[gallery ids="'.$cs_ids.'"]');
    // Here we store the image ids which are used when saving the auto
    $html .= '<input id="pixad_auto_gallery_ids" type="hidden" name="pixad_auto_gallery_ids" value="'.$cs_ids. '" />';
    // A button which we will bind to later on in JavaScript
    $html .= '<input id="manage_gallery" title="Manage gallery" type="button" value="Manage gallery" />';
    $html .= '<input id="clear_gallery" title="Clear gallery" type="button" value="Clear gallery" />';
    echo $html;
}

// The function that outputs the metabox html
function pixad_auto_feature() {
    global $post;

    $sel_l = get_post_meta( get_the_ID(), 'pixad_auto_featured', true );
	?>
		<select class="rwmb-select" name="pixad_auto_featured" />
			<option value="" <?php selected( $sel_l, '', true ); ?> ><?php esc_html_e( 'Without Label', 'pixautodeal') ?></option>
    	    <option value="Featured" <?php selected( $sel_l, 'Featured', true ); ?> ><?php esc_html_e( 'Featured', 'pixautodeal') ?></option>
            <option value="Sold" <?php selected( $sel_l, 'Sold', true ); ?> ><?php esc_html_e( 'Sold', 'pixautodeal') ?></option>
        </select>
	<?php
}

// The function that outputs the metabox html
function pixad_auto_sidebar() {
    global $post;

    $sel_l = get_post_meta( get_the_ID(), 'pixad_auto_sidebar_layout', true );
	//print_r($sel_l);
	?>
		<select class="rwmb-select" name="pixad_auto_sidebar_layout" />
    	    <option value="" <?php selected( $sel_l, '', true ); ?> ><?php esc_html_e( 'Right Sidebar', 'pixautodeal') ?></option>
            <option value="left" <?php selected( $sel_l, 'left', true ); ?> ><?php esc_html_e( 'Left Sidebar', 'pixautodeal') ?></option>
        </select>
	<?php
}


function pixad_auto_videos() {
	global $post;
	?>
	<div id="auto_video_container">
		<?php _e('Upload your Video in 3 formats: MP4, OGG and WEBM', 'pixautodeal') ?>
		<ul class="auto_video">
			<?php
				
				$auto_video_code = get_post_meta( $post->ID, '_auto_video_code', true );


				if ( metadata_exists( 'post', $post->ID, '_auto_video_gallery' ) ) {
					$auto_image_gallery = get_post_meta( $post->ID, '_auto_video_gallery', true );
				} 
				
				$video_attachments = false;
				
				if(isset($auto_image_gallery) && $auto_image_gallery != '') {
					$video_attachments = get_posts( array(
						'post_type' => 'attachment',
						'include' => $auto_image_gallery
					) ); 
				}
				
				
				
				//$attachments = array_filter( explode( ',', $auto_image_gallery ) );

				if ( $video_attachments )
					foreach ( $video_attachments as $attachment ) {
						echo '<li class="video" data-attachment_id="' . $attachment->id . '">
							Format: ' . $attachment->post_mime_type . '
							<ul class="actions">
								<li><a href="#" class="delete" title="' . __( 'Delete image', 'pixautodeal' ) . '">' . __( 'Delete', 'pixautodeal' ) . '</a></li>
							</ul>
						</li>';
					}
			?>
		</ul>

		<input type="hidden" id="auto_video_gallery" name="auto_video_gallery" value="<?php echo esc_attr( $auto_image_gallery ); ?>" />

	</div>
	<p class="add_auto_video hide-if-no-js">
		<a href="#"><?php _e( 'Add auto gallery video', 'pixautodeal' ); ?></a>
	</p>
	<p>
		<?php _e('Or you can use YouTube or Vimeo iframe code', 'pixautodeal'); ?>
	</p>
	<div class="auto_iframe_video">
		
		<textarea name="auto_video_code" id="auto_video_code" rows="7"><?php echo esc_attr( $auto_video_code ); ?></textarea>
		
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($){

			// Uploading files
			var auto_gallery_frame;
			var $image_gallery_ids = $('#auto_video_gallery');
			var $auto_images = $('#auto_video_container ul.auto_video');

			jQuery('.add_auto_video').on( 'click', 'a', function( event ) {

				var $el = $(this);
				var attachment_ids = $image_gallery_ids.val();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( auto_gallery_frame ) {
					auto_gallery_frame.open();
					return;
				}

				// Create the media frame.
				auto_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: '<?php _e( 'Add Images to Product Gallery', 'pixautodeal' ); ?>',
					button: {
						text: '<?php _e( 'Add to gallery', 'pixautodeal' ); ?>',
					},
					multiple: true,
					library : { type : 'video'}
				});

				// When an image is selected, run a callback.
				auto_gallery_frame.on( 'select', function() {

					var selection = auto_gallery_frame.state().get('selection');

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();

						if ( attachment.id ) {
							attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

							$auto_images.append('\
								<li class="video" data-attachment_id="' + attachment.id + '">\
									Video\
									<ul class="actions">\
										<li><a href="#" class="delete" title="<?php _e( 'Delete video', 'pixautodeal' ); ?>"><?php _e( 'Delete', 'pixautodeal' ); ?></a></li>\
									</ul>\
								</li>');
						}

					} );

					$image_gallery_ids.val( attachment_ids );
				});

				// Finally, open the modal.
				auto_gallery_frame.open();
			});

			// Image ordering
			$auto_images.sortable({
				items: 'li.video',
				cursor: 'move',
				scrollSensitivity:40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start:function(event,ui){
					ui.item.css('background-color','#f6f6f6');
				},
				stop:function(event,ui){
					ui.item.removeAttr('style');
				},
				update: function(event, ui) {
					var attachment_ids = '';

					$('#auto_video_container ul li.video').css('cursor','default').each(function() {
						var attachment_id = jQuery(this).attr( 'data-attachment_id' );
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val( attachment_ids );
				}
			});

			// Remove images
			$('#auto_video_container').on( 'click', 'a.delete', function() {

				$(this).closest('li.video').remove();

				var attachment_ids = '';

				$('#auto_video_container ul li.video').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );

				return false;
			} );

		});
	</script>
	<?php
}


function pixad_auto_contacts( $post ){
    //so, dont ned to use esc_attr in front of get_post_meta
    $value =  get_post_meta($_GET['post'], 'pixad_auto_contact' , true ) ;
    wp_editor( $value, 'pixad_auto_contacts_editor', $settings = array('textarea_name'=>'pixad_auto_contact_info', 'editor_height'=>100) );
}


function pixad_auto_banner_content( $post ){
    //so, dont ned to use esc_attr in front of get_post_meta
    $value =  get_post_meta($_GET['post'], 'pixad_auto_banner' , true ) ;
    wp_editor( $value, 'pixad_auto_banner_editor', $settings = array('textarea_name'=>'pixad_auto_banner_info', 'editor_height'=>150) );
    $link = get_post_meta( $_GET['post'], 'pixad_auto_banner_link', true );
    ?>

    <div class="pixad-panel">
		<div class="pixad-panel-body">
			<div class="pixad-form-horizontal">
			    <div class="">
				    <label class="col-lg-1 pixad-control-label">
						<?php _e( 'Banner Link', 'pixautodeal' ); ?>
					</label>
					<div class="col-lg-10">
						<input name="pixad_auto_banner_link" type="text" value="<?php echo esc_url($link); ?>" class="pixad-form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}


/**
 * Get Meta Value
 *
 * @since 0.1
 */
function pixad_get_meta( $key ) {
	return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
}
/**
 * Auto Details MetaBox
 *
 * @since 0.1
 */
function pixad_auto_details() {
	global $post; 
	$currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); ?>
	
<input name="pixad_autos-meta" type="hidden" value="save">

<div class="pixad-panel">
	<div class="pixad-panel-body">
		<div class="pixad-form-horizontal">
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Version', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-version" type="text" placeholder="eg: 1.6 hdi" value="<?php echo pixad_get_meta( '_auto_version' ); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Made Year', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-year" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<?php pixad_get_options_range( date('Y'), 1930, pixad_get_meta('_auto_year') ); ?>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Transmission', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-transmission" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<option value="automatic" <?php if(pixad_get_meta('_auto_transmission')=='automatic') echo 'selected'; ?>><?php _e( 'Automatic', 'pixautodeal' ); ?></option>
						<option value="manual" <?php if(pixad_get_meta('_auto_transmission')=='manual') echo 'selected'; ?>><?php _e( 'Manual', 'pixautodeal' ); ?></option>
						<option value="semi-automatic" <?php if(pixad_get_meta('_auto_transmission')=='semi-automatic') echo 'selected'; ?>><?php _e( 'Semi-Automatic', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Doors', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-doors" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<?php pixad_get_options_range( 2, 5, pixad_get_meta('_auto_doors') ); ?>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Fuel Type', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-fuel" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<option value="diesel" <?php if(pixad_get_meta('_auto_fuel')=='diesel') echo 'selected'; ?>><?php _e( 'Diesel', 'pixautodeal' ); ?></option>
						<option value="electric" <?php if(pixad_get_meta('_auto_fuel')=='electric') echo 'selected'; ?>><?php _e( 'Electric', 'pixautodeal' ); ?></option>
						<option value="petrol" <?php selected( 'petrol', pixad_get_meta('_auto_fuel'), true ); ?>><?php _e( 'Petrol', 'pixautodeal' ); ?></option>
						<option value="hybrid" <?php if(pixad_get_meta('_auto_fuel')=='hybrid') echo 'selected'; ?>><?php _e( 'Hybrid', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Condition', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-condition" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<option value="new" <?php if(pixad_get_meta('_auto_condition')=='new') echo 'selected'; ?>><?php _e( 'New', 'pixautodeal' ); ?></option>
						<option value="used" <?php if(pixad_get_meta('_auto_condition')=='used') echo 'selected'; ?>><?php _e( 'Used', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Drive', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-drive" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<option value="left" <?php if(pixad_get_meta('_auto_drive')=='left') echo 'selected'; ?>><?php _e( 'Left', 'pixautodeal' ); ?></option>
						<option value="right" <?php if(pixad_get_meta('_auto_drive')=='right') echo 'selected'; ?>><?php _e( 'Right', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Color', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-color" type="text" placeholder="eg: red" value="<?php echo pixad_get_meta('_auto_color'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Price', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-price" type="text" placeholder="eg: 10000" value="<?php echo pixad_get_meta('_auto_price'); ?>" class="pixad-form-control">
					<span class="errprice"></span>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Price Type', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-price-type" class="pixad-form-control">
						<option value="fixed" <?php selected( 'fixed', pixad_get_meta('_auto_price_type'), true ); ?>><?php _e( 'Fixed', 'pixautodeal' ); ?></option>
						<option value="negotiable" <?php selected( 'negotiable', pixad_get_meta('_auto_price_type'), true ); ?>><?php _e( 'Negotiable', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Warranty', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-warranty" class="pixad-form-control">
						<option value="no" <?php selected( 'no', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'No', 'pixautodeal' ); ?></option>
						<option value="yes" <?php selected( 'yes', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'Yes', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>
<?php /* ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Currency', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="currency" class="pixad-form-control">
					<?php if( $currencies ): foreach( $currencies as $currency ): ?>

						<option value="<?php echo $currency['iso']; ?>" <?php selected( pixad_get_meta('_auto_currency'), $currency['iso'], true ); ?>><?php echo $currency['iso']; ?></option>

					<?php endforeach; else: ?>

						<option value="EUR" <?php selected( pixad_get_meta('_auto_currency'), 'EUR', true ); ?>><?php echo 'EUR'; ?></option>
						<option value="USD" <?php selected( pixad_get_meta('_auto_currency'), 'USD', true ); ?>><?php echo 'USD'; ?></option>

					<?php endif; ?>
					</select>
				</div>
			</div>
<?php */ ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Mileage', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-mileage" type="text" placeholder="eg: 100000" value="<?php echo pixad_get_meta('_auto_mileage'); ?>" class="pixad-form-control">
					<span class="errmileage"></span>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'VIN', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-vin" type="text" placeholder="eg: 1VXBR12EXCP901213" value="<?php echo pixad_get_meta('_auto_vin'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Engine, cm3', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-engine" type="text" placeholder="eg: 1900" value="<?php echo pixad_get_meta('_auto_engine'); ?>" class="pixad-form-control">
					<span class="errengine"></span>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Horsepower, hp', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-horsepower" type="text" placeholder="eg: 200" value="<?php echo pixad_get_meta('_auto_horsepower'); ?>" class="pixad-form-control">
					<span class="errhorsepower"></span>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seating Capacity', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-seats" type="text" placeholder="eg: 5" value="<?php echo pixad_get_meta('_auto_seats'); ?>" class="pixad-form-control">
					<span class="errseats"></span>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller first name', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-first-name" type="text" placeholder="eg: John" value="<?php echo pixad_get_meta('_seller_first_name'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller last name', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-last-name" type="text" placeholder="eg: Doe" value="<?php echo pixad_get_meta('_seller_last_name'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller email', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-email" type="text" placeholder="eg: johndoe@gmail.com" value="<?php echo pixad_get_meta('_seller_email'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller phone', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-phone" type="text" placeholder="eg: +38160656545" value="<?php echo pixad_get_meta('_seller_phone'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller company', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-company" type="text" placeholder="eg: General Motors" value="<?php echo pixad_get_meta('_seller_company'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller country', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="seller-country" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixautodeal' ); ?></option>
						<?php $country = new PIXAD_Country(); $country->option_output( pixad_get_meta('_seller_country') ); ?>
					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller state', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-state" type="text" placeholder="eg: Texas" value="<?php echo pixad_get_meta('_seller_state'); ?>" class="pixad-form-control">
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller town', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-town" type="text" placeholder="eg: Atlanta" value="<?php echo pixad_get_meta('_seller_town'); ?>" class="pixad-form-control">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location lable', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location" type="text" placeholder="eg: 1410 W Cheltenham Ave, Philadelphia, PA 19126, United States" value="<?php echo pixad_get_meta('_seller_location'); ?>" class="pixad-form-control">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location latitude', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location-lat" type="text" placeholder="eg: 40.0632723" value="<?php echo pixad_get_meta('_seller_location_lat'); ?>" class="pixad-form-control">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location longitude', 'pixautodeal' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location-long" type="text" placeholder="eg: -75.1411223" value="<?php echo pixad_get_meta('_seller_location_long'); ?>" class="pixad-form-control">
				</div>
			</div>
		</div>
	</div>
</div>
<?php } // End auto details

/**
 * Save Custom MetaBox fields
 *
 * @since 0.1
 * @return boolean
 */
function save_pixad_autos_meta_boxes( $post_id ) {
	
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if( isset( $_POST['pixad_autos-meta'] ) && $_POST['pixad_autos-meta'] == 'save' ) {
		$options = array(
			'_auto_version'			=> sanitize_text_field( $_POST['auto-version'] ),
			'_auto_year'			=> sanitize_text_field( $_POST['auto-year'] ),
			'_auto_transmission'	=> sanitize_text_field( $_POST['auto-transmission'] ),
			'_auto_doors'			=> sanitize_text_field( $_POST['auto-doors'] ),
			'_auto_fuel'			=> sanitize_text_field( $_POST['auto-fuel'] ),
			'_auto_condition'		=> sanitize_text_field( $_POST['auto-condition'] ),
			'_auto_drive'			=> sanitize_text_field( $_POST['auto-drive'] ),
			'_auto_color'			=> sanitize_text_field( $_POST['auto-color'] ),
			'_auto_price'			=> sanitize_text_field( $_POST['auto-price'] ),
			'_auto_price_type'		=> sanitize_text_field( $_POST['auto-price-type'] ),
			'_auto_warranty'		=> sanitize_text_field( $_POST['auto-warranty'] ),
			//'_auto_currency'		=> sanitize_text_field( $_POST['currency'] ),
			'_auto_mileage'			=> sanitize_text_field( $_POST['auto-mileage'] ),
			'_auto_vin'				=> sanitize_text_field( $_POST['auto-vin'] ),
			'_auto_engine'			=> sanitize_text_field( $_POST['auto-engine'] ),
			'_auto_horsepower'		=> sanitize_text_field( $_POST['auto-horsepower'] ),
			'_auto_seats'			=> sanitize_text_field( $_POST['auto-seats'] ),
			'_auto_images'			=> sanitize_text_field( $_POST['auto-images'] ),
			'_seller_first_name'	=> sanitize_text_field( $_POST['seller-first-name'] ),
			'_seller_last_name'		=> sanitize_text_field( $_POST['seller-last-name'] ),
			'_seller_email'			=> sanitize_text_field( $_POST['seller-email'] ),
			'_seller_phone'			=> sanitize_text_field( $_POST['seller-phone'] ),
			'_seller_company'		=> sanitize_text_field( $_POST['seller-company'] ),
			'_seller_country'		=> sanitize_text_field( $_POST['seller-country'] ),
			'_seller_state'			=> sanitize_text_field( $_POST['seller-state'] ),
			'_seller_town'			=> sanitize_text_field( $_POST['seller-town'] ),
			'_seller_location_lat'	=> sanitize_text_field( $_POST['seller-location-lat'] ),
			'_seller_location_long'	=> sanitize_text_field( $_POST['seller-location-long'] ),
		);
		
		foreach( $options as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

	}

	if (isset($_POST['pixad_auto_gallery_ids']) && $_POST['pixad_auto_gallery_ids'] != '') {
        // Encode so it can be stored an retrieved properly
        $encode = base64_encode(json_encode(explode(',',$_POST['pixad_auto_gallery_ids'])));
        update_post_meta($post_id, 'pixad_auto_gallery', $encode);
    }

	if (isset($_POST['pixad_auto_featured'])) {
        update_post_meta($post_id, 'pixad_auto_featured', $_POST['pixad_auto_featured']);
    }
    else
        delete_post_meta($post_id, 'pixad_auto_featured');

    if (isset($_POST['pixad_auto_sidebar_layout'])) {
        update_post_meta($post_id, 'pixad_auto_sidebar_layout', $_POST['pixad_auto_sidebar_layout']);
    }

    if (isset($_POST['auto_video_gallery'])) {
		$video_ids =  explode( ',',  $_POST['auto_video_gallery']  ) ;
		update_post_meta( $post_id, '_auto_video_gallery', implode( ',', $video_ids ) );
		update_post_meta( $post_id, '_auto_video_code',  $_POST['auto_video_code']  );
	}

	if (isset($_POST['pixad_auto_contact_info'])){
        $data = $_POST['pixad_auto_contact_info'];
        update_post_meta($post_id, 'pixad_auto_contact', $data );
    }

    if (isset($_POST['pixad_auto_banner_info'])){
        $data = $_POST['pixad_auto_banner_info'];
        update_post_meta($post_id, 'pixad_auto_banner', $data );
    }

    if (isset($_POST['pixad_auto_banner_link'])){
        update_post_meta($post_id, 'pixad_auto_banner_link', $_POST['pixad_auto_banner_link'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_banner_link');
    }


}
add_action( 'save_post', 'save_pixad_autos_meta_boxes' );


function pixad_get_external_video($post_id) {
	if(!$post_id) return false;
	$auto_video_code = str_replace('https://', 'http://', get_post_meta( $post_id, '_auto_video_code', true ));

	return $auto_video_code;
}

function pixad_get_external_video_img($post_id) {
	if(!$post_id) return false;
	$auto_video_code = get_post_meta( $post_id, '_auto_video_code', true );
	$vendor = parse_url($auto_video_code);
	if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com'){
		return 'http://img.youtube.com/vi'.esc_attr($vendor['path']).'/hqdefault.jpg';
	} elseif ($vendor['host'] == 'vimeo.com'){
		$imgid = esc_attr($vendor['path']);
		$hash = unserialize(file__get_contents("http://vimeo.com/api/v2/video$imgid.php"));
		return $hash[0]['thumbnail_large'];
	} else {
		return '';
	}

}

function pixad_get_attach_video($post_id) {
	if(!$post_id) return false;
	$auto_video_code = get_post_meta( $post_id, '_auto_video_gallery', false );

	return $auto_video_code;
}

/**
 * Add Custom Menu URL Class
 * Used in "Appearance->Menus"
 *
 * @since 0.3
 */
class PIXAD_Nav_Menu
{
	/**
	 * Class Constructor
	 *
	 * @since 0.3
	 */
	function __construct() {
        add_action( 'admin_head-nav-menus.php', array( $this, 'meta_boxes' ) );
    }
	
	/**
	 * Meta Boxes
	 *
	 * @since 0.3
	 */
	public function meta_boxes() {
		add_meta_box(
            'pixad_autos_links',
            __( 'PIXAD Autos Links', 'pixautodeal' ),
            array( $this, 'menu_links'),
            'nav-menus',
            'side',
            'low'
        );
	}

	
}
new PIXAD_Nav_Menu;
?>