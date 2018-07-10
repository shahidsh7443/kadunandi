<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width">


<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-scrolling-animations="false" data-header="fixed-header">

<?php
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (isset($post->ID) && $post->ID>0 ? $post->ID : '');
	if( class_exists( 'WooCommerce' ) && rentax_is_woo_page() && rentax_get_option('rentax_woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}

	$rentax_header = apply_filters('rentax_header_settings', $post_ID);

?>

<?php if( (rentax_get_option('general_settings_loader','useall') == 'usemain' && is_front_page()) || rentax_get_option('general_settings_loader','useall') == 'useall' ) : ?>
<!-- Loader -->
	<div id="page-preloader">
        
        <div class="thecube">
    		<div class="cube c1"></div>
    		<div class="cube c2"></div>
    		<div class="cube c4"></div>
    		<div class="cube c3"></div>
    	</div>
    
    </div>
<!-- Loader end -->
<?php endif; ?>


<?php
	include(get_template_directory() . '/templates/header/header_menu/search.php');

	if ( in_array($rentax_header['header_menu_add_position'], array('left', 'right', 'top', 'bottom'))  && $rentax_header['header_type'] != 'header3' ) {
		include(get_template_directory() . '/templates/header/header_menu/slide.php');
	}
	?>
	<div data-off-canvas="slidebar-5 left overlay" class="mobile-slidebar-menu">
		<button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button">
			<span class="toggle-menu-button-icon"><span></span> <span></span> <span></span> <span></span>
				<span></span> <span></span></span>
		</button>
		<?php
			if ( has_nav_menu( 'mobile_nav' ) ) {
				wp_nav_menu(array(
					'theme_location'  => 'mobile_nav',
	                'container'       => false,
	                'menu_id'		  => 'mobile-menu',
	                'menu_class'      => 'nav navbar-nav'
				));
			} else {
				echo rentax_site_menu('yamm main-menu nav navbar-nav');
			}
		?>
	</div>
	<?php
	if ( $rentax_header['header_menu_add_position'] == 'screen' && $rentax_header['header_type'] != 'header3' ) {
		include(get_template_directory() . '/templates/header/header_menu/full-screen.php');
	}
?>

<?php if($rentax_header['header_sidebar_view'] == 'fixed') : ?>
	<!-- FIXED SIDEBAR MENU  -->
	<div class="wrap-left-open ">
<?php endif; ?>

<?php
	if($rentax_header['header_type'] == 'header3')
		rentax_get_theme_header();
?>

<?php if($rentax_header['header_menu_animation'] == 'reveal') : ?>
	<!-- ========================== -->
	<!-- CONTAINER SLIDE MENU  -->
	<!-- ========================== -->
	<div data-canvas="container">
<?php endif; ?>

<div class="layout-theme animated-css"  data-header="<?php echo esc_attr($rentax_header['header_sticky'] != 'sticky' ? 'nosticky' : 'sticky');?>" data-header-top="200"  >

<?php
	if($rentax_header['header_type'] != 'header3')
		rentax_get_theme_header();

	if (!is_page_template('page-home.php')) {
		rentax_load_block('header/header_bgimage');
	}
?>

<div id="wrapper">



