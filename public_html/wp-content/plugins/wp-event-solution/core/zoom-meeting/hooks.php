<?php

namespace Etn\Core\Zoom_Meeting;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public $cpt;
    public $base;
    public $category;
    public $tags;
    public $settings;
    public $event_action;
    public $post_type = 'etn-zoom-meeting';

    /**
     * Main hook function
     *
     * @return void
     */
    public function init() {

        $settings    = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $zoom_module = ! empty( $settings['etn_zoom_api'] ) ? true : false;
        
        if( $zoom_module ) {
            // working Zoom module
            \Etn\Core\Zoom_Meeting\Cpt::instance();

              // category
            \Etn\Core\Zoom_Meeting\Category::instance();
            // tag
            \Etn\Core\Zoom_Meeting\Tags::instance();

            // call ajax submit
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                \Etn\Core\Zoom_Meeting\Ajax_Action::instance()->init();
            }
                  
            // custom post meta
            $_metabox = new \Etn\Core\Zoom_Meeting\Zoom_Meeting_Meta();
            add_action( 'add_meta_boxes', [$_metabox, 'register_meta_boxes'] );
            add_action( 'save_post', [$_metabox, 'save_meta_box_data'] );
            add_filter( 'wp_insert_post_data', [$_metabox, 'save_zoom_meta_data'], 500, 2 );
            add_action( 'admin_notices', [$_metabox, 'admin_notices'] );

            //Add column
            add_filter( 'manage_etn-zoom-meeting_posts_columns', [$this, 'zoom_column_headers'] );
            add_action( 'manage_etn-zoom-meeting_posts_custom_column', [$this, 'zoom_column_data'], 10, 2 );

            // Disable gutenberg
            add_filter('use_block_editor_for_post_type', [$_metabox, 'disable_gutenberg'],10,2);
        }
    }

    /**
     * Column name
     */
    public function zoom_column_headers( $columns ) {
        $new_item["id"] = esc_html__( "Id", "eventin" );
        $new_array      = array_slice( $columns, 0, 1, true ) + $new_item + array_slice( $columns, 1, count( $columns ) - 1, true );
        return $new_array;
    }

    /**
     * Return row
     */
    public function zoom_column_data( $column, $post_id ) {

        switch ( $column ) {
        case 'id':
            echo intval( $post_id );
            break;
        }

    }

}
