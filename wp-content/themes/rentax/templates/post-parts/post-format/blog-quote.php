<?php
	global $post;
	// get meta options/values
	$rentax_content = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_quote_content') : '';
	$rentax_source = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_quote_source') : '';
	$rentax_format  = get_post_format();
	$rentax_format = !in_array($rentax_format, array("quote", "gallery", "video")) ? "standared" : $rentax_format;

?>

<div class="entry-media">
	<blockquote>
		<?php echo wp_kses_post($rentax_content); ?>
		<div class="blog-quote-source"><?php echo wp_kses_post($rentax_source)?></div>
	</blockquote>
	<a href="<?php esc_url(the_permalink())?>" class="btn button-border font-additional font-weight-bold hvr-rectangle-out hover-focus-bg hover-focus-border before-bg"><?php echo rentax_post_read_more()?></a>
</div>
