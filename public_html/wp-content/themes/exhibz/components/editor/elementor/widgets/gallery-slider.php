<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Exhibz_Gallery_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'exhibz-gallery-slider';
    }

    public function get_title() {
        return esc_html__( 'Exhibz Gallery Sliders', 'exhibz' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['exhibz-elements'];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'slider_settings',
            [
                'label'     => esc_html__('Slider Settings', 'exhibz'),               
            ]
        );
        $this->add_control(
            'slider_items',
            [
                'label'   => esc_html__('Slides to Show', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 5,
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
            'show_navigation',
            [
                'label'     => esc_html__('Show Navigation', 'exhibz'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'exhibz'),
                'label_off' => esc_html__('No', 'exhibz'),
                'default'   => 'no'
            ]
        );
        $this->add_control(
            'show_pagination',
            [
                'label'     => esc_html__('Show Pagination', 'exhibz'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'exhibz'),
                'label_off' => esc_html__('No', 'exhibz'),
                'default'   => 'no'
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
                    'value'   => 'icon icon-right-arrow1',
                    'library' => 'solid',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Exhibz gallery Slider', 'exhibz'),
            ]
         );

    
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'exhibz_slider_bg_image', [
                'label' => esc_html__('Background Image', 'exhibz'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'separator'=>'after',
            ]
        );
        $repeater->add_control(
            'exhibz_gallery_title', [
                'label' => esc_html__('Title', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );
         
        $this->add_control(
			'exhibz_slider_items',
			[
				'label' => esc_html__('exhibz gallery Slider', 'exhibz'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'exhibz_team_title' =>  esc_html__(' Carousel #1', 'exhibz'),
					],
					[
						'exhibz_team_title' => esc_html__(' Carousel #2', 'exhibz'),
					],
					[
						'exhibz_team_title' => esc_html__(' Carousel #3', 'exhibz'),
					],
				],
				'title_field' => '{{{ exhibz_team_title }}}',
			]
        );
        
        
        $this->end_controls_section(); 

    }

    protected function render( ) {

        $settings      = $this->get_settings();
        $settings['widget_id'] = $this->get_id();

        $exhibz_slider = $settings['exhibz_slider_items'];
    ?>
        
             <!-- banner start-->
      <section class="ts-gallery-slider" data-widget_settings='<?php echo json_encode($settings); ?>'>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($exhibz_slider as $key => $value): ?>
                    <?php if(isset($value["exhibz_slider_bg_image"]["url"]) && $value["exhibz_slider_bg_image"]["url"] !=''): ?>
                        <div class="swiper-slide"> 
                            <div class="galler-img-item">
                                <a href="<?php echo esc_url( $value["exhibz_slider_bg_image"]["url"]); ?>" class="gallery-popup">
                                    <img src="<?php echo esc_url( $value["exhibz_slider_bg_image"]["url"]); ?>" alt="<?php echo esc_attr('gallery', 'exhibz'); ?>">
                                </a>
                            </div>
                        </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php if ($settings['show_navigation'] == 'yes') { ?>
               <div class="slider_nav">
                    <div class="swiper-button-prev swiper-prev-<?php echo esc_attr($this->get_id()); ?>">
                        <?php \Elementor\Icons_Manager::render_icon($settings['left_arrow_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                    <div class="swiper-button-next swiper-next-<?php echo esc_attr($this->get_id()); ?>">
                        <?php \Elementor\Icons_Manager::render_icon($settings['right_arrow_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
               </div>
            <?php } ?>
            <?php if ($settings['show_pagination'] == 'yes') { ?>
                <div class="swiper-pagination"> </div>
            <?php } ?>
        </div>
      </section>
      <!-- banner end-->
     
        <?php   }

    protected function content_template() { }
}