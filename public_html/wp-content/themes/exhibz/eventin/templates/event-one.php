<?php
defined('ABSPATH') || exit;

$single_event_id = get_the_id();
?>
<?php do_action("etn_before_single_event_details", $single_event_id); ?>

<div class="etn-event-single-wrap main-container">
    <div class="etn-container">
        <?php  do_action("etn_before_single_event_container", $single_event_id); ?>

        <!-- Row start -->
        <div class="etn-row">
            <div class="etn-col-lg-8">
            
                <?php do_action("etn_before_single_event_content_wrap", $single_event_id); ?>

                <div class="etn-event-single-content-wrap">
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="etn-single-event-media">
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title_attribute(); ?>" />
                        </div>
                    <?php endif; ?>

                    <?php do_action("etn_before_single_event_content_body", $single_event_id); ?>

                    <div class="etn-event-content-body">
                        <?php the_content(); ?>
                    </div>

                    <?php do_action("etn_after_single_event_content_body", $single_event_id); ?>
                    
                    
                </div>
                
                <?php do_action("etn_after_single_event_content_wrap", $single_event_id); ?>

            </div><!-- col end -->

            <div class="etn-col-lg-4">
                <div class="etn-sidebar">
                        <?php                       if( \Etn\Utils\Helper::get_child_events($single_event_id) !== false) {

                            // It's recurring event
                            ?>
                            <div class="scroll recurring-event">
                            <a class="etn-recurring-title scroll" href="#etn-recurring-event-wrapper"><?php echo esc_html__( "Attend Event", 'exhibz' )?></a>
                            </div>

                            <?php                       }
                        ?>
                    <?php do_action("etn_before_single_event_meta", $single_event_id); ?>

                    <!-- event schedule meta end -->
                    <?php do_action("etn_single_event_meta", $single_event_id); ?>
                    <!-- event schedule meta end -->

                    <?php do_action("etn_after_single_event_meta", $single_event_id); ?>

                </div>
                <!-- etn sidebar end -->
            </div>
            <!-- col end -->
        </div>
        <!-- Row end -->

        <?php  do_action("etn_after_single_event_container", $single_event_id); ?>

    </div>
</div>

<?php  do_action("etn_after_single_event_details", $single_event_id); ?>