<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;


class Exhibz_Countdown_Widget extends Widget_Base {


    public $base;

    public function get_name() {
        return 'exhibz-countdown';
    }

    public function get_title() {
        return esc_html__( 'Count Down', 'exhibz' );
    }

    public function get_icon() { 
        return 'eicon-countdown';
    }

    public function get_categories() {
        return [ 'exhibz-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Count Down settings', 'exhibz'),
            ]
        );

     

        $this->add_control(
			'event_date', [
				'label'			=> esc_html__( 'Event Date ', 'exhibz' ),
				'type'			=> Controls_Manager::DATE_TIME,
				'label_block'	=> true,
				'placeholder'	=> esc_html__( 'Event Date', 'exhibz' ),
	
			]
        );
        
        $this->add_control(
			'countdown_style',
			[
				'label' => __( 'Count Down Style', 'exhibz' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'jcounter-1',
				'options' => [
					'jcounter-1'  => esc_html__( 'Coundown Plain', 'exhibz' ),
                    'jcounter-2'  => esc_html__( 'Countdown Cicle', 'exhibz' ),
                    'jcounter-3'  => esc_html__( 'Countdown highlight', 'exhibz' ),
                    'jcounter-4'  => esc_html__( 'Countdown Block', 'exhibz' )
				],
			]
        );
        


        $this->end_controls_section();

         //countdown Style Section
		$this->start_controls_section(
			'section_title_style', [
				'label'	 => esc_html__( 'CountDown', 'exhibz' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'countdown_number_typography',
                'label'	 => esc_html__( 'Number typography  ', 'exhibz' ),
                'selector'	 => '{{WRAPPER}} .counter-item .countdown-number',
            ]
        );
      
        $this->add_group_control(
			Group_Control_Typography::get_type(), [
                'name'		 => 'countdown_text_typography',
                'label'	 => esc_html__( 'Text typography', 'exhibz' ),
                'selector'	 => '{{WRAPPER}} .counter-item .smalltext',
			]
        );
      
        $this->add_control(
            'countdown_number_color',
            [
                'label' => esc_html__('Number color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .counter-item .countdown-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'countdown_text_color',
            [
                'label' => esc_html__('Text color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .counter-item .smalltext' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .counter-item b' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        //countdown Style Section
        $this->start_controls_section(
            'section_circle_style', [
                'label'	 => esc_html__( 'CountDown Circle', 'exhibz' ),
                'tab'	 => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'countdown_style' => 'jcounter-2',
                ],
            ]
        );

        $this->add_control(
            'countdown_day_circle_color',
            [
                'label' => esc_html__('Day Circle Color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .countdown .counter-item .day-circle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'countdown_hr_circle_color',
            [
                'label' => esc_html__('Hour Circle Color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .countdown .counter-item .hr-circle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'countdown_min_circle_color',
            [
                'label' => esc_html__('Minute Circle Color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .countdown .counter-item .min-circle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'countdown_sec_circle_color',
            [
                'label' => esc_html__('Second Circle Color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .countdown .counter-item .sec-circle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    } //Register control end

    protected function render( ) { 
      $settings   = $this->get_settings();
      $event_date = $settings["event_date"];
      $event_date = date('d M Y H:i:s', strtotime($event_date));
      $style      = $settings["countdown_style"];
    ?>
    <?php if($style == 'jcounter-1'): ?>  
        
        <div class="ts-count-down">
            <div class="countdown etn-countdown-wrap" data-start-date="<?php echo esc_attr($event_date); ?>">

                <div class="counter-item etn-count-item etn-days">
                    <span class="countdown-number day-count days"> <?php echo esc_html__('00','exhibz'); ?> </span>
                    <div class="smalltext"> <?php echo esc_html__('Days','exhibz'); ?> </div>
                    <b>:</b>
                </div>
               
                <div class="counter-item etn-count-item etn-hours">
                    <span class="countdown-number hr-count hours"><?php echo esc_html__('00','exhibz'); ?></span>
                    <div class="smalltext"><?php echo esc_html__('Hours','exhibz'); ?></div>
                    <b>:</b>
                </div>
               
                <div class="counter-item etn-count-item etn-minutes">
                    <span class="countdown-number min-count minutes"><?php echo esc_html__('00','exhibz'); ?></span>
                    <div class="smalltext"><?php echo esc_html__('Minutes','exhibz'); ?></div>
                    <b>:</b>
                </div>
                
                <div class="counter-item etn-count-item etn-seconds">
                    <span class="countdown-number sec-count seconds"><?php echo esc_html__('00','exhibz'); ?></span>
                    <div class="smalltext"><?php echo esc_html__('Seconds','exhibz'); ?></div>
                </div>
            </div>
        </div>
       
    <?php elseif($style=="jcounter-2"): ?>

     <div data-start-date="<?php echo esc_attr($event_date); ?>" class="countdown etn-countdown-wrap fadeInUp" data-wow-duration="1.5s" data-wow-delay="800ms">
        <div class="counter-item">
            <i class="day-circle icon icon-ring-1Asset-1"></i>
            <span class="day-count days countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Days','exhibz'); ?></div>
        </div>
        <div class="counter-item">
            <i class="hr-circle icon icon-ring-4Asset-3"></i>
            <span class="hr-count hours countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Hours','exhibz'); ?></div>
        </div>
        <div class="counter-item">
            <i class="min-circle icon icon-ring-3Asset-2"></i>
            <span class="min-count minutes countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Minutes','exhibz'); ?></div>
        </div>
        <div class="counter-item">
            <i class="sec-circle icon icon-ring-4Asset-3"></i>
            <span class="sec-count seconds countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Seconds','exhibz'); ?></div>
        </div>
    </div>
    <?php elseif($style=="jcounter-3"): ?>
   
    <div class="ts-count-down highlight-count-down">
        <div data-start-date="<?php echo esc_attr($event_date); ?>"  class="etn-countdown-wrap countdown clearfix ">
            <div class="counter-item">
            <span class="day-count days countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Days','exhibz'); ?></div>
            <b>:</b>
            </div>
            <div class="counter-item">
            <span class="hr-count hours countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Hours','exhibz'); ?></div>
            <b>:</b>
            </div>
            <div class="counter-item">
            <span class="min-count minutes countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Minutes','exhibz'); ?></div>
            <b>:</b>
            </div>
            <div class="counter-item">
            <span class="sec-count seconds countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <div class="smalltext"><?php echo esc_html__('Seconds','exhibz'); ?></div>
            </div>
        </div>
    </div>

    <?php elseif($style=="jcounter-4"): ?>
   
    <div class="ts-count-down block-count-down">
        <div data-start-date="<?php echo esc_attr($event_date); ?>"  class="countdown etn-countdown-wrap clearfix ">
            <div class="counter-item">
                <span class="day-count days countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
                <span class="smalltext"><?php echo esc_html__('d','exhibz'); ?></span>
            </div>
            <div class="counter-item">
            <span class="hr-count hours countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <span class="smalltext"><?php echo esc_html__('h','exhibz'); ?></span>
            
            </div>
            <div class="counter-item">
            <span class="min-count minutes countdown-number"><?php echo esc_html__('00','exhibz'); ?></span>
            <span class="smalltext"><?php echo esc_html__('m','exhibz'); ?></span>
            
            </div>
            <div class="counter-item">
            <span class="sec-count seconds countdown-number"><?php echo esc_html__('00','exhibz'); ?> </span>
            
            <span class="smalltext"><?php echo esc_html__('s','exhibz'); ?></span>
            </div>
        </div>
    </div>

    <?php endif; ?>  

    <?php  
    }
    protected function content_template() { }
}