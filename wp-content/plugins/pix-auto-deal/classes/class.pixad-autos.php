<?php
class PIXAD_Autos {

	public $per_page;

	public $order;

	public $orderby;

	public $metakey;

	protected static $orderby_arr = array('date', 'title');
	/**
	 * Class Constructor
	 * =================
	 * @since 0.4
	 */
	public function __construct() {
		$this->translation();
		
		// Rewrite rules
		add_action( 'init', array( $this, 'rewrite_rules' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'init_plugin' ) );
        add_action( 'wp_ajax_process_reservation', array( $this, 'process_reservation' ) );
        add_action( 'wp_ajax_nopriv_process_reservation', array( $this, 'process_reservation' ) );
	}

	/**
	 * Custom Rewrite Rules
	 * ====================
	 * @since 0.6
	 */
	public function rewrite_rules() {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		//add_rewrite_rule( '^add-auto/?', 'index.php?page_id='.$settings['cc_page_id'].'&pixad=add-new-pixad', 'top' );
		//add_rewrite_rule( '^my-autos/?', 'index.php?page_id='.$settings['cc_page_id'].'&pixad=my-pixads', 'top' );
	}


	public function init_plugin() {
        wp_enqueue_script(
            'ajax_script',
            plugins_url( '/pix-auto-deal/assets/js/pixad-ajax.js' ),
            array('jquery'),
            TRUE
        );
        wp_localize_script(
            'ajax_script',
            'pixadAjax',
            array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( "process_reservation_nonce" ),
            )
        );
    }

    public function process_reservation() {
		$Settings = new PIXAD_Settings();
		$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
		$validate = pixad::validation( $validate ); // Fix undefined index notice

		$country = new PIXAD_Country();

	    $data = array_map( 'esc_attr', $_GET );

        check_ajax_referer( 'process_reservation_nonce', 'nonce' );

        if( true ){
            $args = array();
            foreach($data as $key=>$val){
                if( property_exists('PIXAD_Autos', $key) && $key == 'order' ){
                    $temp = explode('-', $val);

	                if(isset($temp[0]) && in_array($temp[0], self::$orderby_arr)){
		                $this->orderby = $temp[0];
		                $this->order = strtoupper($temp[1]);
		                $this->metakey = '';
	                }
	                elseif(isset($temp[0]) && !in_array($temp[0], self::$orderby_arr)){
		                $this->orderby = array( 'meta_value_num' => strtoupper($temp[1]) );
		                $this->metakey = $temp[0];
	                }
                } elseif( property_exists('PIXAD_Autos', $key) && $key == 'per_page' ) {
	                $this->$key = $val;
                } elseif( $key != 'action' && $key != 'nonce' && $val != ''){
                    $args[$key] = $val;
                }
            }
            $rentax_loop = new WP_Query( $this->Query_Args( $args ) );
            $pixad_out = '';
            include( dirname( __FILE__ ) . '/../templates/autos_listing.php' );
			wp_send_json_success($pixad_out);

        }
        else
            wp_send_json_error( array( 'error' => $custom_error ) );
    }


	function pagenavi($max_page, $paged = 1) {
	    $pagenavi_options = array(
	        'pages_text' => '',
	        'current_text' => '%PAGE_NUMBER%',
	        'page_text' => '%PAGE_NUMBER%',
	        'first_text' => wp_kses_post(__('<i class="fa fa-angle-left"></i>','pixautodeal')),
	        'last_text' => wp_kses_post(__('<i class="fa fa-angle-right"></i>','pixautodeal')),
	        'next_text' => wp_kses_post(__('NEXT','pixautodeal')),
	        'prev_text' => wp_kses_post(__('PREV','pixautodeal')),
	        'dotright_text' => esc_html__('...','pixautodeal'),
	        'dotleft_text' => esc_html__('...','pixautodeal'),
	        'style' => 1,
	        'num_pages' => 5,
	        'always_show' => 0,
	        'num_larger_page_numbers' => 3,
	        'larger_page_numbers_multiple' => 10,
	        'use_pagenavi_css' => 1,
	    );

	    $Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
	    $posts_per_page = intval($settings['autos_per_page']);

//	    $paged = intval(get_query_var('paged'));
//	    //$max_page = intval($this->max_num_pages);
//
//	    if (empty($paged) || $paged == 0)
//	        $paged = 1;

	    $pages_to_show = intval($pagenavi_options['num_pages']);
	    $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
	    $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
	    $pages_to_show_minus_1 = $pages_to_show - 1;
	    $half_page_start = floor($pages_to_show_minus_1/2);
	    $half_page_end = ceil($pages_to_show_minus_1/2);
	    $start_page = $paged - $half_page_start;

	    if ($start_page <= 0)
	        $start_page = 1;

	    $end_page = $paged + $half_page_end;
	    if (($end_page - $start_page) != $pages_to_show_minus_1) {
	        $end_page = $start_page + $pages_to_show_minus_1;
	    }

	    if ($end_page > $max_page) {
	        $start_page = $max_page - $pages_to_show_minus_1;
	        $end_page = $max_page;
	    }

	    if ($start_page <= 0)
	        $start_page = 1;

	    $larger_pages_array = array();
	    if ( $larger_page_multiple )
	        for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
	            $larger_pages_array[] = $i;

		$out = '';

	    if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
	        $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%','pixautodeal'));
	        $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
	        $out .= '<ul class="pixad-paging pagination">'."\n";
	        switch(intval($pagenavi_options['style'])) {
	            // Normal
	            case 1:
	                if (!empty($pages_text)) {
	                    //echo '<li><span class="pages">'.$pages_text.'</span></li>';
	                }
	                if ($start_page >= 2 && $pages_to_show < $max_page) {
	                    $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
	                    $out .= '<li><a href="javascript:void(0);" data-page="'.$max_page.'" class="first pix-ajax-page" title="">'.$first_page_text.'</a></li>';
	                    if (!empty($pagenavi_options['dotleft_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotleft_text'].'</span></li>';
	                    }
	                }
	                $larger_page_start = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript;" data-page="'.$larger_page.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_start++;
	                    }
	                }
	                if($paged > 1)
	                    $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged-1).'" class="previouspostslink pix-ajax-page">'.$pagenavi_options['prev_text'].'</a></li>';
	                for($i = $start_page; $i  <= $end_page; $i++) {
	                    if ($i == $paged) {
	                        $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
	                        $out .= '<li class="active"><a href="javascript:void(0);">'.$current_page_text.'</a></li>';
	                    } else {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript:void(0);" data-page="'.$i.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                    }
	                }
					if($paged < $max_page)
	                $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged+1).'" class="nextpostslink pix-ajax-page">'.$pagenavi_options['next_text'].'</a></li>';
	                $larger_page_end = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript:void(0);" data-page="'.$larger_page.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_end++;
	                    }
	                }
	                if ($end_page < $max_page) {
	                    if (!empty($pagenavi_options['dotright_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotright_text'].'</span></li>';
	                    }
	                    $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
	                    $out .= '<li><a href="javascript:void(0);" data-page="'.$max_page.'" class="last pix-ajax-page" title="">'.$last_page_text.'</a></li>';
	                }
	                break;

	        }
	        $out .= '</ul>'."\n";

	    }
	    return $out;
	}


	/**
	 * Search Autos Variations
	 * ======================
	 * @since 0.1
	 * @return array
	 */
	public function Query_Args( $query_args ) {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		if( is_array( $query_args ) )
			 extract( $query_args );

		if( empty( $make ) ) 		$make 		= 'all';
		if( empty( $model ) ) 		$model 		= 'all';
		if( empty( $body ) ) 		$body 		= 'all';
		if( empty( $year ) )		$year 		= 'all';
		if( empty( $fuel ) )		$fuel 		= 'all';
		if( empty( $condition ) )	$condition 	= 'all';
		if( empty( $mileage ) ) 	$mileage	= 'all';
		if( empty( $price ) ) 		$price		= 'all';
		if( empty( $auto_id ) ) 	$auto_id	= '';
		if( empty( $per_page ) ) 	$per_page	= $settings['autos_per_page'];
		if( empty( $order ) ) 	    $order	    = 'date';

		/**
		 * Fix Paged on Static Homepage
		 * ============================
		 * @since 0.4
		 */

		if( empty( $paged ) && get_query_var('paged') ) {
			$paged = get_query_var('paged');
		}elseif( empty( $paged ) && get_query_var('page') ) {
			$paged = get_query_var('page');
		}elseif ( empty( $paged ) ) {
			$paged = 1;
		}

		
		##################################################
		# SEARCH CARS BY MAKE
		##################################################
		$this->taxQuery['autoMake'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-make'] ) && !empty( $_REQUEST['auto-make'] ) ) {
			
			// Store Search Parameters
			$this->tax['taxonomy']	= 'auto-model';
			$this->tax['field']		= 'term_id';
			$this->tax['terms']		= esc_attr( $_REQUEST['auto-make'] );
			
			// Format Tax Query
			$this->taxQuery['autoMake'] = array(
				'taxonomy'	=> $this->tax['taxonomy'], 
				'field' 	=> $this->tax['field'], 
				'terms' 	=> $this->tax['terms']
			);
			
		}
		##################################################
		# SEARCH CARS BY MODEL
		##################################################
		$this->taxQuery['autoModel'] = '';
		//if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-model'] ) && !empty( $_REQUEST['auto-model'] ) ) {
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-model'] ) && !empty( $_REQUEST['auto-model'] ) ) {
				
				// Store Search Parameters
				$this->tax['taxonomy']	= 'auto-model';
				$this->tax['field']		= 'term_id';
				$this->tax['terms']		= esc_attr( $_REQUEST['auto-model'] );
				
				// Format Tax Query
				$this->taxQuery['autoModel'] = array(
					'taxonomy'	=> $this->tax['taxonomy'],
					'field'		=> $this->tax['field'],
					'terms'		=> $this->tax['terms']
				);
		}
		##################################################
		# SEARCH CARS BY BODY
		##################################################
		$this->taxQuery['autoBody'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-make'] ) && !empty( $_REQUEST['auto-make'] ) ) {
			
			// Store Search Parameters
			$this->tax['taxonomy']	= 'auto-body';
			$this->tax['field']		= 'term_id';
			$this->tax['terms']		= esc_attr( $_REQUEST['auto-body'] );
			
			// Format Tax Query
			$this->taxQuery['autoMake'] = array(
				'taxonomy'	=> $this->tax['taxonomy'], 
				'field' 	=> $this->tax['field'], 
				'terms' 	=> $this->tax['terms']
			);
			
		}
		##################################################
		# SEARCH CARS BY MADE YEAR FROM
		##################################################
		$this->metaQuery['autoYear'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-year'] ) && !empty( $_REQUEST['auto-year'] ) && empty( $_REQUEST['auto-year-to'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoYear'] = '_auto_year';
			$this->metaVal['autoYear'] = esc_attr( $_REQUEST['auto-year'] );
			
			// Format Meta Query
			$this->metaQuery['autoYear'] = array( 
				'key'	=> $this->metaKey['autoYear'], 
				'value' => $this->metaVal['autoYear']
			);
			
		}
		else
		##################################################
		# SEARCH CARS BY MADE YEAR TO
		##################################################
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-year-to'] ) && !empty( $_REQUEST['auto-year-to'] ) && empty( $_REQUEST['auto-year'] ) ) {
			
			// Format Meta Query
			$this->metaKey['autoYear'] = '_auto_year';
			$this->metaVal['autoYear'] = esc_attr( $_REQUEST['auto-year-to'] );
			
			// Format Meta Query
			$this->metaQuery['autoYear'] = array(
				'key'		=> $this->metaKey['autoYear'],
				'value'		=> $this->metaVal['autoYear'],
				'compare'	=> '>=',
				'type'		=> 'numeric'
			);
		}
		else
		##################################################
		# IF CAR YEAR FROM && CAR YEAR TO
		##################################################
		if( isset( $_POSt['search-autos'] ) && !empty( $_REQUEST['auto-year'] ) && !empty( $_REQUEST['auto-year-to'] ) ) {
			
			// Format Meta Key
			$this->metaKey['autoYear'] 	= '_auto_year';
			
			// Format Meta Value
			$this->metaVal['autoYear']	= esc_attr( $_REQUEST['auto-year'] );
			$this->metaVal['autoYearTo']	= esc_attr( $_REQUEST['auto-year-to'] );
			
			// Format Meta Query
			$this->metaQuery['autoYear'] = array(
				'key'		=> $this->metaKey['autoYear'],
				'value'		=> array( $this->metaVal['autoYear'], $this->metaVal['autoYearTo'] ),
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY FUEL STATUS - @since v0.7
		##################################################
		$this->metaQuery['autoFuel'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-fuel'] ) && !empty( $_REQUEST['auto-fuel'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoFuel'] = '_auto_fuel';
			$this->metaVal['autoFuel'] = esc_attr( $_REQUEST['auto-fuel'] );
			
			// Format Meta Query
			$this->metaQuery['autoFuel'] = array(
				'key'	=> $this->metaKey['autoFuel'],
				'value'	=> $this->metaVal['autoFuel']
			);
		}
		##################################################
		# SEARCH CARS BY CONDITION STATUS
		##################################################
		$this->metaQuery['autoCondition'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-condition'] ) && !empty( $_REQUEST['auto-condition'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoCondition'] = '_auto_condition';
			$this->metaVal['autoCondition'] = esc_attr( $_REQUEST['auto-condition'] );
			
			// Format Meta Query
			$this->metaQuery['autoCondition'] = array( 
				'key'	=> $this->metaKey['autoCondition'], 
				'value' => $this->metaVal['autoCondition']
			);
			
		}
		##################################################
		# SEARCH CARS BY PRICE
		##################################################
		$this->metaQuery['autoPrice'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-price'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoPrice'] 		= '_auto_price';
			$this->metaVal['autoPrice'] 		= esc_attr( $_REQUEST['auto-price'] );
			
			// Extract lowest & highest prices
			$price = $this->metaVal['autoPrice'];
			$price = explode( ';', $price );
			
			// Save lowest & highest prices into variables
			$this->priceSta = $price[0];
			$this->priceEnd = $price[1];
			
			// Format Meta Query
			$this->metaQuery['autoPrice'] = array(
				'key'		=> $this->metaKey['autoPrice'],
				'value'		=> array( $this->priceSta, $this->priceEnd ),
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY MILEAGE
		##################################################
		$this->metaQuery['autoMileage'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-mileage'] ) && !empty( $_REQUEST['auto-mileage'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoMileage'] = '_auto_mileage';
			$this->metaVal['autoMileage'] = esc_attr( $_REQUEST['auto-mileage'] );
			
			// Extract lowest & highest mileages
			$mileage = $this->metaVal['autoMileage'];
			$mileage = explode( ';', $mileage );
			
			// Save lowest & highest mileages into variables
			$this->mileageSta = $mileage[0]; // Mileage start from
			$this->mileageEnd = $mileage[1]; // Mileage end from

			// Format Meta Query
			$this->metaQuery['autoMileage'] = array( 
				'key'		=> $this->metaKey['autoMileage'], 
				'value'		=> array( $this->mileageSta, $this->mileageEnd ), 
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY LOCATION
		##################################################
		$this->metaQuery['autoLocation'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-location'] ) && !empty( $_REQUEST['auto-location'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoLocation'] = '_seller_country';
			$this->metaVal['autoLocation'] = esc_attr( $_REQUEST['auto-location'] );
			
			// Format Meta Query
			$this->metaQuery['autoLocation'] = array(
				'key'	=> $this->metaKey['autoLocation'],
				'value'	=> $this->metaVal['autoLocation']
			);
		}
		##################################################
		# LIST CURRENT USER CLASSIFIEDS pixad=my-pixads
		##################################################
		if( isset( $_GET['pixad'] ) && $_GET['pixad'] == 'my-pixads' ) {
			
			$author = get_current_user_id();
			$author = 'post_type=pixad-autos&author='.$author;
			
			return $author;
		}

		$per_page = $this->per_page ? $this->per_page : $per_page;
		
		// If search button fired, show autos by search parameters
		if( isset( $_REQUEST['search-autos'] ) ) {
			
			// Format query to output selected autos
			$this->Query = array(
				'post_type'			=> 'pixad-autos',
				'posts_per_page' 	=> $per_page,
				'orderby' 			=> $this->orderby,
				'order' 			=> $this->order,
				'meta_key' 			=> $this->metakey,
				'tax_query' 		=> array( $this->taxQuery['autoMake'], $this->taxQuery['autoModel'] ),
				'meta_query' 		=> array( 
					$this->metaQuery['autoYear'],
					$this->metaQuery['autoFuel'],
					$this->metaQuery['autoCondition'],
					$this->metaQuery['autoPrice'],
					$this->metaQuery['autoMileage'],
					$this->metaQuery['autoLocation']
				),
				'paged' 			=> $paged
			);
			
		} else { // Else if search not fired show all autos
			
			/**
			 * Auto Make [pixad_autos make='Audi']
			 * ================================
			 * @since 0.4
			 */
			if( $make !== 'all' ) {
				
				// Remove blank space from make
				if( preg_match( '/ /', $make ) )
					$make = str_replace( ' ', '', $make );
				
				// If multiple makes added
				if( preg_match( '/,/', $make ) )
					$make = explode( ',', $make );

				
				// Format meta query
				$autoMake = array(
					'taxonomy'	=> 'auto-model', 
					'field' 	=> 'slug', 
					'terms' 	=> $make
				);
			}
			
			/**
			 * Auto Model [pixad_autos model='a4']
			 * ================================
			 * @since 0.4
			 */
			if( $model !== 'all' ) {
				
				// Remove blank space from model
				if( preg_match( '/ /', $model ) )
					$model = str_replace( ' ', '', $model );
				
				// If multiple models added
				if( preg_match( '/,/', $model ) )
					$model = explode( ',', $model );
				
				// Convert string to lowercase
				if( is_array( $model ) ) {
					$model = array_map( 'strtolower', $model );
				}else{
					$model = strtolower( $model );
				}
				
				// Format meta query
				$autoModel = array(
						'taxonomy'	=> 'auto-model',
						'field'		=> 'slug',
						'terms'		=> $model
				);
			}
			
			/**
			 * Auto Body [pixad_autos body='a4']
			 * ================================
			 * @since 0.4
			 */
			if( $body !== 'all' ) {
				
				// Remove blank space from body
				if( preg_match( '/ /', $body ) )
					$body = str_replace( ' ', '', $body );
				
				// If multiple bodies added
				if( preg_match( '/,/', $body ) )
					$body = explode( ',', $body );
				
				// Convert string to lowercase
				if( is_array( $body ) ) {
					$body = array_map( 'strtolower', $body );
				}else{
					$body = strtolower( $body );
				}
				
				// Format meta query
				$autoModel = array(
					'taxonomy'	=> 'auto-body',
					'field'		=> 'slug',
					'terms'		=> $body
				);
			}
			
			/**
			 * Auto Year [pixad_autos year='2015']
			 * ================================
			 * @since 0.4
			 */
			if( $year !== 'all' ) {
				
				// Remove blank space from year
				if( preg_match( '/ /', $year ) )
					$year = str_replace( ' ', '', $year );
				
				// If multiple years added
				if( preg_match( '/,/', $year ) ) 
					$year = explode( ',', $year );
				
				// Format meta query
				$autoYear = array(
					'key'	=> '_auto_year',
					'value'	=> $year
				);
			}
			
			/**
			 * Auto Fuel [pixad_autos fuel='diesel']
			 * =========================================
			 * @since 0.7
			 */
			if( $fuel !== 'all' ) {
				
				// Remove blank space from fuel
				if( preg_match( '/ /', $fuel ) )
					$fuel = str_replace( ' ', '', $fuel );
				
				// If multiple fuel added
				if( preg_match( '/,/', $fuel ) )
					$fuel = explode( ',', $fuel );
				
				// Convert string to lowercase
				if( is_array( $fuel ) ) {
					$fuel = array_map( 'strtolower', $fuel );
				}else{
					$fuel = strtolower( $fuel );
				}
				
				// Format Meta Query
				$autoFuel = array(
					'key'	=> '_auto_fuel',
					'value'	=> $fuel
				);
			}
			
			/**
			 * Auto Condition [pixad_autos condition='new']
			 * =========================================
			 * @since 0.4
			 */
			if( $condition !== 'all' ) {
				
				// Remove blank space from condition
				if( preg_match( '/ /', $condition ) )
					$condition = str_replace( ' ', '', $condition );
				
				// If multiple conditions added
				if( preg_match( '/,/', $condition ) )
					$condition = explode( ',', $condition );
				
				// Convert string to lowercase
				if( is_array( $condition ) ) {
					$condition = array_map( 'strtolower', $condition );
				}else{
					$condition = strtolower( $condition );
				}
				
				// Format meta query
				$autoCondition = array(
					'key'	=> '_auto_condition',
					'value'	=> $condition
				);
			}
			
			/**
			 * Auto Mileage [pixad_autos mileage='120000']
			 * ========================================
			 * @since 0.4
			 */
			if( $mileage !== 'all' ) {
				
				// Remove blank space from mileage
				if( preg_match( '/ /', $mileage ) )
					$mileage = str_replace( ' ', '', $mileage );
				
				// Remove dot from mileage
				if( preg_match( '/./', $mileage ) )
					$mileage = str_replace( '.', '', $mileage );
				
				// If multiple mileages added
				if( preg_match( '/,/', $mileage ) )
					$mileage = explode( ',', $mileage );
				
				// Format meta query
				$autoMileage = array(
					'key'	=> '_auto_mileage',
					'value'	=> $mileage
				);
			}
			
			/**
			 * Auto Price [pixad_autos price='15000']
			 * ===================================
			 * @since 0.4
			 */
			if( $price !== 'all' ) {
				
				// Remove blank space from price
				if( preg_match( '/ /', $price ) )
					$price = str_replace( ' ', '', $price );
				
				// Remove dot from price
				if( preg_match( '/./', $price ) )
					$price = str_replace( '.', '', $price );
				
				// If multiple prices added
				if( preg_match( '/,/', $price ) )
					$price = explode( ',', $price );

				if(is_array($price) && $price[1] >= $settings['autos_max_price'] && $price[0] <= $price[1]){
					// Format meta query
					$autoPrice = array(
						'key'     => '_auto_price',
						'value'   => $price[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}elseif(is_array($price) && $price[1] < $settings['autos_max_price'] && $price[0] <= $price[1]) {
					// Format meta query
					$autoPrice = array(
							'key' => '_auto_price',
							'value' => $price,
							'type' => 'numeric',
							'compare' => 'BETWEEN'
					);
				}else{
					$autoPrice = array(
						'key'     => '_auto_price',
						'value'   => $price[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}
			}
			$autoMake		= isset( $autoMake ) ? $autoMake : '';
			$autoModel		= isset( $autoModel ) ? $autoModel : '';
			$autoYear		= isset( $autoYear ) ? $autoYear : '';
			$autoFuel		= isset( $autoFuel ) ? $autoFuel : '';
			$autoCondition	= isset( $autoCondition ) ? $autoCondition : '';
			$autoMileage	= isset( $autoMileage ) ? $autoMileage : '';
			$autoPrice		= isset( $autoPrice ) ? $autoPrice : '';
			
			// Format query to output all autos
			$this->Query = array(
				'post_type' 		=> 'pixad-autos',
				'p'                 => $auto_id,
				'posts_per_page' 	=> $per_page,
				'orderby' 			=> $this->orderby,
				'order' 			=> $this->order,
				'meta_key' 			=> $this->metakey,
				'tax_query'			=> array( $autoMake, $autoModel ),
				'meta_query'		=> array(
					$autoYear,
					$autoFuel,
					$autoCondition,
					$autoMileage,
					$autoPrice
				),
				'paged' 			=> $paged
			);
			
		}
		return $this->Query;
	}
	
	/**
	 * Loop auto make's in text loop
	 * OUTPUT: eg: Audi, BMW ...
	 * 
	 * @return array
	 */
	 public function loop_make() {
		
		$tax_terms = get_terms( 
			'auto-model', 
			'orderby=name&order=ASC&hide_empty=0&hierarchical=0' 
		);
		
		if( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				
				// Loop only parent terms
				if( $tax_term->parent == '0' ) {
					$terms[] = $tax_term;
				}
			}
		
			return $terms;
		}
	 }
	
	/**
	 * Loop auto model's in text loop
	 * OUTPUT: A4, X5 ...
	 *
	 * @return array
	 */
	 public function loop_model() {
		
		$tax_terms = get_terms( 
			'auto-model', 
			'orderby=name&order=ASC&hide_empty=0&hierarchical=0'
		);
		
		if( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				
				// Loop only child terms
				if( $tax_term->parent !== '0' ) {
					$terms[] = $tax_term;
				}
				
			}
			
			return $terms;
		}
	 }
	 
	/**
	 * Loop auto year in number loop
	 * OUTPUT: 1930, 1931 ...
	 *
	 * @return array
	 */
	 public function year() {
		$numbers = range( 2015, 1930 );
	
		foreach( $numbers as $number ) {
			$array[] = $number;
		}
		
		return $array;
	 }
	 
	/**
	 * Get auto make on single post (Frontend)
	 *
	 * @return array
	 */
	 public function get_make() {
		global $post;
		
		$args = array(
			'orderby'	=> 'name',
			'order'		=> 'ASC',
			'fields'	=> 'all'
		);
		
		$tax_terms = wp_get_post_terms($post->ID, 'auto-model', $args);
		
		foreach ($tax_terms as $tax_term) {
			
			// Loop only parent terms
			if( $tax_term->parent == '0' ) {
				return  $tax_term->name;
			}
			
		}
	 }
	 
	/**
	 * Get auto model on single post (Frontend)
	 * 
	 * @return array
	 */
	 public function get_model() {
		global $post;
		
		$args = array(
			'orderby'	=> 'name',
			'order'		=> 'ASC',
			'fields'	=> 'all'
		);
		
		$tax_terms = wp_get_post_terms($post->ID, 'auto-model', $args);
		
		foreach ($tax_terms as $tax_term) {
			
			// Loop only child terms
			if( $tax_term->parent ) {
				return  $tax_term->name;
			}
			
		}
	 }
	 
	/**
	 * Get auto meta details (Frontend)
	 * Loop (if ID provided) else Single pages
	 * 
	 * @return string
	 */
	public function get_meta( $key ) {
		return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
	}
	
	/**
	 * Get properly formated auto price
	 * ===============================
	 * @since 0.4
	 */
	public function get_price( $period = '', $price = NULL ) {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
		$currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); // Get currencies from database
		
		$auto_currency	= $this->get_meta('_auto_currency'); // Get auto currency
		
		// If auto price not specified, let's pull price from database
		$auto_price = isset( $price ) ? $price : $this->get_meta('_auto_price');
		
		// If auto price not set, set by default 100
		if( empty( $auto_price ) ) $auto_price = 100;
		
		// Format price like 100,00
		$auto_price = number_format($auto_price, $settings['autos_decimal_number'], "{$settings['autos_decimal']}", "{$settings['autos_thousand']}");
		
		// Take only currency we are interest in and get details from it
		$currency = $currencies[$settings['autos_site_currency']];
		
		// If currency symbol or position missing let's set default ones
		if( !$currency['symbol'] ) $currency['symbol'] = '$';
		if( !$currency['position'] ) $currency['position'] = 'right';
		
		// Format auto price & currency output
		switch( $currency['position'] ):
		
			case $currency['position'] == 'left':
				 $price = $currency['symbol'].$auto_price;
			break;
			
			case $currency['position'] == 'right':
				 $price = $auto_price.$currency['symbol'];
			break;
			
			case $currency['position'] == 'left_space':
				 $price = $currency['symbol'].' '.$auto_price;
			break;
			
			case $currency['position'] == 'right_space':
				 $price = $auto_price.' '.$currency['symbol'];
			break;
		
		endswitch;
		
		return $price.$period;
	}
	
	/**
	 * Get Meta Minimum && Maximum Values
	 * Loop Trough PostMeta, Take All Values
	 * & Return Min & Max Values
	 *
	 * @since 0.3
	 * @return array
	 */
	public function get_meta_min_max( $meta_key ) {
		global $wpdb;
		
		$meta_val = $wpdb->get_col( $wpdb->prepare(
			"
			SELECT meta_value 
			FROM $wpdb->postmeta 
			WHERE meta_key = %s
			",
			$meta_key
		) );
		
		// If found results into database
		if( !empty( $meta_val[0] ) ) {
			foreach( $meta_val as $values ) {
				$value[] = $values;
			}
			
			$value = array_filter( $value ); // Filter array
			
			// Take value min & max values
			$value_min = min( $value );
			$value_max = max( $value );
		}

		// If price min empty
		if( empty( $value_min ) ) {
			$value_min = '1';
		}

		// If price max empty
		if( empty( $value_max ) ) {
			$value_max = '500000';
		}

		return array(
			'min' => $value_min,
			'max' => $value_max
		);
	}
	
	/**
	 * Add Strings for Translation
	 *
	 * @since 0.4
	 */
	public function translation() {
		return array(
			__( 'fixed', 'pixautodeal' ),
			__( 'automatic', 'pixautodeal' ),
			__( 'electric', 'pixautodeal' ),
			__( 'diesel', 'pixautodeal' ),
			__( 'gasoline', 'pixautodeal' ),
			__( 'hybrid', 'pixautodeal' ),
			__( 'semi-automatic', 'pixautodeal' )
		);
	}
} 
global $PIXAD_Autos;
$PIXAD_Autos = new PIXAD_Autos();
?>