<?php
/*
* Plugin Name: Exhibz Essentials
* License - GNU/GPL V2 or Later
* Description: This is a required plugin for Exhibz theme.
* Version: 1.5
* text domain: exhibz-essntial
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add language
add_action( 'init', 'exhibz_language_load' );
function exhibz_language_load(){
    $plugin_dir = basename(dirname(__FILE__))."/languages/";
    load_plugin_textdomain( 'exhibz-essntial', false, $plugin_dir );
}

// main class
class Exhibz_Essentials_Includes {

    // auto load
    // ----------------------------------------------------------------------------------------
	public static function init() {
     
        self::_action_init();
        add_action( 'widgets_init', array( __CLASS__, '_action_widgets_init' ) );
	}


    // directory name to class name, transform dynamically
    // ----------------------------------------------------------------------------------------
	private static function dirname_to_classname( $dirname ) {
		$class_name	 = explode( '-', $dirname );
		$class_name	 = array_map( 'ucfirst', $class_name );
		$class_name	 = implode( '_', $class_name );

		return $class_name;
    }

    // include and register widgets
    // ----------------------------------------------------------------------------------------
	public static function include_widget( $widget_dir ) {
        $rel_path = '/widgets';
        $path = self::get_path( $rel_path ) . '/' . $widget_dir;
        if ( file_exists( $path ) ) {
            self::include_isolated( $path . '/widget-class.php' );
        }

		register_widget( 'Exhibz_' . self::dirname_to_classname( $widget_dir ) );
	}

    // include method
    // ----------------------------------------------------------------------------------------
	public static function include_isolated( $path ) {
        include $path;
	}

    // directory path for theme core
    // ----------------------------------------------------------------------------------------
	private static function get_path( $append = '' ) {
		$path = plugin_dir_path( __FILE__ ) . 'includes';
		return $path . $append;
    }
    
    // include widgets
    // ----------------------------------------------------------------------------------------
	public static function _action_widgets_init() {
        self::include_widget('recent-post');
        self::include_widget('social');
        self::include_widget('footer-address');
    }

    // include files
    // ----------------------------------------------------------------------------------------
	public static function _action_init() {
        self::include_isolated( self::get_path('/post-type/post-class.php') );
        self::include_isolated( self::get_path('/settings/controls-schedule.php') );
        self::include_isolated( self::get_path('/settings/controls-speaker.php') );
    }
}

Exhibz_Essentials_Includes::init();

// exhibz Copyright shortcode
function exhibz_footer_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'text' => 'Copyright &copy; {year} exhibz. All Right Reserved.'
        ), $atts, 'exhibz_footer' );

    $copyright_text = str_replace(['{year}'], [ date('Y')], $atts['text']);
    return esc_html( $copyright_text );
}
add_shortcode('exhibz_footer', 'exhibz_footer_shortcode');