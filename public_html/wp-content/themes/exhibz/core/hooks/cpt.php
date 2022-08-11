<?php if (!defined('ABSPATH')) die('Direct access forbidden.');
//die('cpt found');
/**
 * hooks for wp blog part
 */

// if there is no excerpt, sets a defult placeholder
// ----------------------------------------------------------------------------------------

if ( class_exists( 'ExhibzCustomPost\Exhibz_CustomPost' ) ) {
    //schedule 
	$schedule = new ExhibzCustomPost\Exhibz_CustomPost( 'exhibz' );

	$slug = sanitize_title(get_option('exhibz_schedule_setting_slug','schedule'));
	$plural_name = esc_html(get_option('exhibz_schedule_plural_name','Schedules'));
	$singular_name = esc_html(get_option('exhibz_schedule_singular_name','Schedule'));
	
	if($plural_name==''){
		$plural_name = esc_html__('Schedules','exhibz');
	 }
	 if($singular_name==''){
		$singular_name = esc_html__('Schedule','exhibz'); 
	 }
	 if($slug==''){
		$slug = esc_html__('schedule','exhibz');
	 }
	 $schedule_rewrite = array( 'slug' => $slug);  

	$schedule->xs_init( 'ts-schedule', $singular_name, $plural_name, array( 'menu_icon' => 'dashicons-calendar-alt',
		'supports'	 => array( 'title'),
		'rewrite'	 => $schedule_rewrite,
	) );

	 // schedule category 
	 
	 $schedule_cat_slug = sanitize_title(get_option('exhibz_schedule_cat_setting_slug','Schedule Categories'));
	 $schedule_cat_singular_name = esc_html(get_option('exhibz_schedule_cat_singular_name','Schedule Category'));
	 if($schedule_cat_slug==''){
		$schedule_cat_slug = esc_html__('Schedule Categories','exhibz');
	 }
	 if($schedule_cat_singular_name==''){
		$schedule_cat_singular_name = esc_html__('Schedule Category','exhibz'); 
	 }

	$schedule_tax = new  ExhibzCustomPost\Exhibz_Taxonomies('exhibz');
	$schedule_tax->xs_init('ts-schedule_cat', $schedule_cat_singular_name, $schedule_cat_slug, 'ts-schedule');

	//speaker
	$speaker = new ExhibzCustomPost\Exhibz_CustomPost( 'exhibz' );

	$speaker_slug = sanitize_title(get_option('exhibz_speaker_setting_slug','speaker'));
	$speaker_plural_name = esc_html(get_option('exhibz_speaker_plural_name','Speakers'));
	$speaker_singular_name = esc_html(get_option('exhibz_speaker_singular_name','Speaker'));
 
	if($speaker_plural_name==''){
	   $speaker_plural_name = esc_html__('Speakers','exhibz');
	}
	if($speaker_singular_name==''){
	   $speaker_singular_name = esc_html__('Speaker','exhibz'); 
	}
	if($speaker_slug==''){
	   $speaker_slug = esc_html__('speakers','exhibz');
	}
	$speaker_rewrite = array( 'slug' => $speaker_slug);
	
	$speaker->xs_init( 'ts-speaker', $speaker_singular_name, $speaker_plural_name, array( 'menu_icon' => 'dashicons-admin-users',
		'supports'	 => array( 'title'),
		'rewrite'	 => $speaker_rewrite,
	) );

	// speaker category 

	$speaker_cat_slug = sanitize_title(get_option('exhibz_speaker_cat_setting_slug','Speaker Categories'));
    $speaker_cat_singular_name = esc_html(get_option('exhibz_speaker_cat_singular_name','Speaker Category'));
    if($speaker_cat_slug==''){
       $speaker_cat_slug = esc_html__('Speaker Categories','exhibz');
    }
    if($speaker_cat_singular_name==''){
       $speaker_cat_singular_name = esc_html__('Speaker Category','exhibz'); 
    }
	
	$speaker_tax = new  ExhibzCustomPost\Exhibz_Taxonomies('exhibz');
	$schedule_tax->xs_init('ts-speaker_cat', $speaker_cat_singular_name, $speaker_cat_slug, 'ts-speaker');	

	//  Event location
	$location_slug = esc_html__('Event Location','exhibz');
	$location_singular_name = esc_html__('Event Location','exhibz');
	$event_location = new  ExhibzCustomPost\Exhibz_Taxonomies('exhibz');
	$event_location->xs_init('event_location', $location_singular_name, $location_slug, 'etn');

}