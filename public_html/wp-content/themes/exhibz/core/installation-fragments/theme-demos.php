<?php

function exhibz_fw_ext_backups_demos( $demos ) {
	$demo_content_installer	 = 'https://demo.themewinter.com/wp/demo-content/exhibz';
	$demos_array			 = array(
		'default'			 => array(
			'title'			 => esc_html__( 'Main Demo (01-11)', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/default/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'onepage'			 => array(
			'title'			 => esc_html__( 'One Page', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/onepage/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'foodfestival'			 => array(
			'title'			 => esc_html__( 'Food Festival Home', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/foodfestival/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'education'			 => array(
			'title'			 => esc_html__( 'Education Home', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/education/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'classic20'			 => array(
			'title'			 => esc_html__( 'Classic20 Home', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/classic20/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'woo'			 => array(
			'title'			 => esc_html__( 'Exhibz woo', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/woo/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'multi_event'			 => array(
			'title'			 => esc_html__( 'Multi Event', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/multi_event/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		'creative_conference'			 => array(
			'title'			 => esc_html__( 'Creative Conference', 'exhibz' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/creative_conference/screenshot.png',
			'preview_link'	 => esc_url( 'http://themeforest.net/user/tripples/portfolio' ),
		),
		
	);

	$download_url			 = esc_url( $demo_content_installer ) . '/manifest.php';
	foreach ( $demos_array as $id => $data ) {
		$demo						 = new FW_Ext_Backups_Demo( $id, 'piecemeal', array(
			'url'		 => $download_url,
			'file_id'	 => $id,
		) );
		$demo->set_title( $data[ 'title' ] );
		$demo->set_screenshot( $data[ 'screenshot' ] );
		$demo->set_preview_link( $data[ 'preview_link' ] );
		$demos[ $demo->get_id() ]	 = $demo;
		unset( $demo );
	}
	return $demos;
}

add_filter( 'fw:ext:backups-demo:demos', 'exhibz_fw_ext_backups_demos' );