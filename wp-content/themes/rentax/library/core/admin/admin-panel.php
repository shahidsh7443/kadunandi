<?php


	require_once(get_template_directory() . '/library/core/admin/admin-panel/general.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/header.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/responsive.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/search.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/footer.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/shop.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/blog.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/social.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/envato.php' );


	
	function rentax_customize_register( $wp_customize ) {


		/** GENERAL SETTINGS **/
		rentax_customize_general_tab($wp_customize,'rentax');
		

		/** HEADER SECTION **/

		rentax_customize_header_tab($wp_customize,'rentax');
		
		
		/** RESPONSIVE SECTION **/

		rentax_customize_responsive_tab($wp_customize,'rentax');


		/** SEARCH SECTION **/

		rentax_customize_search_tab($wp_customize,'rentax');
		

		/** FOOTER SECTION **/

		rentax_customize_footer_tab($wp_customize,'rentax');


		/** SHOP SECTION **/

		rentax_customize_shop_tab($wp_customize,'rentax');


		/** BLOG SECTION **/

		rentax_customize_blog_tab($wp_customize,'rentax');

		/** SOCIAL SECTION **/

		rentax_customize_social_tab($wp_customize,'rentax');


		/** ENVATO SECTION **/

		rentax_customize_envato_tab($wp_customize, 'rentax');


		/** Remove unused sections */

		$removedSections = apply_filters('rentax_admin_customize_removed_sections', array('header_image','background_image'));
		foreach ($removedSections as $_sectionName){
			$wp_customize->remove_section($_sectionName);
		}

    }
    
    
	add_action( 'customize_register', 'rentax_customize_register' );
?>