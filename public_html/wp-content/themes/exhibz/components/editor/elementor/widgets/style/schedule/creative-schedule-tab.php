<?php

use Etn\Utils\Helper as Helper;

$post_perpage = 3;
if (did_action('eventin-pro/after_load')) {
    $post_perpage = 50;
}

$data = Helper::post_data_query('etn-schedule', $post_perpage, $order, null, null, $etn_schedule_ids);

if (is_array($data) && !empty($data)) {

    $i = -1;
    ?>
    <!-- schedule tab start -->
    <div class="schedule-tab-wrapper etn-tab-wrapper <?php echo esc_attr($this->get_name()); ?>"
         data-widget_settings='<?php echo json_encode($settings); ?>'>
        <ul class='etn-nav'>
            <?php
            $i = -1;
            foreach ($data as $value)  :
                $i++;
                $schedule_meta = get_post_meta($value->ID);
                $schedule_date = strtotime($schedule_meta['etn_schedule_date'][0]);
                $schedule_date = date_i18n("d M", $schedule_date);
                $active_class = (($i == 0) ? 'etn-active' : ' ');
                ?>
                <li>
                    <a href='#' class='etn-tab-a <?php echo esc_attr($active_class); ?>'
                       data-id='tab<?php echo esc_attr($value->ID) . "-" . $i; ?>'>
                        <span class=etn-day><?php echo esc_html(get_the_title($value->ID)); ?></span>
                        <span class='etn-date'><?php echo esc_html($schedule_date); ?></span>
                    </a>

                </li>
            <?php endforeach; ?>
        </ul>
        <div class='etn-tab-content clearfix etn-schedule-wrap'>
            <?php
            $time_format = Helper::get_option("time_format");
            $time_format = !empty($time_format) ? $time_format : '12';
            $etn_sched_time_format = ($time_format == '24') ? "H:i" : get_option('time_format');

            $j = -1;
            foreach ($data as $post) :
                $j++;
                $schedule_meta = get_post_meta($post->ID);
                $schedule_date = strtotime($schedule_meta['etn_schedule_date'][0]);
                $schedule_topics = unserialize($schedule_meta['etn_schedule_topics'][0]);
                $schedule_date = date_i18n("d M", $schedule_date);
                $active_class = (($j == 0) ? 'tab-active' : ' ');
                ?>
                <!-- start repeatable item -->
                <div class='etn-tab <?php echo esc_attr($active_class); ?>'
                     data-id='tab<?php echo esc_attr($post->ID) . "-" . $j; ?>'>
                    <?php
                    if (is_array($schedule_topics) && !empty($schedule_topics)) {
                        foreach ($schedule_topics as $topic) {
                            $etn_schedule_topic = (isset($topic['etn_schedule_topic']) ? $topic['etn_schedule_topic'] : '');
                            $etn_schedule_start_time = !empty($topic['etn_shedule_start_time']) ? date_i18n($etn_sched_time_format, strtotime($topic['etn_shedule_start_time'])) : '';
                            $etn_schedule_end_time = !empty($topic['etn_shedule_end_time']) ? date_i18n($etn_sched_time_format, strtotime($topic['etn_shedule_end_time'])) : '';
                            $etn_schedule_room = (isset($topic['etn_shedule_room']) ? $topic['etn_shedule_room'] : '');
                            $etn_schedule_objective = (isset($topic['etn_shedule_objective']) ? $topic['etn_shedule_objective'] : '');
                            $etn_schedule_speaker = (isset($topic['etn_shedule_speaker']) ? $topic['etn_shedule_speaker'] : []);
                            ?>
                            <div class='exhibz-schedule-schedule-item etn-single-schedule-item'>
                                <div class='etn-schedule-info exhibz-schedule-info'>
                                    <div class="exhibz-schedule-time">
                                        <?php
                                        if (!empty($etn_schedule_start_time) || !empty($etn_schedule_end_time)) {
                                            ?>
                                            <p> <?php echo esc_attr($etn_schedule_start_time); ?>
                                                - <?php echo esc_attr($etn_schedule_end_time); ?> </p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='etn-schedule-content exhibz-schedule-content'>
                                    <div class="exhibz-schedule-content-row">
                                        <div class="exhibz-schedule-content-top">
                                            <h4 class='etn-title'><?php echo esc_html($etn_schedule_topic); ?></h4>
                                            <p><?php echo Helper::render($etn_schedule_objective); ?></p>
                                        </div>
                                        <?php
                                        $speaker_avatar = apply_filters("etn/speakers/avatar", \Wpeventin::assets_url() . "images/avatar.jpg");
                                        if (is_array($etn_schedule_speaker) && !empty($etn_schedule_speaker)) : ?>
                                            <div class="exhibz-schedule-content-bottom">
                                                <div class='ts-schedule-speaker-slider'>
                                                    <div class='etn-schedule-single-speaker'>
                                                        <div class='etn-schedule-speaker'>

                                                            <!-- Slider main container -->
                                                            <div class="swiper-container etn-tab-speaker-slide">
                                                                <!-- Additional required wrapper -->
                                                                <div class="swiper-wrapper">
                                                                    <?php
                                                                    foreach ($etn_schedule_speaker as $key => $value) {
                                                                        $speaker_thumbnail = !empty(get_the_post_thumbnail_url($value)) ? get_the_post_thumbnail_url($value) : $speaker_avatar;
                                                                        $etn_schedule_single_speaker = get_post($value);
                                                                        $etn_speaker_permalink = get_post_permalink($value);
                                                                        $etn_speaker_designation = get_post_meta($value, 'etn_speaker_designation', true);
                                                                        $speaker_title = $etn_schedule_single_speaker->post_title;
                                                                        $speaker_title = str_replace(['{', '}'], ['<span class="first-name">', '</span>'], $speaker_title);
                                                                        ?>
                                                                        <div class='swiper-slide'>
                                                                            <div class="exhibz-schedule-single-speaker">
                                                                                <a class="exhibz-speaker-image"
                                                                                   href='<?php echo esc_url($etn_speaker_permalink); ?>'>
                                                                                    <img src='<?php echo esc_url($speaker_thumbnail); ?>'
                                                                                         alt='<?php echo esc_attr($speaker_title); ?>'>
                                                                                </a>
                                                                                <div class="exhibz-speaker-description">
                                                                                    <a class="exhibz-schedule-speakers-title" href='<?php echo esc_url($etn_speaker_permalink); ?>'>
                                                                                        <?php echo exhibz_kses($speaker_title); ?>
                                                                                    </a>
                                                                                    <p class="exhibz-speaker-designation">
                                                                                        <?php echo esc_html($etn_speaker_designation); ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div> <!-- Swiper wrapper end -->
                                                            </div> <!-- Slider main container end -->
                                                            <div class="swiper-button-prev swiper-prev-<?php echo esc_attr($this->get_id()); ?>">
                                                                <i aria-hidden="true"
                                                                   class="icon icon-left-arrows"></i>
                                                            </div>
                                                            <div class="swiper-button-next swiper-next-<?php echo esc_attr($this->get_id()); ?>">
                                                                <i aria-hidden="true"
                                                                   class="icon icon-right-arrow1"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- end repeatable item -->
            <?php endforeach; ?>
        </div>
    </div>
    <!-- schedule tab end -->
<?php } else { ?>
    <p class="etn-not-found-post"><?php echo esc_html__('No Post Found'); ?></p>
    <?php
}