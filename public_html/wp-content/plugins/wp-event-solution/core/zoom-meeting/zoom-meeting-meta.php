<?php

namespace Etn\Core\Zoom_Meeting;

use Etn\Core\Metaboxs\Event_manager_metabox;

defined( 'ABSPATH' ) || exit;

class Zoom_Meeting_Meta extends Event_manager_metabox {
    public $metabox_id   = 'etn_zoom_meeting_settings';
    public $event_fields = [];
    public $cpt_id       = 'etn-zoom-meeting';

    public function register_meta_boxes() {
        add_meta_box( 
            $this->metabox_id, 
            esc_html__( 'Create a New Meeting', 'eventin' ), 
            [$this, 'display_callback'], 
            $this->cpt_id 
        );
    }

    /**
     * metabox data function
     *
     * @return void
     */
    public function etn_zoom_meeting_meta_fields() {
        // get host list
        $user_list = \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->zoom_meeting_user_list();
        // get time zone
        $time_zone = \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->get_timezone();

        $this->event_fields = [
            'zoom_meeting_id'   => [
                'label'    => esc_html__( 'Meeting ID', 'eventin' ),
                'desc'     => esc_html__( 'Meeting ID will be generated automatically after creating a meeting successfully', 'eventin' ),
                'type'     => 'text',
                'value'    => "",
                'priority' => 1,
                'readonly' => true,
                'disabled' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'zoom_meeting_host' => [
                'label'    => esc_html__( 'Meeting Host', 'eventin' ),
                'desc'     => esc_html__( 'Select a host of meeting.(Required)', 'eventin' ),
                'type'     => 'select_single',
                'options'  => $user_list,
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'zoom_start_time'   => [
                'label'    => esc_html__( 'Start Date/Time', 'eventin' ),
                'desc'     => esc_html__( 'Select start date and time.(Required)', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'zoom_timezone'     => [
                'label'    => esc_html__( 'Time Zone', 'eventin' ),
                'desc'     => esc_html__( 'Select timezone for meeting .(Optional)', 'eventin' ),
                'type'     => 'select_single',
                'options'  => $time_zone,
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'zoom_duration'     => [
                'label'    => esc_html__( 'Duration', 'eventin' ),
                'desc'     => esc_html__( 'Meeting duration (minutes).(Optional)', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'zoom_password'     => [
                'label'    => esc_html__( 'Password', 'eventin' ),
                'desc'     => esc_html__( 'Password to join the meeting. Password may only contain the following characters: [a-z A-Z 0-9]. Max of 10 characters.( Leave blank for auto generate )', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],
        ];
        return $this->event_fields;
    }

    public function banner_meta_field() {
        return [];
    }

    /**
     * Save metabox data and call api function
     */
    public function save_zoom_meta_data( $data, $postarr ) {
        
        if ( 'etn-zoom-meeting' == $data['post_type'] && is_array( $postarr ) && isset( $postarr['zoom_meeting_host'] ) ) {
            $meeting_id                 = get_post_meta( $postarr['ID'], 'zoom_meeting_id', true );
            $request_data               = [];
            $request_data['topic']      = sanitize_text_field( $postarr['post_title'] );
            $request_data['start_time'] = sanitize_text_field( $postarr['zoom_start_time'] );
            $request_data['timezone']   = sanitize_text_field( $postarr['zoom_timezone'] );
            $request_data['duration']   = sanitize_text_field( $postarr['zoom_duration'] );
            $request_data['password']   = empty( $postarr['zoom_password'] ) ? $postarr['ID'] : sanitize_text_field( $postarr['zoom_password'] );
            $meta_array                 = [];

            if ( empty( $meeting_id ) ) {
                $request_data['user_id'] = sanitize_text_field( $postarr['zoom_meeting_host'] );
                // create meeting
                $meeting_data = json_decode( \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->create_meeting( $request_data ) );

                if ( is_object( $meeting_data ) ) {
                    $meta_array = [
                        'zoom_join_url'        => $meeting_data->join_url,
                        'zoom_start_url'       => $meeting_data->start_url,
                        'zoom_meeting_id'      => $meeting_data->id,
                        'zoom_meeting_type'    => $meeting_data->type,
                        'zoom_meeting_status'  => $meeting_data->status,
                        'zoom_meeting_host_id' => $meeting_data->host_id,
                        'zoom_topic'           => $meeting_data->topic,
                        'zoom_start_time'      => $meeting_data->start_time,
                        'zoom_timezone'        => $meeting_data->timezone,
                        'zoom_duration'        => $meeting_data->duration,
                        'zoom_password'        => $meeting_data->password,
                    ];
                }

            } else {
                $request_data['meeting_id'] = $meeting_id;
                $meeting_data               = json_decode( \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->create_meeting( $request_data ) );
                $meta_array                 = [
                    'zoom_topic'      => $request_data['topic'],
                    'zoom_start_time' => $request_data['start_time'],
                    'zoom_timezone'   => $request_data['timezone'],
                    'zoom_duration'   => $request_data['duration'],
                    'zoom_password'   => $request_data['password'],
                ];
            }
            
            if ( is_array( $meta_array ) && count( $meta_array ) > 0 ) {

                foreach ( $meta_array as $key => $value ) {
                    update_post_meta( $postarr['ID'], $key, $value );
                }

            }

            if ( is_object( $meeting_data ) && !empty( $meeting_data->code ) ) {

                if ( $meeting_data->code === 429 ) {
                    $_SESSION['zoom_meeting_notice'] = $meeting_data->message;
                }

            }

        }

        return $data;
    }

    public function admin_notices() {

        if ( !empty( $_SESSION['zoom_meeting_notice'] ) ) {
            ?>
            <div class="alert alert-warning"><?php echo esc_html__( $_SESSION['zoom_meeting_notice'], 'eventin' ) ?> </div>
            <?php
            session_destroy();
        }

    }

    /**
     * Disable gutenberg for zoom meeting
     */
    public function disable_gutenberg( $is_enabled, $post_type ) {
        if ($post_type === 'etn-zoom-meeting') return false; 
        return $is_enabled;
    }

}
