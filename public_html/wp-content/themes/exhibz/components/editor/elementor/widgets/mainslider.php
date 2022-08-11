<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Exhibz_MainSlider_Widget extends Widget_Base {

    public function get_name() {
        return 'exhibz-slider';
    }

    public function get_title() {
        return esc_html__( 'Exhibz Sliders', 'exhibz' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['exhibz-elements'];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Exhibz Slider', 'exhibz'),
            ]
         );

         $this->add_control(
			'style',
			[
				'label' => esc_html__( 'Slider Style', 'exhibz' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1'  => esc_html__( 'Style 1', 'exhibz' ),
					'style2'  => esc_html__( 'Style 2', 'exhibz' ),
				],
			]
        );

         $repeater = new \Elementor\Repeater();

         
        $repeater->add_control(
            'exhibz_show_title_shap', [
                'label'         => esc_html__( 'Show Title Shape', 'exhibz' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'exhibz' ),
                'label_off'    => esc_html__( 'Hide', 'exhibz' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $repeater->add_control(
            'exhibz_slider_title_top', [
                'label' => esc_html__('Slider Top title', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('5 to 7 June 2019, Waterfront Hotel, London', 'exhibz'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'exhibz_slider_title', [
                'label' => esc_html__('Slider Title', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('digital thinkers Meet', 'exhibz'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'exhibz_slider_description', [
                'label' => esc_html__('Slider Description ', 'exhibz'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('How you transform your business as technology, consumer, habits industry dynamis change? Find out from those leading the charge.', 'exhibz'),
                'label_block' => true,
            ]
        );
         
        $repeater->add_control(
            'exhibz_slider_bg_image', [
                'label' => esc_html__('Background Image', 'exhibz'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'separator'=>'after',
            ]
        );
        $repeater->add_control(
            'exhibz_button_one_text', [
                'label' => esc_html__('Button #1 Text', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button one', 'exhibz'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'exhibz_button_one', [
                'label' => esc_html__( 'Button #1', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
                'separator'=>'after', 
                'separator'=>'before', 
            ]
        );
        $repeater->add_control(
            'exhibz_button_two_text', [
                'label' => esc_html__('Button #2 Text', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button Two', 'exhibz'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'exhibz_button_two', [
                'label' => esc_html__( 'Button #2', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
                'separator'=>'after', 
                'separator'=>'before',  
            ]
        );

        $repeater->add_control(
            'content_align_text', [
                'label' => esc_html__( 'Content Alignment', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'mx-auto text-center',
                'options' => [
                   'mr-auto'  => esc_html__( 'Left', 'exhibz' ),
                   'mx-auto text-center' => esc_html__( 'Center', 'exhibz' ),
                   'ml-auto text-right' => esc_html__( 'Right', 'exhibz' ),
             
                ],
            ]
        );

        $repeater->add_control(
            'justify_content_text', [
                'label' => esc_html__( 'Justify content', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'exhibz' ),
                'label_off' => esc_html__( 'No', 'exhibz' ),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
			'exhibz_slider_items',
			[
				'label' => esc_html__('Exhibz Slider', 'exhibz'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'exhibz_slider_title' =>  esc_html__(' Slider #1', 'exhibz'),
					],
					[
						'exhibz_slider_title' => esc_html__(' Slider #2', 'exhibz'),
					],
					[
						'exhibz_slider_title' => esc_html__(' Slider #3', 'exhibz'),
					],
				],
				'title_field' => '{{{ exhibz_slider_title }}}',
			]
        );

        $this->add_control(
            'ts_slider_autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'exhibz' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'exhibz' ),
                'label_off' => esc_html__( 'No', 'exhibz' ),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
         'ts_slider_dot_nav_show',
             [
             'label' => esc_html__( 'Dot nav', 'exhibz' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'Yes', 'exhibz' ),
             'label_off' => esc_html__( 'No', 'exhibz' ),
             'return_value' => 'yes',
             'default' => 'yes'
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
             'default' => 'yes'
             ]
         );
         $this->add_control(
            'slider_speed',
            [
                'label'   => esc_html__('Slider Speed', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1500
            ]
        );

        $this->end_controls_section();

        //style
        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style Section', 'exhibz' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		); 
            $this->add_control(
                'team_text_color',
                [
                    'label' => esc_html__('Title color', 'exhibz'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content-wrap .banner-title' => 'color: {{VALUE}};',
                    
                    ],
                ]
            );

      
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                'name'		 => 'exhibz_testimonial_typography',
                'selectors'	 => [
                    '{{WRAPPER}} .banner-content-wrap',
                            
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typo',
                    'label' => __( 'Title Typo', 'exhibz' ),
                    'selector' => '{{WRAPPER}} .banner-content-wrap .banner-title',
                ]
            );

        $this->end_controls_section(); 
        
        $this->start_controls_section(
			'exhibz_slider_buttons',
			[
				'label' => esc_html__( 'Buttons Style', 'exhibz' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		); 

            $this->start_controls_tabs( 'button_color' );

                $this->start_controls_tab(
                    'button_color_normal',
                    [
                        'label' => __( 'Normal', 'exhibz' ),
                    ]
                );

                $this->add_control(
                    'button1_background_color',
                    [
                        'label' => __( 'Button One Bg', 'exhibz' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .main-slider .ts-banner-btn .btn' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button2_background_color',
                    [
                        'label' => __( 'Button Two Bg', 'exhibz' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .main-slider .ts-banner-btn .btn.fill' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'button_color_hover',
                [
                    'label' => __( 'Hover', 'exhibz' ),
                ]
            );

                $this->add_control(
                    'button1_background_hover',
                    [
                        'label' => __( 'Button One hover Bg', 'exhibz' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .main-slider .ts-banner-btn .btn:hover' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button2_background_hover',
                    [
                        'label' => __( 'Button Two hover Bg', 'exhibz' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .main-slider .ts-banner-btn .btn.fill:hover' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_section();

    }

    protected function render( ) {

        $settings      = $this->get_settings();
        $slider_style   = $settings['style'];

        $exhibz_slider = $settings['exhibz_slider_items'];
        $slider_speed = $settings['slider_speed'];

        $auto_nav_slide    =   $settings['ts_slider_autoplay']=="yes"?true:false;
        $dot_nav_show      =   $settings['ts_slider_dot_nav_show'];
        $arrow_nav_show      =   $settings['ts_slider_arrow_nav_show'];

        $slide_controls    = [
            'auto_nav_slide'=>$auto_nav_slide,
            'slider_speed'=> $slider_speed,
            'dot_nav_show'=> $dot_nav_show,
        ];
   
        $slide_controls = \json_encode($slide_controls);
        
        include (locate_template("components/editor/elementor/widgets/style/main-slider/{$slider_style}.php", false, false ));  

    }

    protected function content_template() { }
}