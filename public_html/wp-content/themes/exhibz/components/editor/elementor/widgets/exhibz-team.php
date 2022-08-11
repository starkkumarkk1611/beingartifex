<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Exhibz_Team_Widget extends Widget_Base {

    public function get_name() {
        return 'exhibz-team';
    }

    public function get_title() {
        return esc_html__( 'Exhibz Team', 'exhibz' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['exhibz-elements'];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Exhibz Team', 'exhibz'),
            ]
         );
         
         $repeater = new \Elementor\Repeater();

         $repeater->add_control(
			'exhibz_team_title', [
                'label' => esc_html__('Team Title', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('James Killer', 'exhibz'),
                'label_block' => true,
			]
        );
         $repeater->add_control(
			'exhibz_team_designation', [
                'label' => esc_html__('Team Designation', 'exhibz'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Founder, Edilta', 'exhibz'),
                'label_block' => true,
			]
        );
         $repeater->add_control(
			'show_description', [
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'exhibz' ),
                'label_off' =>esc_html__( 'Hide', 'exhibz' ),
                'return_value' => 'yes',
                'default' => 'no',
			]
        );
         $repeater->add_control(
			'exhibz_team_description', [
                'label' => esc_html__('Team Description ', 'exhibz'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('How you transform your business as technology, consumer, habits industry.', 'exhibz'),
                'label_block' => true,
                'condition' => [
                    'show_description' => 'yes'
                ]
			]
        );
         $repeater->add_control(
			'exhibz_team_image', [
                'label' => esc_html__('Team Image', 'exhibz'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'separator'=>'after',
			]
        );
         $repeater->add_control(
			'exhibz_team_url', [
                'label' => esc_html__( 'Team URI', 'exhibz' ),
                'type' => Controls_Manager::URL,
                'label_block' => true, 
                'default' => [
                    'url' => '#',
                ],  
			]
        );
        $this->add_control(
			'exhibz_team_items',
			[
				'label' => esc_html__('Exhibz Team', 'exhibz'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'exhibz_team_title' => esc_html__(' Team #1', 'exhibz'),
					],
					[
						'exhibz_team_title' => esc_html__(' Team #1', 'exhibz'),
					],
					[
						'exhibz_team_title' => esc_html__(' Team #1', 'exhibz'),
					],
				],
				'title_field' => '{{{ exhibz_team_title }}}',
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
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'         => 'title_typography',
                'label'         => esc_html__('Title Typography', 'exhibz'),
                'selector'     => '{{WRAPPER}} .ts-speaker .ts-speaker-info .ts-title',
            ]
        );
        $this->add_control(
            'team_title_color',
            [
                'label' => esc_html__('Title color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ts-speaker .ts-speaker-info .ts-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'team_title_hover_color',
            [
                'label' => esc_html__('Title Hover color', 'exhibz'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ts-speaker:hover .ts-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'         => 'degnation_typography',
                'label'         => esc_html__('Degnation Typography', 'exhibz'),
                'selector'     => '{{WRAPPER}} .ts-speaker .ts-speaker-info p',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'         => 'description_typography',
                'label'         => esc_html__('Description Typography', 'exhibz'),
                'selector'     => '{{WRAPPER}} .ts-speaker .ts-speaker-info .discription p',
            ]
        );

        $this->add_control(
            'box_hover_bg_color',
            [
                'label'         => esc_html__('Box Hover color', 'exhibz'),
                'type'         => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .ts-speaker .speaker-img:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

      $this->end_controls_section();  

    }

    protected function render( ) {

        $settings      = $this->get_settings();
        $exhibz_team = $settings['exhibz_team_items'];
    ?>
        <!-- Team Wrapper -->    
        <div class="ts-team-wrapper">
            <div class="container">
                <div class="row">
                    <?php foreach ($exhibz_team as $team): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="ts-speaker">
                                <div class="speaker-img">
                                    <img src="<?php echo is_array($team["exhibz_team_image"])?$team["exhibz_team_image"]["url"]:''; ?>" alt="team-image">
                                    <a  href="<?php echo esc_url($team["exhibz_team_url"]['url']); ?>" class="view-speaker" rel="noreferrer">
                                        <i class="icon icon-plus"></i>
                                    </a>
                                </div>
                                <div class="ts-speaker-info">
                                    <h3 class="ts-title"> 
                                        <a href="<?php echo esc_url($team["exhibz_team_url"]['url']); ?>" rel="noreferrer"> 
                                            <?php echo esc_html($team["exhibz_team_title"]); ?>
                                        </a> 
                                    </h3>
                                    <p> <?php echo esc_html($team["exhibz_team_designation"]); ?></p>
                                    
                                    <?php                                       if ( 'yes' === $team['show_description'] ) {
                                          ?>
                                             <div class="discription">
                                                <p><?php echo wp_kses_post($team["exhibz_team_description"]); ?></p>
                                             </div>
                                        <?php                                       }
                                    ?>
                                   
                                </div>
                            </div>
                        </div><!-- col end-->
                    <?php endforeach; ?>
                </div><!-- row end-->
            </div>
                <!-- Container end -->
        </div>
            
       
        <!-- Team Wrapper end-->
     
        <?php   }

    protected function content_template() { }
}