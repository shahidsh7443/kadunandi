<?php 
global $page,$post;


$id = rentax_woo_get_page_id();
$isProduct = false;

if ( is_single() && get_post_type() == 'product' ) {
	$isProduct = true;
}

$custom = $id > 0 ? get_post_custom($id) : array();
$layout = isset ($custom['pix_page_layout']) ? reset($custom['pix_page_layout']) : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? reset($custom['pix_selected_sidebar']) : 'Shop Sidebar';
$pix_options = get_option('pix_general_settings');

?>


<?php get_header();?>


<div class="container">
    <div class="row">
			<?php if ($layout == '3'):?>
				<div class="col-xs-12 col-sm-12 col-md-3">
					<aside class="sidebar">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar) ) : ?> <?php   endif;?>
					</aside>
				</div>
			<?php endif?>

			<div class="col-xs-12<?php if ($layout == '1'):?> col-sm-12 col-md-12 <?php else: ?> col-sm-12 col-md-9 <?php endif?>">
				<main class="main-content">
				<?php  woocommerce_content(); ?>
				</main>
			</div>

			<?php if ($layout == '2'):?>
				<div class="col-xs-12 col-sm-12 col-md-3">
					<aside class="sidebar">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar) ) : ?> <?php   endif;?>
					</aside>
				</div>
			<?php endif?>
    </div>
</div>



           
<?php get_footer();?>
