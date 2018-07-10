<?php
$comments = wp_count_comments($post->ID);
$categories = wp_get_post_categories($post->ID,array('fields' => 'all'));
$tags = get_the_tags($post->ID);
?>

<main class="main-content">

	<article class="post post_mod-b clearfix">
		<?php
			$rentax_format  = get_post_format();
	        $rentax_format = !in_array($rentax_format, array("quote", "gallery", "video")) ? 'standared' : $rentax_format;
	        get_template_part( 'templates/post-single/blog', $rentax_format);
		?>

		<div class="entry-main">
			<div class="entry-main__inner">
				<h3 class="entry-title"><?php wp_kses_post(the_title())?></h3>
				<div class="entry-meta">
				<?php if(rentax_get_option('blog_settings_author_name', 1)) : ?>
					<span class="entry-meta__item"><?php esc_html_e('By:: ', 'rentax')?> <span class="entry-meta__link"> <?php the_author_posts_link(); ?></span></span>
				<?php endif ?>

				<?php if(rentax_get_option('blog_settings_categories', 1)) : ?>
					<span class="entry-meta__item"><?php esc_html_e('In:: ', 'rentax')?>

					<?php $catIndex = 0; foreach($categories as $category):?>
                    <a class="entry-meta__link" href="<?php echo esc_url(get_category_link($category->term_id))?>">
                        <?php echo esc_attr($category->name) ?><?php if ($catIndex < (sizeof($categories) - 1)):?>,<?php endif;?>
                    </a>
                    <?php $catIndex++; endforeach ?>
                    </span>
				<?php endif ?>

				<?php if( 'open' == $post->comment_status && rentax_get_option('blog_settings_comments', 1) ) : ?>
		            <span class="entry-meta__item"><?php esc_html_e('COMMENTS:: ', 'rentax')?><?php comments_popup_link( '0', '1', '%', 'entry-meta__link'); ?></span>
		        <?php endif ?>
				</div>
			</div>
			<div class="decor-1"></div>
			<?php if(rentax_get_option('blog_settings_date', 1)) : ?>
			<div class="entry-date"><span class="entry-date__inner"><span class="entry-date__number"><?php echo get_the_time('j'); ?></span><br><?php echo get_the_time('M'); ?></span></div>
			<?php endif ?>
			<div class="entry-content rtd">
				<?php wp_link_pages();?>
                <?php the_content()?>
			</div>

			<footer class="entry-footer clearfix">
			<?php if ($tags && rentax_get_option('blog_settings_tags', 1)):?>
				<div class="wrap-social-block pull-left">
                    <span class="entry-meta__item"><?php esc_html_e('Tags', 'rentax')?>
                        <?php $tagIndex = 0; foreach($tags as $tag):?>
                            <a href="<?php echo esc_url(get_tag_link( $tag->term_id ))?>" class="entry-meta__link"><?php echo esc_attr($tag->name)?><?php if ($tagIndex < (sizeof($tags) - 1)):?>,<?php endif;?></a>
                        <?php $tagIndex++; endforeach; ?>
                    </span>
                </div>
			<?php endif;?>
			<?php if(shortcode_exists( 'share' ) && rentax_get_option('blog_settings_share', 1)) : ?>
				<div class="wrap-social-block wrap-social-block_mod-a pull-right">
					<?php echo do_shortcode('[share]'); ?>
				</div>
			<?php endif ?>

			</footer>
		</div>
	</article><!-- end post -->

	<?php if(rentax_get_option('blog_settings_author', 1) && the_author_meta( 'description') != '') : ?>
	<?php
        $get_avatar = get_avatar(get_the_author_meta('ID'), 123);
        preg_match("/src=['\"](.*?)['\"]/i", $get_avatar, $matches);
        $src = !empty($matches[1]) ? $matches[1] : '';

        $facebook = get_the_author_meta( 'facebook') ? '<li><a class="icon fa fa-facebook" target="_blank" href="'.esc_url(get_the_author_meta( 'facebook' )).'"></a></li>' : '';
        $twitter = get_the_author_meta( 'twitter') ? '<li><a class="icon fa fa-twitter" target="_blank" href="'.esc_url(get_the_author_meta( 'twitter' )).'"></a></li>' : '';
        $google = get_the_author_meta( 'google') ? '<li><a class="icon fa fa-google-plus" target="_blank" href="'.esc_url(get_the_author_meta( 'google' )).'"></a></li>' : '';
        $linkedin = get_the_author_meta( 'linkedin') ? '<li><a class="icon fa fa-linkedin" target="_blank" href="'.esc_url(get_the_author_meta( 'linkedin' )).'"></a></li>' : '';
    ?>
	<article class="about-autor">
		<div class="about-autor__img"><img class="img-responsive" src="<?php echo esc_url($src) ?>"  alt="avatar"/></div>
		<div class="about-autor__inner">
			<h3 class="about-autor__name"><?php the_author(); ?></h3>
			<div class="about-autor__categorie"><?php esc_html_e('author', 'rentax') ?></div>
			<div class="decor-1"></div>
			<div class="about-autor__description"><?php the_author_meta( 'description'); ?></div>
		</div>
		<?php if($facebook || $twitter || $google || $linkedin) : ?>
		<ul class="about-autor__social list-unstyled">
			<?php echo wp_kses_post($facebook . $twitter . $google . $linkedin); ?>
		</ul>
		<?php endif; ?>
	</article>
	<?php endif ?>

	<?php
		$rentax_prev_thumb = $rentax_next_thumb = '';
		$rentax_prev_post = get_previous_post(true);
		if(isset($rentax_prev_post->ID)) {
			$rentax_prev_thumb = get_the_post_thumbnail($rentax_prev_post->ID, array(75, 75), array('class' => 'img-responsive'));
		}
		$rentax_next_post = get_next_post(true);
		if(isset($rentax_next_post->ID)) {
			$rentax_next_thumb = get_the_post_thumbnail($rentax_next_post->ID, array(75, 75), array('class' => 'img-responsive'));
		}
	?>
	<div class="post-nav">
		<div class="post-nav__item">
			<div class="post-nav__img"><?php echo wp_kses_post($rentax_prev_thumb) ?></div>
			<div class="post-nav__inner">
				<div class="post-nav__title"><?php echo wp_kses_post(get_the_title($rentax_prev_post)) ?></div>
				<a class="post-nav__link" href="<?php echo esc_url(get_the_permalink($rentax_prev_post)) ?>"><?php esc_html_e('PREVIOUS POST', 'rentax')?></a>
			</div>
		</div>
		<div class="post-nav__item">
			<div class="post-nav__img"><?php echo wp_kses_post($rentax_next_thumb) ?></div>
			<div class="post-nav__inner">
				<div class="post-nav__title"><?php echo wp_kses_post(get_the_title($rentax_next_post)) ?></div>
				<a class="post-nav__link" href="<?php echo esc_url(get_the_permalink($rentax_next_post)) ?>"><?php esc_html_e('NEXT POST', 'rentax')?></a>
			</div>
		</div>
	</div>

	<?php comments_template(); ?>

</main>