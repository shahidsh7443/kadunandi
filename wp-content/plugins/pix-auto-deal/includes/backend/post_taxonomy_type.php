<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * JPro Autos Post Types
 * ====================
 * @since 1.0
 */
if( ! class_exists( 'PIXAD_Post_Types' ) ) {
	class PIXAD_Post_Types
	{
		public function __construct() {
			add_action( 'init', array( $this, 'create_taxonomies' ), 0 );
			add_action( 'init', array( $this, 'post_type_init' ) );
		}


		/**
		 * Register a "pixad-autos" post_type
		 *
		 * @since 1.0
		 */
		function post_type_init() {
			$labels = array(
				'name'               => __( 'Autos', 'pixautodeal' ),
				'singular_name'      => __( 'Autos', 'pixautodeal' ),
				'menu_name'          => __( 'Autos', 'pixautodeal' ),
				'name_admin_bar'     => __( 'Autos', 'pixautodeal' ),
				'add_new'            => __( 'New Auto', 'pixautodeal' ),
				'add_new_item'       => __( 'New Auto', 'pixautodeal' ),
				'new_item'           => __( 'New Auto', 'pixautodeal' ),
				'edit_item'          => __( 'Edit Auto', 'pixautodeal' ),
				'view_item'          => __( 'View Auto', 'pixautodeal' ),
				'all_items'          => __( 'All Autos', 'pixautodeal' ),
				'search_items'       => __( 'Search Autos', 'pixautodeal' ),
				'parent_item_colon'  => __( 'Parent Autos:', 'pixautodeal' ),
				'not_found'          => __( 'No autos found.', 'pixautodeal' ),
				'not_found_in_trash' => __( 'No autos found in Trash.', 'pixautodeal' )
			);

			$args = array(
				'labels'            	=> $labels,
				'public'             	=> true,
				'publicly_queryable' 	=> true,
				'show_ui'            	=> true,
				'show_in_menu'       	=> true,
				'query_var'          	=> true,
				'rewrite'            	=> array( 'slug' => 'autos' ),
				'capability_type'    	=> 'post',
				'has_archive'        	=> false,
				'hierarchical'       	=> false,
				'menu_position'      	=> null,
				'menu_icon'			 	=> PIXAD_AUTO_URI . 'assets/img/pixad.png',
				'supports'           	=> array( 'title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'excerpt' ),
				'register_meta_box_cb'	=> 'add_pixad_auto_meta_boxes'
			);

			register_post_type( 'pixad-autos', $args );


			add_filter('manage_edit-pixad-autos_columns', 'pixad_autos_edit_columns');
			add_action('manage_posts_custom_column',  'pixad_autos_custom_columns');

			function pixad_autos_edit_columns($columns){
				$columns = array(
					'cb' => '<input type="checkbox" />',
					'auto_image' => 'Image Preview',
					'title' => 'Title',
					'id' => 'ID',
					'auto_model' => 'Model',
					'auto_body' => 'Body Style',
					'date' => 'Date'
				);

				return $columns;
			}

			function pixad_autos_custom_columns($column){
				global $post;
				switch ($column)
				{
					case "id":
						echo $post->ID;
						break;

					case "auto_model":
						echo get_the_term_list($post->ID, 'auto-model', '', ', ','');
						break;

					case 'auto_body':
						echo get_the_term_list($post->ID, 'auto-body', '', ', ','');
						break;

					case 'auto_image':
						the_post_thumbnail( 'rentax-thumb' );
						break;
				}
			}

		}

		/**
		 * Create Two Taxonomies, "models" && "equipments" For The Post Type "pixad-autos"
		 *
		 * @since 1.0
		 */
		function create_taxonomies() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Model', 'pixautodeal' ),
				'singular_name'     => __( 'Models', 'pixautodeal' ),
				'search_items'      => __( 'Search Auto Models', 'pixautodeal' ),
				'all_items'         => __( 'All Auto Models', 'pixautodeal' ),
				'parent_item'       => __( 'Parent Auto Model', 'pixautodeal' ),
				'parent_item_colon' => __( 'Parent Auto Model:', 'pixautodeal' ),
				'edit_item'         => __( 'Edit Auto Model', 'pixautodeal' ),
				'update_item'       => __( 'Update Auto Model', 'pixautodeal' ),
				'add_new_item'      => __( 'Add Auto Model', 'pixautodeal' ),
				'new_item_name'     => __( 'New Auto Model Name', 'pixautodeal' ),
				'menu_name'         => __( 'Models', 'pixautodeal' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-model' ),
			);

			register_taxonomy( 'auto-model', array( 'pixad-autos' ), $args );


			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Body Style', 'pixautodeal' ),
				'singular_name'     => __( 'Body Styles', 'pixautodeal' ),
				'search_items'      => __( 'Search Body Style', 'pixautodeal' ),
				'all_items'         => __( 'All Body Styles', 'pixautodeal' ),
				'parent_item'       => __( 'Parent Body Style', 'pixautodeal' ),
				'parent_item_colon' => __( 'Parent Body Style:', 'pixautodeal' ),
				'edit_item'         => __( 'Edit Body Style', 'pixautodeal' ),
				'update_item'       => __( 'Update Body Style', 'pixautodeal' ),
				'add_new_item'      => __( 'Add Car Body Style', 'pixautodeal' ),
				'new_item_name'     => __( 'New Body Style Name', 'pixautodeal' ),
				'menu_name'         => __( 'Body Styles', 'pixautodeal' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-body' ),
			);

			register_taxonomy( 'auto-body', array( 'pixad-autos' ), $args );


			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Equipment', 'pixautodeal' ),
				'singular_name'     => __( 'Equipments', 'pixautodeal' ),
				'search_items'      => __( 'Search Equipment', 'pixautodeal' ),
				'all_items'         => __( 'All Equipments', 'pixautodeal' ),
				'parent_item'       => __( 'Parent Equipment', 'pixautodeal' ),
				'parent_item_colon' => __( 'Parent Eqipment:', 'pixautodeal' ),
				'edit_item'         => __( 'Edit Equipment', 'pixautodeal' ),
				'update_item'       => __( 'Update Equipment', 'pixautodeal' ),
				'add_new_item'      => __( 'Add Car Equipment', 'pixautodeal' ),
				'new_item_name'     => __( 'New Equipment Name', 'pixautodeal' ),
				'menu_name'         => __( 'Equipments', 'pixautodeal' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-equipment' ),
			);

			register_taxonomy( 'auto-equipment', array( 'pixad-autos' ), $args );

			add_filter('manage_edit-auto-body_columns', 'pixad_auto_body_columns');
			add_filter('manage_auto-body_custom_column', 'pixad_auto_body_custom_column', 10, 3);

			function pixad_auto_body_columns($columns){
				unset(
					$columns['cb']
				);
				$new_columns = array(
					'cb' => '<input type="checkbox" />',
					'thumbnail' =>  __('Thumbnail', 'PixTheme'),
				);
			    return array_merge($new_columns, $columns);
			}

			function pixad_auto_body_custom_column($c, $column_name, $term_id){
			    $term = get_term_by( 'term_taxonomy_id', $term_id, 'auto-body' );
		        $t_slug = $term->slug;
				$pixad_body_thumb_url = get_option("pixad_body_thumb".$t_slug);
				switch ($column_name)
				{
					case "thumbnail": ;
						if(!empty($pixad_body_thumb_url))
			                echo '<img src="'.esc_url($pixad_body_thumb_url).'" style="max-width:100px;" >';
						break;

					default:
						break;
				}
			}
			
		}
	}
	new PIXAD_Post_Types;


	add_action('admin_init', 'pixad_body_custom_fields', 1);
	function pixad_body_custom_fields()	{
		add_action( 'edited_auto-body', 'pixad_body_custom_fields_save' );
		add_action( 'auto-body_edit_form_fields', 'pixad_body_custom_fields_form' );
        add_action( 'auto-body_add_form_fields', 'pixad_body_custom_fields_add_form' );
        add_action( 'created_auto-body', 'pixad_body_custom_fields_save' );
	}

	function pixad_body_custom_fields_form($tag){
		$t_slug = $tag->slug;
		$cat_meta = get_option("auto_body_$t_slug");
		$pixad_body_thumb_url = get_option('pixad_body_thumb' . $t_slug);
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_body_icon"><?php _e('Icon', 'pixautodeal'); ?></label></th>
			<td>
				<input type="text" name="pixad_body_icon" id="tag-pixad_body_icon" size="25" style="width:60%;" value="<?php echo esc_attr($cat_meta['pixad_body_icon']) ? esc_attr($cat_meta['pixad_body_icon']) : ''; ?>">
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button><br />
				<span class="description"><?php _e('Icon class', 'pixautodeal'); ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_body_thumb"><?php _e('Thumbnail', 'pixautodeal'); ?></label></th>
			<td>
				<input type="text" name="pixad_body_thumb" id="tag-pixad_body_thumb" style="width:60%;" value="<?php echo isset($pixad_body_thumb_url) ? esc_url($pixad_body_thumb_url) : ''; ?>" />
				<button data-input="tag-pixad_body_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
				<?php if(isset($pixad_body_thumb_url) && $pixad_body_thumb_url){ ?><p class="pix-bg"> <img src="<?php echo esc_url($pixad_body_thumb_url) ?>" alt="<?php esc_attr_e('Thumbnail', 'pixautodeal') ?>"> </p><?php } ?>
			</td>
		</tr>
		<?php
	}

	function pixad_body_custom_fields_add_form($tag) {
	?>
		<div class="form-field">
			<label for="tag-pixad_body_icon"><?php _e('Icon', 'pixautodeal'); ?></label>
			<input type="text" name="pixad_body_icon" id="tag-pixad_body_icon" size="40" value="">
			<br />
			<p><?php _e('Icon class', 'pixautodeal'); ?></p>
		</div>
		<div class="form-field">
			<label for="tag-pixad_body_thumb"><?php _e('Image', 'pixautodeal'); ?></label>
			<input type="text" name="pixad_body_thumb" id="tag-pixad_body_thumb" value="">
			<button data-input="tag-pixad_body_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
			<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
		</div>
	<?php
	}

	function pixad_body_custom_fields_save($term_id) {
	    $term = get_term_by( 'term_taxonomy_id', $term_id, 'auto-body' );
		$t_slug = $term->slug;
		if (isset($_POST['pixad_body_thumb']) || isset($_POST['pixad_body_icon'])) {
			$cat_meta = get_option("auto_body_$t_slug");
			if (isset($_POST['pixad_body_thumb'])) {
				update_option('pixad_body_thumb' . $t_slug, $_POST['pixad_body_thumb']);
			}
			if (isset($_POST['pixad_body_icon'])) {
				$cat_meta['pixad_body_icon'] = $_POST['pixad_body_icon'];
			}

			//save the option array
			update_option("auto_body_$t_slug", $cat_meta);
		}
	}


}