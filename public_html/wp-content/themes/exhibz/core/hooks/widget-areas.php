<?php if (!defined('ABSPATH')) die('Direct access forbidden.');
/**
 * register widget area
 */

function exhibz_widget_init()
{
    if (function_exists('register_sidebar')) {
        register_sidebar(
            array(
                'name' => esc_html__('Blog widget area', 'exhibz'),
                'id' => 'sidebar-1',
                'description' => esc_html__('Appears on posts.', 'exhibz'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>',
            )
        );
    }
}

add_action('widgets_init', 'exhibz_widget_init');


function footer_left_widgets_init(){
    if ( function_exists('register_sidebar') )
    register_sidebar(array(
      'name' => esc_html__( 'Footer Left', 'exhibz' ),
      'id' => 'footer_left',
      'before_widget' => '<div class="text-left">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    )
  );
}
add_action( 'widgets_init', 'footer_left_widgets_init' );

function footer_center_widgets_init(){
    if ( function_exists('register_sidebar') )
    register_sidebar(array(
      'name' => esc_html__( 'Footer Center', 'exhibz' ),
      'description' => esc_html__( 'Only For Footer Style 3', 'exhibz' ),
      'id' => 'footer_center',
      'before_widget' => '<div class="text-left">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    )
  );
}
add_action( 'widgets_init', 'footer_center_widgets_init' );

function footer_right_widgets_init(){
    if ( function_exists('register_sidebar') )
    register_sidebar(array(
      'name' => esc_html__( 'Footer Right', 'exhibz' ),
      'id' => 'footer_right',
      'before_widget' => '<div class="text-right">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    )
  );
}
add_action( 'widgets_init', 'footer_right_widgets_init' );


function woo_sidebar_widgets_init(){
  if ( function_exists('register_sidebar') )
        register_sidebar(array(
            'name'			 => esc_html__( 'WooCommerce Sidebar', 'exhibz' ),
            'id'			 => 'sidebar-woo',
            'description'	 => esc_html__( 'Appears on posts and pages.', 'exhibz' ),
            'before_widget'	 => '<div id="%1$s" class="widgets %2$s">',
            'after_widget'	 => '</div> <!-- end widget -->',
            'before_title'	 => '<h4 class="widget-title">',
            'after_title'	 => '</h4>',
        )
  );
}

add_action( 'widgets_init', 'woo_sidebar_widgets_init' );