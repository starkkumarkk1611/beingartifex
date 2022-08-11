<?php
// single event started
add_action('etn_before_single_event_details', 'exhibz_single_event_banner', 11);
function exhibz_single_event_banner(){
	get_template_part('template-parts/banner/content', 'banner-event-single');
}


//event countdown for single page banner
function exhibz_countdown_markup( $etn_start_date, $event_start_time ){
	$event_start_time   =  isset($event_start_time) && ( "" != $event_start_time ) ? date( "H:i:s", strtotime( $event_start_time ) ) : "00:00:00";
	$event_start_date   =  isset($etn_start_date) && ( "" != $etn_start_date ) ? date( "m/d/Y", strtotime( $etn_start_date ) ) : date( "m/d/Y", time() );
	$counter_start_time = $event_start_date . " " . $event_start_time;
	$countdown_day      = esc_html__("day", 'exhibz');
	$countdown_hr       = esc_html__( "hr",'exhibz');
	$countdown_min      = esc_html__( "min", 'exhibz' );
	$countdown_sec      = esc_html__( "sec", 'exhibz' );
	$show_seperate_dot  = false;
	$date_texts = [
		'day'=> $countdown_day,
		'days'=> esc_html__( "days", 'exhibz' ),
		'hr'=> $countdown_hr,
		'hrs'=> esc_html__("hrs", 'exhibz'),
		'min'=> $countdown_min,
		'mins'=> esc_html__("mins", 'exhibz'),
		'sec'=> $countdown_sec,
		'secs'=>esc_html__(  "secs", 'exhibz' ),
	];
	?>
	<div class="count_down_block">
		<div class="etn-event-countdown-wrap  etn-countdown-wrap etn-coundown1 etn-countdown-parent" 
			data-start-date="<?php echo esc_attr( $counter_start_time ); ?>"
			data-date-texts='<?php echo json_encode( $date_texts );?>'>
			<div class="etn-count-item etn-days">
				<span class="day-count days"></span>
				<span class="text days_text">  <?php echo esc_html__( $countdown_day, 'exhibz'); ?></span>
			</div>
			<?php if ( $show_seperate_dot ){ ?>
			<span class="date-seperate"> : </span>
			<?php } ?>
			<div class="etn-count-item etn-hours">
				<span class="hr-count hours"></span>
				<span class="text hours_text"><?php echo esc_html__( $countdown_hr, 'exhibz' ); ?></span>
			</div>
			<?php if ( $show_seperate_dot ){ ?>
			<span class="date-seperate"> : </span> 
			<?php } ?>
			<div class="etn-count-item etn-minutes">
				<span class="min-count minutes"></span>
				<span class="text minutes_text"> <?php echo esc_html__( $countdown_min, 'exhibz' ); ?></span>
			</div>
			<?php if ( $show_seperate_dot ){ ?>
			<span class="date-seperate"> : </span>
			<?php } ?>
			<div class="etn-count-item etn-seconds">
				<span class="sec-count seconds"></span>
				<span class="text seconds_text"> <?php echo esc_html__( $countdown_sec, 'exhibz' ); ?></span>
			</div>
		</div>
	</div>
	<?php
}

add_action('template_redirect',function(){
    global $post;
    $current_event_id = $post->ID;
	$ticket_variation = get_post_meta($current_event_id,"etn_ticket_variations",true);

	if ( is_array($ticket_variation) && count($ticket_variation) === 1 ) {
		remove_action( "etn_after_single_event_meta", "etn_after_single_event_meta_ticket_form", 10 );
		add_action('etn_before_single_event_details', 'etn_after_single_event_meta_ticket_form',12);

		add_action('etn_before_add_to_cart_widget_block',function(){
			?>
			<div class="sinlge-event-registration">
				<div class="container">
			<?php
		});
		add_action('etn_after_add_to_cart_widget_block',function(){
			?>
				</div>
			</div>
			<?php
		});
	}
});

// add to cart section 


add_action('etn_after_single_event_content_wrap', 'exhibz_event_attendee_list',14);

function exhibz_event_attendee_list(){
	global $wpdb;
	$event_id = get_the_ID();
	$event_attendees    = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='etn_event_id' AND meta_value='$event_id'" );
	$attendee_enabled   = \Etn\Utils\Helper::get_option("attendee_registration");
	if( $attendee_enabled ){

	?>
	<div class=" etn-attendee-widget-holder">
	<h3><?php echo esc_html__('Attendee List', 'exhibz'); ?></h3>
    <div class="etn-row">
        <?php        if ( is_array( $event_attendees ) && !empty( $event_attendees ) ) {

            foreach ( $event_attendees as $attendee ) {
                $attendee_id     = $attendee->post_id;
                $attendee_avatar = "";
                $attendee_name   = get_post_meta( $attendee_id, "etn_name", true );
                $attendee_email  = get_post_meta( $attendee_id, "etn_email", true );
                $attendee_email  = !empty( $attendee_email ) ? $attendee_email : "";

                if ( !empty( $attendee_email ) ) {
                    $attendee_avatar = get_avatar_url( $attendee_email );
                } else {
                    $default_avatar_url = ETN_ASSETS . "images/avatar.jpg";
                    $attendee_avatar    = apply_filters( "etn/attendee/default_avatar", $default_avatar_url );
                }
                ?>
                <div class="etn-col-lg-4 etn-col-md-6">
                    <div class="etn-event-attendee-single">
                            <div class="etn-attendee etn-attendee-avatar-wrap">
                                <img alt="event-image" class="etn-attendee-avatar" src="<?php echo esc_url( $attendee_avatar ); ?>" />
                            </div>
                        <div class="etn-attendee etn-attendee-content">
                            <h4 class="etn-attendee-title">
                                <?php echo esc_html( $attendee_name ); ?>
                            </h4>
                            <?php if( $attendee_email !=''){ ?>
                                <p class="attende-meta">
                                    <span class="etn-attendee-email-label">
                                        <?php echo esc_html__( "Email: ", "exhibz" ); ?>
                                    </span>
                                    <?php echo esc_html( $attendee_email ); ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php           }
        } else { ?>
        <div class="etn-no-attendee-holder">
            <?php echo esc_html__( "No attendee found", "exhibz" ); ?>
        </div>
        <?php        }
        ?>
    </div>
</div>

	<?php
	}
}


