<?php

namespace Etn\Core\Attendee;

use \Etn\Core\Attendee\Attendee_List;
use \Etn\Core\Attendee\Pages\Attendee_Single_Page;


defined( "ABSPATH" ) || exit;

class Hooks {
    use \Etn\Traits\Singleton;

    public $cpt;
    public $action;
    public $base;
    public $settings;
    public $actionPost_type = ['etn-attendee'];

    public function Init() {

        $settings        = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $attendee_module = ! empty( $settings['attendee_registration'] ) ? true : false;
        
        if( $attendee_module ) {
            $this->cpt      = new Cpt();
            $this->action   = new Action();
            $this->settings = new Settings( "etn", "1.0" );

            $this->add_metaboxes();
            $this->add_single_page_template();
        }
    }

    public function add_metaboxes() {

        // custom post meta
        $attendee_meta = new \Etn\Core\Metaboxs\Attendee_Meta();
        add_action( 'add_meta_boxes', [$attendee_meta, 'register_meta_boxes'] );
        add_action( 'save_post', [$attendee_meta, 'save_meta_box_data'] );

    }

    function add_single_page_template() {
        $page = new Attendee_Single_Page();
    }

}
