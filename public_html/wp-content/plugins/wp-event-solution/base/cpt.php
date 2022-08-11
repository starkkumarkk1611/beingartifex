<?php

namespace Etn\Base;

defined( 'ABSPATH' ) || exit;

/**
 * Cpt Abstract Class.
 * Cpt Abstract class for custom post type of Builders.
 *
 * @since 1.0.0
 */
abstract class Cpt {

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct() {

        // get custom post type name
        $name = $this->get_name();
        // get custom post optios data
        $args = $this->post_type();

        if( $this->create_cpt() ){
            // register custom post type
            add_action( 'init', 
                function () use ( $name, $args ) {
                    register_post_type( $name, $args );
                } 
            );
        }
    }

    public abstract function post_type();
}
