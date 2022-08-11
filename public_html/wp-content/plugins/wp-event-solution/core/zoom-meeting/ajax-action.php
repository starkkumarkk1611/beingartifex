<?php

namespace Etn\Core\Zoom_Meeting;

use Etn\Traits\Singleton;
use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Ajax_Action {
    use Singleton;

    public $textdomain = 'eventin';
    
    public function init() {
        // check conection
        add_action( 'wp_ajax_zoom_connection', [$this, 'zoom_connection'] );

        // for users who are not logged in
        add_action( 'wp_ajax_nopriv_zoom_connection', [$this, 'zoom_connection'] );

        // create meeting
        add_action( 'wp_ajax_elementor_create_meeting', [$this, 'elementor_create_meeting'] );

        // for users who are not logged in
        add_action( 'wp_ajax_nopriv_elementor_create_meeting', [$this, 'elementor_create_meeting'] );
    }

    /**
     * Reservation form submit check
     */
    public function zoom_connection() {
        $response = ['status_code' => 500, 'message' => ['somthing is wrong'], 'data' => []];
        $secured  = Helper::is_secured( 'zoom_nonce', 'zoom_connection_check_nonce', null, $_POST );

        if ( $secured == false && current_user_can( 'manage_options' ) == false ) {
            wp_send_json_error( $response );
        }

        //check for validation
        $post_arr = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

        // Check connection
        if ( is_array( $post_arr ) && count( $post_arr ) > 0 ) {
            $test_conn = json_decode( \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->zoom_api_conn_check() );
            
            if ( !empty( $test_conn ) ) {
                
                if ( !empty( $test_conn->error ) ) {
                    $message  = esc_html__( 'Please check your api connection.', "eventin" );
                    $response = ['status_code' => 125, 'message' => [esc_html__( $message , "eventin" )] ];
                    wp_send_json_error( $response );
                }
                if ( http_response_code() === 200 ) {
                    // remove cache
                    \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->remove_cache();
                    // get host list
                    \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->zoom_meeting_user_list();
                    // send response
                    if ( isset($test_conn->message) ) {
                        $message  = esc_html__( $test_conn->message , "eventin" );
                        $response = ['status_code' => $test_conn->code, 'message' => [esc_html__( $test_conn->message , "eventin" )] ];
                        wp_send_json_error( $response );
                    }
                    else {
                        $response = ['status_code' => 200, 'message' => [esc_html__( 'Api connection is successfull.' , "eventin" )] ];
                        wp_send_json_success( $response );
                    }
                } else {
                    wp_send_json( $test_conn );
                }

            }

        }

        exit;
    }

    /**
     * Elementor create meeting
     */
    public function elementor_create_meeting() {
        $response = ['status_code' => 500, 'message' => [ esc_html__("somthing is wrong","eventin") ], 'data' => []];
        $secured  = Helper::is_secured( 'zoom_nonce', 'zoom_create_meeting_nonce', null, $_POST );

        if ( $secured == false && current_user_can( 'manage_options' ) == false ) {
            wp_send_json_error( $response );
        }

        //check for validation
        $post_arr = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
        if ( is_array( $post_arr ) && !empty( $post_arr ) ) {
            $data = json_decode( \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->create_meeting( $post_arr ) );
            
            if ( $data ) {
                $title      = isset( $post_arr['topic'] ) ? $post_arr['topic'] : "Zoom meeting";
                $post_slug  = sanitize_title_with_dashes( $title, '', 'save' );
                $postslug   = sanitize_title( $post_slug );
                //the array of arguements to be inserted with wp_insert_post
                if ( $post_arr['meeting_id'] =="" ) {

                    $new_post = [
                        'post_title'     => $title,
                        'post_content'   => '',
                        'post_status'    => 'publish',
                        'post_type'      => 'etn-zoom-meeting',
                        'comment_status' => 'closed',
                        'post_name'      => $postslug,
                    ];
    
                    $zoom_post_id     = wp_insert_post( $new_post );
                    
                    $meta_array                 = [
                        'zoom_topic'      => $title,
                        'zoom_start_time' => $post_arr['start_time'],
                        'zoom_timezone'   => $post_arr['timezone'],
                        'zoom_duration'   => $post_arr['duration'],
                        'zoom_password'   => $post_arr['password'],
                        'zoom_meeting_id' => $data->id,
                    ];

                    if ( is_array( $meta_array ) && count( $meta_array ) > 0 && $zoom_post_id !== 0 ) {
    
                        foreach ( $meta_array as $key => $value ) {
                            update_post_meta( $zoom_post_id , $key , $value );
                        }
        
                    }
                }
                $response = ['status_code' => 201, 'message' => ['Meeting create successfully.','eventin'], 'data' => $data];
            } else {
                $response = ['status_code' => 401, 'message' => ['Something is wrong.','eventin'], 'data' => []];
            }
            wp_send_json_success( $response );
        }
        exit;
    }

}
