<?php if ( !defined( 'FW' ) ) {	die( 'Forbidden' ); }

$options = array(
	'settings-event-banner' => array(
		'title'		 => esc_html__( 'Event Settings', 'courselog' ),
		'type'		 => 'box',
		'priority'	 => 'high',
		'options'	 => array(
			'event_banner_image'	 => array(
				'label'	 => esc_html__( 'Event Banner image', 'courselog' ),
				'desc'	 => esc_html__( 'Upload a event banner image', 'courselog' ),
				'help'	 => esc_html__( "This default event banner image will be used for your event.", 'courselog' ),
				'type'	 => 'upload'
			),
		),
	),
	
);
