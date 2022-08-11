<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Etn_Zoom extends Widget_Base {

    public $base;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        wp_register_script( 'zoom-init', \Wpeventin::plugin_url() . 'widgets/zoom/assets/js/zoom.init.js', ['elementor-frontend'], \Wpeventin::version(), true );
        // locallize data
        $form_data                              = [];
        $form_data['ajax_url']                  = admin_url( 'admin-ajax.php' );
        $form_data['zoom_create_meeting_nonce'] = wp_create_nonce( 'zoom_create_meeting_nonce' );
        wp_localize_script( 'zoom-init', 'zoom_js', $form_data );
    }

    public function get_script_depends() {
        return ['zoom-init'];
    }

    public function get_name() {
        return 'etn-zoom';
    }

    public function get_title() {
        return esc_html__( 'Eventin zoom', 'eventin' );
    }

    public function get_icon() {
        return 'fas fa-video';
    }

    public function get_categories() {
        return ['etn-event'];
    }

    protected function register_controls() {
        // get host list
        $user_list = \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->zoom_meeting_user_list();
        // get time zone
        $time_zone              = \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->get_timezone();
        $default_value_user     = is_array( $user_list ) && !empty( $user_list ) ? array_keys( $user_list )[0] : '';
        $default_value_timezone = is_array( $time_zone ) && !empty( $time_zone ) ? array_keys( $time_zone )[0] : '';

        $this->start_controls_section(
            'meeting_section_content',
            [
                'label' => esc_html__( 'Content', 'eventin' ),
            ]
        );

        $this->add_control(
            'zoom_style',
            [
                'label'   => esc_html__( 'Zoom Style', 'eventin' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'zoom-1',
                'options' => [
                    'zoom-1' => esc_html__( 'Style 1', 'eventin' ),
                    'zoom-2' => esc_html__( 'Style 2', 'eventin' ),
                    'zoom-3' => esc_html__( 'Style 3', 'eventin' ),
                    'zoom-4' => esc_html__( 'Style 4', 'eventin' ),

                ],
            ]
        );

        $this->add_control(
            'topic',
            [
                'label'       => esc_html__( 'Meeting Topic', 'eventin' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__( 'Write meeting topic a host of the meeting.(Optional)', 'eventin' ),
            ]
        );

        $this->add_control(
            'meeting_cache',
            [
                'label' => esc_html__( 'Meeting Data', 'eventin' ),
                'type'  => \Elementor\Controls_Manager::HIDDEN,
            ]
        );

        $this->add_control(
            'user_id',
            [
                'label'       => esc_html__( 'Meeting Hosts*', 'eventin' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $user_list,
                'label_block' => true,
                'default'     => $default_value_user,
                'description' => esc_html__( 'Select a host of the meeting.(Required)', 'eventin' ),
            ]
        );

        $this->add_control(
            'start_time',
            [
                'label'       => esc_html__( 'Start date/time*', 'eventin' ),
                'type'        => \Elementor\Controls_Manager::DATE_TIME,
                'default'     => date( 'y-m-d H:i' ),
                'description' => esc_html__( 'Select start date and time.(Required)', 'eventin' ),
            ]
        );

        $this->add_control(
            'timezone',
            [
                'label'       => esc_html__( 'Time zone', 'eventin' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $time_zone,
                'label_block' => true,
                'default'     => $default_value_timezone,
                'description' => esc_html__( 'Select timezone for meeting .(Optional)', 'eventin' ),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label'       => esc_html__( 'Duration', 'eventin' ),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 0,
                'description' => esc_html__( 'Meeting duration (minutes).(Optional)', 'eventin' ),
            ]
        );

        $this->add_control(
            'password',
            [
                'label'       => esc_html__( 'Password', 'eventin' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__( 'Password to join the meeting. Password may only contain the following characters: [a-z A-Z 0-9]. Max of 10 characters.( Leave blank for auto generate )', 'eventin' ),
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type'      => \Elementor\Controls_Manager::RAW_HTML,
                'raw'       => __( 'You can update meeting information from zoom report ( Eventin => Zoom Meetings )', 'eventin' ),
                'condition' => ['meeting_cache!' => ''],

            ]
        );

        $this->add_control(
            'create-meeting',
            [
                'type'        => \Elementor\Controls_Manager::BUTTON,
                'button_type' => 'success',
                'text'        => esc_html__( 'Create Meeting ', 'eventin' ) . Helper::kses( '<span class="elementor-state-icon">
                <i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
                </span>' ),
                'event'       => 'elementor:editor:create',
                'condition'   => ['meeting_cache' => ''],
            ]
        );

        $this->end_controls_section();

        // Start of title section
        $this->start_controls_section(
            'meeting_title_section',
            [
                'label' => esc_html__( 'Title Section', 'eventin' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //control for title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'meeting_title_typography',
                'label'    => esc_html__( 'Title Typography', 'eventin' ),
                'selector' => '{{WRAPPER}} .meeting-title',
            ]
        );

        //start of title color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_meeting_title_tabs'
        );

        //start of title normal color tab
        $this->start_controls_tab(
            'etn_meeting_title_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'eventin' ),
            ]
        );

        $this->add_control(
            'etn_meeting_title_color',
            [
                'label'     => esc_html__( 'Title color', 'eventin' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .meeting-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .meeting-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

// end of title normal color tab

        //start of title hover color tab
        $this->start_controls_tab(
            'etn_meeting_title_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'eventin' ),
            ]
        );

        $this->add_control(
            'etn_meeting_title_hover_color',
            [
                'label'     => esc_html__( 'Title Hover color', 'eventin' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .meeting-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .meeting-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        //end of title hover color tab

        $this->end_controls_tabs();

//end of title color tabs (normal and hover)

        //start of title margin control
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__( 'Title margin', 'eventin' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .meeting-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //end of title margin control

        $this->end_controls_section();

// End of title section

        // Start of block section
        $this->start_controls_section(
            'meeting_block',
            [
                'label' => esc_html__( 'Meeting Section', 'eventin' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //control for block typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ent_meeting_blcok_typography',
                'label'    => esc_html__( 'Meeting block typography', 'eventin' ),
                'selector' => '{{WRAPPER}} .meeting-info p',
            ]
        );

        //start of block color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_meeting_blcok_tabs'
        );

        //start of block normal color tab
        $this->start_controls_tab(
            'etn_meeting_blcok_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'eventin' ),
            ]
        );

        $this->add_control(
            'etn_meeting_blcok_color',
            [
                'label'     => esc_html__( 'Meeting block color', 'eventin' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .meeting-info p, .meeting-info a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .meeting-info p, .meeting-info a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

// end of block normal color tab

        //start of block hover color tab
        $this->start_controls_tab(
            'etn_meeting_blcok_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'eventin' ),
            ]
        );

        $this->add_control(
            'etn_meeting_blcok_hover_color',
            [
                'label'     => esc_html__( 'Meeting block hover color', 'eventin' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .meeting-info p:hover, .meeting-info a:hover'  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .meeting-info p:hover,  .meeting-info a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        //end of block hover color tab

        $this->end_controls_tabs();

//end of block color tabs (normal and hover)

        //start of block margin control
        $this->add_responsive_control(
            'meeting_blcok_margin',
            [
                'label'      => esc_html__( 'Meeting block margin', 'eventin' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .meeting-info p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //end of block margin control

        $this->end_controls_section();
        // End of block section

    }

    protected function render() {
        $settings      = $this->get_settings();
        $zoom_style = $settings['zoom_style'];
        $template_file = \Wpeventin::plugin_dir() . "widgets/zoom/style/zoom-1.php";

        if ( file_exists( $template_file ) ) {
            include $template_file;
        }

    }

}
