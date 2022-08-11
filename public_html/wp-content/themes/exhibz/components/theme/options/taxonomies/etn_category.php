<?php if (!defined('ABSPATH')) die('Direct access forbidden.');

$options = array(

    'event_category_featured_img' => [
        'label'	        => esc_html__( 'upload feature image', 'exhibz' ),
        'desc'	        => esc_html__( 'This will be used as the image', 'exhibz' ),
        'type'	        => 'upload',
    ],
); 