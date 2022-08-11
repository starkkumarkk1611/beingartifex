<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Exhibz_Testimonial_Widget extends Widget_Base {

    public function get_name() {
        return 'exhibz-testimonial';
    }

    public function get_title() {
        return esc_html__( 'Exhibz Testimonial', 'exhibz' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['exhibz-elements'];
    }

    protected function register_controls() {
        
        $this->start_controls_section('section_tab_style',
            [
                'label' => esc_html__('Exhibz Testimonial Carousel', 'exhibz'),
            ]
         );

        $this->add_control('show_navigation',
            [
                'label'       => esc_html__('Show Navigation', 'exhibz'),
                'type'        => Controls_Manager::SWITCHER,
                'label_on'    => esc_html__('Yes', 'exhibz'),
                'label_off'   => esc_html__('No', 'exhibz'),
                'default'     => 'yes',
            ]
        );
		$this->add_control('autoplay_onoff',
            [
                'label'       => esc_html__('Autoplay On/Off', 'exhibz'),
                'type'        => Controls_Manager::SWITCHER,
                'label_on'    => esc_html__('Yes', 'exhibz'),
                'label_off'   => esc_html__('No', 'exhibz'),
                'default'     => 'yes',
            ]
        );    
        $this->add_control(
            'quote_slider_speed',
            [
                'label'   => esc_html__('Slider Speed', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1500
            ]
        );
        $this->add_control('quote_slider_count',
            [
                'label'       => esc_html__('Count', 'exhibz'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 2
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
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'name', [
                'label'        => esc_html__('Client Name', 'exhibz'),
                'type'         => Controls_Manager::TEXT,
                'default'      => esc_html__('Thomas Edison', 'exhibz'),
                'label_block'  => true,
            ]
        );
        $repeater->add_control(
            'designation', [
                'label'        => esc_html__('Client designation', 'exhibz'),
                'type'         => Controls_Manager::TEXT,
                'default'      => esc_html__('Sponsor', 'exhibz'),
                'label_block'  => true,
            ]
        );
        $repeater->add_control(
            'photo', [
                'label'       => esc_html__('Client Photo', 'exhibz'),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
            ]
        );
         
        $repeater->add_control(
            'quote', [
                'label'       => esc_html__('Quote Carousel Review', 'exhibz'),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => esc_html__('Keep your face always toward the sunshine and shadows will fall behind you', 'exhibz'),
                'label_block' => true,
            ]
        );
         
        $this->add_control(
			'quote_carousel',
			[
				'label' => esc_html__('Testimonial Carousel', 'exhibz'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'name' =>  esc_html__('John Doe', 'exhibz'),
					],
					[
						'name' =>  esc_html__('John Doe', 'exhibz'),
					],
					[
						'name' =>  esc_html__('John Doe', 'exhibz'),
					],
				],
				'title_field' => '{{{ name }}}',
			]
        );

        $this->end_controls_section();

        // style

        $this->start_controls_section('style_section',
            [
               'label'      => esc_html__( 'Style Section', 'exhibz' ),
               'tab'        => Controls_Manager::TAB_STYLE,
            ]
        ); 
      
        $this->add_control('testimonial_desc_color',
            [
               'label'      => esc_html__('Description color', 'exhibz'),
               'type'       => Controls_Manager::COLOR,
               'selectors'  => [
                    '{{WRAPPER}} .testimonial-item .testimonial-body .testimonial-content p' => 'color: {{VALUE}};',
               ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' =>  esc_html__('Description Typography', 'exhibz'),
				'selector' => '{{WRAPPER}} .testimonial-content p',
			]
		);


        $this->add_control('testimonial_client_color',
            [
               'label'      => esc_html__('Client Name color', 'exhibz'),
               'type'       => Controls_Manager::COLOR,
               'selectors'  => [
                    '{{WRAPPER}} .testimonial-body .client-info .client-name' => 'color: {{VALUE}};',
               ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'client_name_typo',
				'label' => esc_html__('Client Name Typography', 'exhibz'),
				'selector' => '{{WRAPPER}} .testimonial-body .client-info .client-name',
			]
		);
       
      
      $this->end_controls_section();  

    }

    protected function render( ) {

        $settings           =     $this->get_settings();
        $settings['widget_id'] = $this->get_id();

        $quote_carousel     =     $settings['quote_carousel'];
        $show_navigation    =     $settings["show_navigation"];
		// $autoplay_onoff    =     $settings["autoplay_onoff"];
        // $quote_slider_count    =  $settings["quote_slider_count"];
   
        ?>
       
        <div data-widget_settings='<?php echo json_encode($settings); ?>' class="testimonial-carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach($quote_carousel as $quote): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="testimonial-body">
                                    <div class="row text-center text-lg-left">
                                        <div class="col-lg-4">
                                        <?php if($quote['photo']['url']!=''): ?> 
                                            <div class="testimonial-thumb">
                                                <span class="quote-icon"><i class="icon icon-quote1"></i></span>
                                                <img src=" <?php echo esc_url( $quote['photo']['url']); ?> "  alt="testimonial" class="img-fluid">
                                            </div>
                                        <?php endif; ?> 
                                        </div>
                                        <div class="col-lg-8">
                                        <div class="testimonial-content">
                                            <?php echo exhibz_kses($quote['quote']);?>

                                            <!-- Client info -->
                                            <div class="client-info">
                                                <h4 class="client-name"><?php echo exhibz_kses($quote['name']);?>
                                                    <span class="client-desig"><?php echo exhibz_kses($quote['designation']);?></span>
                                                </h4>
                                                
                                            </div> <!-- Client info end -->
                                        </div>
                                        </div>
                                    </div>
                                </div> <!-- Testimonial Body end -->
                            </div> <!-- Testimonial Box end -->
                        </div>
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
            </div>
            
       </div> <!-- Testimonial Carousel -->
        <?php   }

    protected function content_template() { }
}