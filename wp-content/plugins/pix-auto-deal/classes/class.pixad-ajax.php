<?php


class PIXAD_Ajax {


	public $autos_per_page;

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
		add_action( 'wp_enqueue_scripts', array( $this, 'init_plugin' ) );
        add_action( 'wp_ajax_process_reservation', array( $this, 'process_reservation' ) );
        add_action( 'wp_ajax_nopriv_process_reservation', array( $this, 'process_reservation' ) );
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
		global $PIXAD_Autos;
	    $data = array_map( 'esc_attr', $_GET );

        check_ajax_referer( 'process_reservation_nonce', 'nonce' );

        if( true && isset($data['autos_per_page']) ){

            $PIXAD_Autos->autos_per_page = $data['autos_per_page'];
            $rentax_loop = new WP_Query( $PIXAD_Autos->Query_Args( false ) );
            $pixad_out = '';
            include( dirname( __FILE__ ) . '/../includes/templates/autos_listing.php' );
			wp_send_json_success($PIXAD_Autos->autos_per_page);

        }
        elseif( true && isset($data['order']) ){

            $temp = explode('-', $data['order']);

            if(isset($temp[0]) && in_array($temp[0], $PIXAD_Autos::$orderby_arr)){
                $PIXAD_Autos->orderby = $temp[0];
                $PIXAD_Autos->order = strtoupper($temp[1]);
                $PIXAD_Autos->metakey = '';
            }
            elseif(isset($temp[0]) && !in_array($temp[0], $PIXAD_Autos::$orderby_arr)){
                $PIXAD_Autos->orderby = 'meta_value_num';
                $PIXAD_Autos->order = strtoupper($temp[1]);
                $PIXAD_Autos->metakey = $temp[0];
            }
            $rentax_loop = new WP_Query( $PIXAD_Autos->Query_Args( false ) );
            $pixad_out = '';
            include( dirname( __FILE__ ) . '/../includes/templates/autos_listing.php' );
			wp_send_json_success($PIXAD_Autos->autos_per_page);

        }
        else
            wp_send_json_error( array( 'error' => $custom_error ) );
    }

}
global $PIXAD_Ajax;
$PIXAD_Ajax = new PIXAD_Ajax();
?>