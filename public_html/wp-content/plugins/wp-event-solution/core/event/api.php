<?php

namespace Etn\Core\Event;

use \Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Api extends \Etn\Base\Api_Handler {

    /**
     * define prefix and parameter patten
     *
     * @return void
     */
    public function config() {
        $this->prefix = 'event';
        $this->param  = ''; // /(?P<id>\w+)/
    }

    /**
     * get user profile when user is logged in
     *
     * @return array status_code, messages, content
     */
    public function get_events() {

        $status_code    = 0;
        $messages       = $content      = [];
        $request        = $this->request;
        
        // pass input field for checking empty value
        $inputs_field = [
            ['name' => 'month', 'required'  => true, 'type' => 'number'],
            ['name' => 'year', 'required'   => true, 'type' => 'number'],
        ];

        $validation = Helper::input_field_validation( $request, $inputs_field );

        if ( !empty( $validation['status_code'] ) && $validation['status_code'] == true ) {
            $input_data = $validation['data'];
            $month      = sprintf("%02d", $input_data['month']);
            $year       = $input_data['year'];
            $event_list = Helper::get_events_by_date( $month, $year );

            if ( !empty( $event_list ) ) { // empty means no error message, proceed
                $status_code            = 1;
                $content                = $event_list;
                $messages['success']    = 'success';
            } else {
                $messages['error']      = 'error';
            }

        } else {
            $status_code = $validation['status_code'];
            $messages    = $validation['messages'];
        }

        return [
            'status_code' => $status_code,
            'messages'    => $messages,
            'content'     => $content,
        ];

    }

}

new Api();