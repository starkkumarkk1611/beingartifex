<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Exhibz_Speaker_Widget extends Widget_Base
{


    public $base;

    public function get_name()
    {
        return 'exhibz-speaker';
    }

    public function get_title()
    {
        return esc_html__('Speakers', 'exhibz');
    }

    public function get_icon()
    {
        return 'eicon-person';
    }

    public function get_categories()
    {
        return ['exhibz-elements'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Exhibz Speakers', 'exhibz'),
            ]
        );

        $this->add_control(
            'speaker_id',
            [
                'label'   => esc_html__('Speaker', 'exhibz'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->speaker_list(),
            ]
        );


        $this->add_control(
            'speaker_style',
            [
                'label'   => esc_html__('Speaker Style', 'exhibz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'speaker-1',
                'options' => [
                    'speaker-1' => esc_html__('Speaker Circle', 'exhibz'),
                    'speaker-2' => esc_html__('Speaker square', 'exhibz'),
                    'speaker-3' => esc_html__('Speaker square 2', 'exhibz'),
                    'speaker-4' => esc_html__('Speaker square alter', 'exhibz'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Styles', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ts-speaker .ts-speaker-info .ts-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-speaker .ts-title a'                => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-speaker .ts-speaker-info p'         => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_color',
            [
                'label'     => esc_html__('Box Hover color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ts-speaker .speaker-img:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Title Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .ts-speaker .ts-speaker-info .ts-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'designation_typography',
                'label'    => esc_html__('Designation Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .ts-speaker .ts-speaker-info p',
            ]
        );

        $this->add_control(
            'popup_des_color',
            [
                'label'     => esc_html__('Popup Description Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ts-speaker-popup .ts-speaker-popup-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function speaker_list()
    {

        $schedule_list = [];
        $args = array(
            'post_type'      => 'ts-speaker',
            'posts_per_page' => '-1'

        );

        $posts = get_posts($args);
        foreach ($posts as $postdata) {
            setup_postdata($postdata);
            $schedule_list[$postdata->ID] = [$postdata->post_title];
        }

        return $schedule_list;
    }

    protected function render()
    {


        $settings = $this->get_settings();
        $style = $settings["speaker_style"];
        $speaker_id = $settings["speaker_id"];

        $data['exhibs_designation'] = exhibz_meta_option($speaker_id, 'exhibs_designation');
        $data['social'] = exhibz_meta_option($speaker_id, 'social', true);
        $data['exhibs_photo'] = exhibz_meta_option($speaker_id, 'exhibs_photo', true);
        $data['exhibs_summery'] = exhibz_meta_option($speaker_id, 'exhibs_summery');
        $data['exhibs_logo'] = exhibz_meta_option($speaker_id, 'exhibs_logo', true);

        $speaker_color = $data['speaker_color'] = exhibz_meta_option($speaker_id, 'speaker_color');
        $speaker_color_value = $speaker_color == '' ? '#5dbf7c' : $speaker_color;

        if (is_array($data)) :
            $social = array_key_exists("social", $data) ? $data["social"] : [];
            ?>
            <?php if ($style == 'speaker-1') { ?>
            <div class="ts-speaker" style="--speaker-color: <?php echo esc_attr($speaker_color_value); ?>">
                <div class="speaker-img">
                    <?php if (count($data["exhibs_photo"]) > 1) : ?>
                        <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full', '', array("class" => "img-fluid")); ?>
                    <?php endif; ?>
                    <a href="<?php echo esc_html("#popup_" . $this->get_id() . $speaker_id); ?>"
                       class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                        <i class="icon icon-plus"></i>
                    </a>
                </div>
                <div class="ts-speaker-info">
                    <h3 class="ts-title"><a
                                href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                    </h3>
                    <p>
                        <?php echo esc_html($data["exhibs_designation"]); ?>
                    </p>                    
                </div>
                <!--- speaker info end -->
                <!-- popup start-->
                <div id="<?php echo esc_html("popup_" . $this->get_id() . $speaker_id); ?>"
                     class="container ts-speaker-popup mfp-hide">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="ts-speaker-popup-img">
                                <?php if (count($data["exhibs_photo"]) > 1) : ?>
                                    <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- col end-->
                        <div class="col-lg-6">
                            <div class="ts-speaker-popup-content">
                                <h3 class="ts-title"><a
                                            href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                                </h3>
                                <span class="speakder-designation"> <?php echo esc_html($data["exhibs_designation"]); ?></span>
                                <?php if (count($data["exhibs_logo"]) > 1) : ?>

                                    <?php echo wp_get_attachment_image($data["exhibs_logo"]["attachment_id"], 'thumb', '', array("class" => "company-logo")); ?>
                                <?php endif; ?>
                                <p>
                                    <?php echo exhibz_kses($data["exhibs_summery"]); ?>
                                </p>
                                <div class="ts-speakers-social">
                                    <?php if (is_array($social)) { ?>
                                        <?php foreach ($social as $social_value) { ?>
                                            <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" target="_blank" rel="noreferrer">
                                               <i class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>                                               
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- ts-speaker-popup-content end-->
                        </div>
                        <!-- col end-->
                    </div>
                    <!-- row end-->
                </div>
                <!-- popup end-->
            </div>
            <!-- ts-speaker end  -->
        <?php } ?>


            <?php if ($style == 'speaker-2') { ?>
            <section class="ts-speakers-standard ts-speakers speaker-classic section-bg">
                <div class="ts-speaker" style="--speaker-color: <?php echo esc_attr($speaker_color_value); ?>">
                    <div class="speaker-img">
                        <?php if (count($data["exhibs_photo"]) > 1) : ?>
                            <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full', '', array("class" => "img-fluid")); ?>
                        <?php endif; ?>
                        <a href="<?php echo esc_html("#popup_" . $this->get_id() . $speaker_id); ?>"
                           class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                            <i class="icon icon-plus"></i>
                        </a>
                    </div>
                    <div class="ts-speaker-info">
                        <h3 class="ts-title"><a
                                    href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                        </h3>
                        <p>
                            <?php echo esc_html($data["exhibs_designation"]); ?>
                        </p>
                    </div>
                    <!--- speaker info end -->
                    <!-- popup start-->
                    <div id="<?php echo esc_html("popup_" . $this->get_id() . $speaker_id); ?>"
                         class="container ts-speaker-popup mfp-hide">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-img">
                                    <?php if (count($data["exhibs_photo"]) > 1) : ?>
                                        <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- col end-->
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-content">
                                    <h3 class="ts-title"><a
                                                href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                                    </h3>
                                    <span class="speakder-designation"> <?php echo esc_html($data["exhibs_designation"]); ?></span>
                                    <?php if (count($data["exhibs_logo"]) > 1) : ?>

                                        <?php echo wp_get_attachment_image($data["exhibs_logo"]["attachment_id"], 'thumb', '', array("class" => "company-logo")); ?>
                                    <?php endif; ?>
                                    <p>
                                        <?php echo exhibz_kses($data["exhibs_summery"]); ?>
                                    </p>
                                    <div class="ts-speakers-social">
                                        <?php if (is_array($social)) { ?>
                                            <?php foreach ($social as $social_value) { ?>
                                                <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" rel="noreferrer" target="_blank">
                                                   <i class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ts-speaker-popup-content end-->
                            </div>
                            <!-- col end-->
                        </div>
                        <!-- row end-->
                    </div>
                    <!-- popup end-->
                </div>
            </section>
            <!-- ts-speaker end  -->
        <?php } ?>

            <?php if ($style == 'speaker-3') { ?>
            <section class="ts-speakers-classic ts-speakers speaker-classic section-bg">
                <div class="ts-speaker" style="--speaker-color: <?php echo esc_attr($speaker_color_value); ?>">
                    <div class="speaker-img">
                        <?php if (count($data["exhibs_photo"]) > 1) : ?>
                            <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full', '', array("class" => "img-fluid")); ?>
                        <?php endif; ?>
                        <a href="<?php echo esc_html("#popup_" . $this->get_id() . $speaker_id); ?>"
                           class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                            <i class="icon icon-plus"></i>
                        </a>
                    </div>
                    <div class="ts-speaker-info">
                        <h3 class="ts-title"><a
                                    href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                        </h3>
                        <p>
                            <?php echo esc_html($data["exhibs_designation"]); ?>
                        </p>
                    </div>
                    <!--- speaker info end -->
                    <!-- popup start-->
                    <div id="<?php echo esc_html("popup_" . $this->get_id() . $speaker_id); ?>"
                         class="container ts-speaker-popup mfp-hide">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-img">
                                    <?php if (count($data["exhibs_photo"]) > 1) : ?>
                                        <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- col end-->
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-content">
                                    <h3 class="ts-title"><a
                                                href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                                    </h3>
                                    <span class="speakder-designation"> <?php echo esc_html($data["exhibs_designation"]); ?></span>
                                    <?php if (count($data["exhibs_logo"]) > 1) : ?>

                                        <?php echo wp_get_attachment_image($data["exhibs_logo"]["attachment_id"], 'thumb', '', array("class" => "company-logo")); ?>
                                    <?php endif; ?>
                                    <p>
                                        <?php echo exhibz_kses($data["exhibs_summery"]); ?>
                                    </p>
                                    <div class="ts-speakers-social">
                                        <?php if (is_array($social)) { ?>
                                            <?php foreach ($social as $social_value) { ?>
                                                <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" rel="noreferrer">
                                                    <i class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ts-speaker-popup-content end-->
                            </div>
                            <!-- col end-->
                        </div>
                        <!-- row end-->
                    </div>
                    <!-- popup end-->
                </div>
            </section>
            <!-- ts-speaker end  -->
        <?php } ?>

            <?php if ($style == 'speaker-4') { ?>
            <section class="ts-speakers-style4 ts-speakers speaker-classic">
                <div class="ts-speaker" style="--speaker-color: <?php echo esc_attr($speaker_color_value); ?>">
                    <div class="speaker-img">
                        <?php if (count($data["exhibs_photo"]) > 1) : ?>
                            <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full', '', array("class" => "img-fluid")); ?>
                        <?php endif; ?>
                        <a href="<?php echo esc_html("#popup_" . $this->get_id() . $speaker_id); ?>"
                           class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                            <i class="icon icon-plus"></i>
                        </a>
                        <!-- speaker social -->
                        <div class="ts-speakers-social-4 ts-speakers-social">
                            <?php if (is_array($social)) { ?>
                                <?php foreach ($social as $social_value) { ?>
                                    <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" rel="noreferrer">
                                    <i class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>                                    
                                </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <!-- speaker social end -->
                    </div>
                    <div class="ts-speaker-info text-left">
                        <h3 class="ts-title"><a
                                    href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                        </h3>
                        <p>
                            <?php echo esc_html($data["exhibs_designation"]); ?>
                        </p>
                    </div>
                    <!--- speaker info end -->
                    <!-- popup start-->
                    <div id="<?php echo esc_html("popup_" . $this->get_id() . $speaker_id); ?>"
                         class="container ts-speaker-popup mfp-hide">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-img">
                                    <?php if (count($data["exhibs_photo"]) > 1) : ?>
                                        <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- col end-->
                            <div class="col-lg-6">
                                <div class="ts-speaker-popup-content">
                                    <h3 class="ts-title"><a
                                                href="<?php echo get_the_permalink($speaker_id); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?> </a>
                                    </h3>
                                    <span class="speakder-designation"> <?php echo esc_html($data["exhibs_designation"]); ?></span>
                                    <?php if (count($data["exhibs_logo"]) > 1) : ?>

                                        <?php echo wp_get_attachment_image($data["exhibs_logo"]["attachment_id"], 'thumb', '', array("class" => "company-logo")); ?>
                                    <?php endif; ?>
                                    <p>
                                        <?php echo exhibz_kses($data["exhibs_summery"]); ?>
                                    </p>
                                    <div class="ts-speakers-social">
                                        <?php if (is_array($social)) { ?>
                                            <?php foreach ($social as $social_value) { ?>
                                                <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" rel="noreferrer">
                                                    <i  class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>                                                    
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ts-speaker-popup-content end-->
                            </div>
                            <!-- col end-->
                        </div>
                        <!-- row end-->
                    </div>
                    <!-- popup end-->
                </div>
            </section>
            <!-- ts-speaker end  -->
        <?php } ?>


        <?php
            // echo wp_kses($style == "speaker-2" ? '</section>' : '', ['section']);
            //         echo wp_kses($style == "speaker-3" ? '</section>' : '', ['section']);
            //         echo wp_kses($style == "speaker-4" ? '</section>' : '', ['section']);

        endif;

    }
}
