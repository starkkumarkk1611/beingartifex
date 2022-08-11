<?php if (!defined('ABSPATH')) die('Direct access forbidden.');
/**
 * enqueue all theme scripts and styles
 */


// stylesheets
// ----------------------------------------------------------------------------------------
if ( !is_admin() ) {
	// wp_enqueue_style() $handle, $src, $deps, $version
	
	// 3rd party css
	// wp_enqueue_style( 'exhibz-fonts', exhibz_google_fonts_url(['Raleway:400,500,600,700,800,900', 'Roboto:400,700']), null, EXHIBZ_VERSION );
	
	wp_enqueue_style( 'bundle', EXHIBZ_CSS . '/bundle.css', null, EXHIBZ_VERSION );

	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', EXHIBZ_CSS . '/bootstrap.min-rtl.css', null, EXHIBZ_VERSION );
	}
	
	wp_enqueue_style( 'icofont', EXHIBZ_CSS . '/icofont.css', null, EXHIBZ_VERSION );

	if( class_exists('woocommerce') ){
		wp_enqueue_style( 'exhibz-woocommerce', EXHIBZ_CSS . '/woocommerce.css', null, EXHIBZ_VERSION );
	}

	//Enqueue gutenberg front block styles
	wp_enqueue_style( 'exhibz-gutenberg-custom', EXHIBZ_CSS . '/gutenberg-custom.css', null, EXHIBZ_VERSION );

	// theme css
	wp_enqueue_style( 'exhibz-style', EXHIBZ_CSS . '/master.css', null, EXHIBZ_VERSION );

}

// javascripts
// ----------------------------------------------------------------------------------------
if ( !is_admin() ) {

	// bundle js file
	wp_enqueue_script( 'bundle', EXHIBZ_JS . '/bundle.js', array( 'jquery' ), EXHIBZ_VERSION, true );

	if( is_rtl() ){
		wp_enqueue_script( 'bootstrap-rtl', EXHIBZ_JS . '/bootstrap.min-rtl.js', array( 'jquery' ), EXHIBZ_VERSION, true );
	}

	wp_enqueue_script( 'fontfaceobserver',  EXHIBZ_JS . '/fontfaceobserver.js', array( ), true, true );

	// theme scripts
	wp_enqueue_script( 'exhibz-script', EXHIBZ_JS . '/script.js', array( 'jquery' ), EXHIBZ_VERSION, true );

	$exhibz_data = array(
		'event_expire' => esc_html__( 'Expired', 'exhibz'  ) 
	);

	wp_localize_script( 'exhibz-script', 'exhibz_data', $exhibz_data );

	// Load WordPress Comment js
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	add_filter( 'style_loader_tag',  'exhibz_preload_filter', 10, 2 );
	function exhibz_preload_filter( $html, $handle ){
		if (strcmp($handle, 'exhibz-all-style') == 0) {
			$html = str_replace("rel='stylesheet'", "rel='preload' as='style'", $html);
		}
		return $html;
	}
	add_filter( 'script_loader_tag', function ( $tag, $handle ) {
		if ( 'exhibz-all-script' !== $handle )
			return $tag;
	
		return str_replace( ' src', ' defer="defer" src', $tag );
	}, 10, 2 );

}
