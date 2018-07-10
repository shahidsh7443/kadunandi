<?php 
	function rentax_get_option($slug, $_default = false){
		
		if ($stgs = rentax_getCustomizeSettings()){
			$slug_option_name = 'rentax_'.$slug;
			if (isset($stgs->$slug_option_name))
				return esc_attr($stgs->$slug_option_name);
		}

		$slug = 'rentax_' . $slug;

		//$pix_options = get_option('theme_mods_rentax');
		$pix_options = get_theme_mods();

		if (isset($pix_options[$slug])){
			return wp_kses_post($pix_options[$slug]);
		}else{
			if ($_default !== false)
				return wp_kses_post($_default);
			else
				return false;	
		}
		
	}
	
	
	function rentax_getCustomizeSettings(){
		if (isset($_POST['wp_customize']) && $_POST['wp_customize'] == 'on'){
			$settings = json_decode(stripslashes($_POST['customized']));
			return $settings;	
		}else{
			return false;
		}

	}


	function rentax_load_modules($modules = array()){
		if (!is_array($modules))
			return false;
			

		foreach($modules as $_module){
            $_moduleDir = get_template_directory() . '/library/modules/' . $_module . '/';
			if (file_exists($_moduleDir) && is_dir($_moduleDir) && file_exists($_moduleDir . $_module . '.php')){
                get_template_part( 'library/modules/' . $_module . '/' . $_module );
            }
		}

	}

	function rentax_load_files($files,$dir = false){
		if (!is_array($files))
			return false;

		if (!$dir)
			$dir = '';

		foreach($files as $_file){
			$filename = $dir . $_file;
			if (file_exists(get_template_directory() . '/'.$filename.'.php')){
				get_template_part( $filename );
			}
		}
	}



	
?>