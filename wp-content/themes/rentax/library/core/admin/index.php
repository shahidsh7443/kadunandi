<?php
	
	/*  Redirect To Theme Options Page on Activation  */
	if (is_admin() && isset($_GET['activated'])) {
	    wp_redirect(admin_url('themes.php'));
	}
	
	/*  Load custom admin scripts & styles  */
	function rentax_load_custom_wp_admin_style()	{
		wp_enqueue_media();
		
		wp_register_script( 'rentax_custom_wp_admin_script', get_template_directory_uri() . '/js/custom-admin.js', array( 'jquery' ) );
	    wp_localize_script( 'rentax_custom_wp_admin_script', 'meta_image',
	        array(
	            'title' => esc_html__( 'Choose or Upload an Image', 'rentax' ),
	            'button' => esc_html__( 'Use this image', 'rentax' ),
	        )
	    );
	    wp_enqueue_script( 'rentax_custom_wp_admin_script' );
	    wp_enqueue_style('rentax-custom', get_template_directory_uri() . '/css/custom-admin.css');
	    
	    // Add the color picker css file
	    wp_enqueue_style( 'wp-color-picker' );
	    // Include our custom jQuery file with WordPress Color Picker dependency
	    wp_enqueue_script( 'rentax-color', get_template_directory_uri() . '/js/custom-script.js', array( 'wp-color-picker' ), false, true );
	}
	
	function rentax_add_editor_styles() {
		add_editor_style( 'rentax-editor-style.css' );
	}

	add_filter('login_headerurl', create_function('', "return get_home_url('/');"));
	add_filter('login_headertitle', create_function('', 'return false;'));
	add_action('admin_enqueue_scripts', 'rentax_load_custom_wp_admin_style');
	add_action('admin_init', 'rentax_add_editor_styles' );

	
	/* Admin Panel */
	require_once(get_template_directory() . '/library/core/admin/admin-panel.php');
	
	
	require_once(get_template_directory() . '/library/core/admin/class-tgm-plugin-activation.php');
	
	require_once(get_template_directory() . '/library/core/admin/post-fields.php');

	require_once(get_template_directory() . '/library/core/admin/functions.php');
	

?>