<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Exhibz_Speaker_Slider_Widget extends Widget_Base
{


    public $base;

    public function get_name()
    {
        return 'exhibz-speaker-slider';
    }

    public function get_title()
    {
        return esc_html__('Speakers slider', 'exhibz');
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
                'label' => esc_html__('Exhibz Speakers slider', 'exhibz'),
            ]
        );

        $this->add_control(
            'speaker_id',
            [
                'label' => esc_html__('Speaker', 'exhibz'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->speaker_list(),
            ]
        );


        $this->add_control(
            'speaker_style',
            [
                'label' => esc_html__('Speaker Style', 'exhibz'),
                'type' => Controls_Manager::SELECT,
                'default' => 'speaker-1',
                'options' => [
                    'speaker-1'  => esc_html__('Speaker Circle', 'exhibz'),

                ],
            ]
        );

        $this->add_control(
            'slider_count',
            [
                'label'         => esc_html__('Count', 'exhibz'),
                'type'         => Controls_Manager::NUMBER,
                'default' => 4,
            ]
        );
       
        $this->add_control(
            'speaker_order',
            [
                'label'     => esc_html__('order', 'exhibz'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC'      => esc_html__('Descending', 'exhibz'),
                    'ASC'       => esc_html__('Ascending', 'exhibz'),
                ],
            ]
        );
        $this->add_control(
            'speaker_order_by',
            [
                'label'     => esc_html__('order by', 'exhibz'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'title',
                'options'   => [
                    'ID'      => esc_html__('ID', 'exhibz'),
                    'title'       => esc_html__('Title', 'exhibz'),
                    'name'       => esc_html__('Name', 'exhibz'),
                    'date'       => esc_html__('Date', 'exhibz'),
                    'rand'       => esc_html__('Random', 'exhibz'),
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label'         => esc_html__('Text color', 'exhibz'),
                'type'         => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .ts-speaker-slider .ts-speaker .ts-speaker-info .ts-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-speaker-slider .ts-speaker .ts-speaker-info p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_color',
            [
                'label'         => esc_html__('Box Hover color', 'exhibz'),
                'type'         => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .ts-speaker-slider .ts-speaker::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'         => 'title_typography',
                'label'         => esc_html__('Title Typography', 'exhibz'),
                'selector'     => '{{WRAPPER}} .ts-speaker-slider .ts-speaker .ts-speaker-info .ts-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'         => 'designation_typography',
                'label'         => esc_html__('Designation Typography', 'exhibz'),
                'selector'     => '{{WRAPPER}} .ts-speaker-slider .ts-speaker .ts-speaker-info p',
            ]
        );

        $this->add_responsive_control(
            'slider_space_between',
            [
                'label'        => esc_html__('Slider Item Space', 'exhibz'),
                'description'  => esc_html__('Space between slides', 'exhibz'),
                'type'         => Controls_Manager::NUMBER,
                'return_value' => 'yes'
            ]
        );
        $this->add_control(
            'speaker_slider_autoplay',
            [
                'label'        => esc_html__('Autoplay', 'exhibz'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'exhibz'),
                'label_off'    => esc_html__('No', 'exhibz'),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );
        $this->add_control(
            'speaker_slider_speed',
            [
                'label'   => esc_html__('Slider Speed', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1500
            ]
        );

        $this->add_control(
            'ts_slider_arrow_nav_show',
                [
                'label' => esc_html__( 'Arrow nav', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'exhibz' ),
                'label_off' => esc_html__( 'No', 'exhibz' ),
                'return_value' => 'yes',
                'default' => 'no'
            ]
        );

        $this->add_control(
            'left_arrow_icon',
            [
                'label'     => esc_html__('Left Arrow Icon', 'exhibz'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'icon icon-left-arrows',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'right_arrow_icon',
            [
                'label'     => esc_html__('Right Arrow Icon', 'exhibz'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'icon icon-right-arrow',
                    'library' => 'solid',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function render()
    {


        $settings   = $this->get_settings();
        $style      = $settings["speaker_style"];
        $speaker_ids = $settings["speaker_id"];
        $speaker_order = $settings['speaker_order'];
        $speaker_order_by = $settings['speaker_order_by'];
        $slider_count = $settings["slider_count"]; 
        $arrow_nav_show  = $settings['ts_slider_arrow_nav_show'];
        $speaker_slider_speed  =   $settings['speaker_slider_speed'];
        $speaker_slider_autoplay  =   $settings['speaker_slider_autoplay'];

        $settings['widget_id'] = $this->get_id();

        // if ($speaker_order == "DESC") {
        //     rsort($speaker_ids);
        // }

        $posts_per_page = count($speaker_ids);

        $args = array(
            'post_type'             => 'ts-speaker',
            'posts_per_page' => $posts_per_page,
            'orderby' => $speaker_order_by,
            'order'   => $speaker_order,
            'post__in' => $speaker_ids
        );

        $posts1 = get_posts($args);

        $slide_controls    = [
            'speaker_slider_speed'=> $speaker_slider_speed,
            'ts_slider_arrow_nav_show'=> $arrow_nav_show,
            'slider_count'=> $slider_count,
            'speaker_slider_autoplay'=> $speaker_slider_autoplay,
        ];
   
        $slide_controls = \json_encode($slide_controls);
?>
        <div class="ts-speaker-slider" data-controls="<?php echo esc_attr($slide_controls); ?>">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($posts1 as  $post) :
                        
                        $speaker_id = $post->ID;
                        $data = [];
                        $data['exhibs_designation'] = exhibz_meta_option($speaker_id, 'exhibs_designation');
                        $data['social'] = exhibz_meta_option($speaker_id, 'social', true);
                        $data['exhibs_photo'] = exhibz_meta_option($speaker_id, 'exhibs_photo', true);
                        $data['exhibs_summery'] = exhibz_meta_option($speaker_id, 'exhibs_summery', true);
                        $data['exhibs_logo'] = exhibz_meta_option($speaker_id, 'exhibs_logo', true);

                        $social = array_key_exists("social", $data) ? $data["social"] : [];
                        ?>
                        <div class="swiper-slide"> 
                            <div class="ts-speaker">
                                <div class="speaker-img">
                                    <?php if (count($data["exhibs_photo"]) > 1) : ?>
                                        <?php echo wp_get_attachment_image($data["exhibs_photo"]["attachment_id"], 'full', '', array("class" => "img-fluid")); ?>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_html("#popup_". $this->get_id() . $speaker_id); ?>" class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                                        <!-- <i class="icon icon-plus"></i> -->
                                    </a>
                                </div>
                                <div class="ts-speaker-info">
                                    <h3 class="ts-title"><?php echo esc_html(get_the_title($speaker_id)); ?></h3>
                                    <p>
                                        <?php echo esc_html($data["exhibs_designation"]); ?>
                                    </p>
                                </div>
                                <!--- speaker info end -->
                                <!-- popup start-->
                                <div id="<?php echo esc_html("popup_". $this->get_id() . $speaker_id); ?>" class="container ts-speaker-popup mfp-hide">
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
                                                <h3 class="ts-title"><?php echo esc_html(get_the_title($speaker_id)); ?> </h3>
                                                <span class="speakder-designation"> <?php echo esc_html($data["exhibs_designation"]); ?></span>
                                                <?php if (count($data["exhibs_logo"]) > 1) : ?>

                                                    <?php echo wp_get_attachment_image($data["exhibs_logo"]["attachment_id"], 'thumb', '', array("class" => "company-logo")); ?>
                                                <?php endif; ?>
                                                <p>
                                                    <?php echo exhibz_kses($data["exhibs_summery"]); ?>
                                                </p>

                                                <div class="ts-speakers-social">
                                                    <?php if (!empty($social)) { ?>
                                                        <?php foreach ($social as $social_value) {  ?>
                                                            <a href="<?php echo esc_url($social_value["option_site_link"]); ?>" rel="noreferrer">
                                                                <i class="<?php echo esc_attr($social_value["option_site_icon"]); ?>"></i>                                                   
                                                            </a>
                                                        <?php  } ?>
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
                        </div>                                    
                        <?php

                        endforeach;
                    ?>
                </div>

                <?php if ("yes" == $arrow_nav_show) { ?>
                    <div class="slider_nav">
                        <div class="swiper-button-prev swiper-prev-<?php echo esc_attr($this->get_id()); ?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['left_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                        <div class="swiper-button-next swiper-next-<?php echo esc_attr($this->get_id()); ?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['right_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php

    }

    public function speaker_list()
    {

        $schedule_list = [];
        $args = array(
            'post_type'             => 'ts-speaker',
            'posts_per_page' => '-1',
        );

        $posts = get_posts($args);
        foreach ($posts as $postdata) {
            setup_postdata($postdata);
            $schedule_list[$postdata->ID] = [$postdata->post_title];
        }

        return $schedule_list;
    }
}
