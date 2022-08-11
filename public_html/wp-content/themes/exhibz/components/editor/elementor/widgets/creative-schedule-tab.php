<?php
namespace Elementor;

use Etn\Utils\Helper;

defined('ABSPATH') || exit;

class Exhibz_Creative_Schedule_Tab extends Widget_Base
{


    public $base;

    public function get_name()
    {
        return 'creative-schedule';
    }

    public function get_title()
    {
        return esc_html__('Creative Schedules Tab', 'exhibz');
    }

    public function get_icon()
    {
        return 'eicon-table';
    }

    public function get_categories()
    {
        return ['etn-event'];
    }

    public function schedule_title()
    {
        $schedule_list = [];
        $args = array(
            'post_type' => 'ts-schedule',
        );
        $i = 1;
        $posts = get_posts($args);
        foreach ($posts as $postdata) {
            setup_postdata($postdata);
            $schedule_list[$postdata->ID] = [$postdata->post_title];
        }

        return $schedule_list;
    }

    public function schedule_categories()
    {
        $term_list = [];
        $terms = get_terms('ts-schedule_cat', array(
            'hide_empty' => false,
        ));

        foreach ($terms as $term) {
            $term_list[$term->term_id] = [$term->name];
        }

        return $term_list;
    }

    protected function register_controls()
    {
        // Start of schedule section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Schedule settings', 'exhibz'),
            ]
        );
        $this->add_control(
            'schedule_id',
            [
                'label'    => esc_html__('Schedule', 'exhibz'),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'options'  => $this->get_schedules(),
            ]
        );
        $this->add_control(
            'schedule_style',
            [
                'label'   => esc_html__('Schedule Style', 'exhibz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'schedule-1',
                'options' => [
                    'schedule-1' => esc_html__('Schedule 1', 'exhibz'),
                ],
            ]
        );
        $this->add_control(
            'etn_schedule_order',
            [
                'label'   => esc_html__('Schedule order', 'exhibz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'exhibz'),
                    'ASC'  => esc_html__('Ascending', 'exhibz'),
                ],
            ]
        );
        $this->end_controls_section();
        // End of schedule section

        // Start of nav section
        $this->start_controls_section(
            'nav_style',
            [
                'label' => esc_html__('Nav Style', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'nav_align', [
                'label'     => esc_html__('Alignment', 'exhibz'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [

                    'left'    => [
                        'title' => esc_html__('Left', 'exhibz'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'exhibz'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'exhibz'),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'exhibz'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        //Responsive control end

        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_nav_typography',
                'label'    => esc_html__('Nav Title Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .etn-nav li a',
            ]
        );

        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_nav_sub_typography',
                'label'    => esc_html__('Nav Sub Title Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a .etn-day',
            ]
        );
        $this->add_responsive_control(
            'nav_item_padding',
            [
                'label'      => esc_html__('Nav Items Padding (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__('Separator Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-nav li:not(:last-child):before' => 'background: {{VALUE}};',
                ],
            ]
        );
        //start of nav color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_nav_tabs'
        );

        //start of nav normal color tab
        $this->start_controls_tab(
            'etn_nav_normal_tab',
            [
                'label' => esc_html__('Normal', 'exhibz'),
            ]
        );

        $this->add_control(
            'etn_nav_color',
            [
                'label'     => esc_html__('Nav Title Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-nav li a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_sub_color',
            [
                'label'     => esc_html__('Nav Subtitle color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a .etn-day' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'nav_border',
                'label'    => esc_html__('Border', 'exhibz'),
                'selector' => '{{WRAPPER}} .etn-nav li a',
            ]
        );

        $this->end_controls_tab();
        //end of nav normal color tab

        //start of nav active color tab
        $this->start_controls_tab(
            'etn_nav_active_tab',
            [
                'label' => esc_html__('Active', 'exhibz'),
            ]
        );
        $this->add_control(
            'etn_nav_active_color',
            [
                'label'     => esc_html__('Nav active color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F7C831',
                'selectors' => [
                    '{{WRAPPER}} .etn-nav li a.etn-active'                  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a:after' => 'border-color: {{VALUE}} transparent transparent transparent;',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_sub_active_color',
            [
                'label'     => esc_html__('Nav Subtitle Active color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F7C831',
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a.etn-active .etn-day' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_angle_active_color',
            [
                'label'     => esc_html__('Nav Angle Active color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F7C831',
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a:after' => 'border-color: {{VALUE}}  transparent transparent transparent;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'nav_borderactive',
                'label'    => esc_html__('Border active', 'exhibz'),
                'selector' => '{{WRAPPER}} .etn-nav li a.etn-active',
            ]
        );
        $this->end_controls_tab();
        //end of nav hover color tab

        $this->end_controls_tabs();
        //end of nav color tabs (normal and hover)
        $this->end_controls_section();
        // End of nav section

        // Start of title section
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title Style', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_title_typography',
                'label'    => esc_html__('Title Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .etn-schedule-content .etn-title',
            ]
        );

        $this->add_control(
            'etn_title_color',
            [
                'label'     => esc_html__('Title color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-content .etn-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_schedule_title_margin',
            [
                'label'      => esc_html__('Margin (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-schedule-content .etn-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->end_controls_section();
        // End of title section

        // Start of title section
        $this->start_controls_section(
            'desc_style',
            [
                'label' => esc_html__('Speaker Style', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'speaker_name_typography',
                'label'    => esc_html__('Name Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .exhibz-schedule-speakers-title',
            ]
        );
        $this->add_control(
            'speaker_name_color',
            [
                'label'     => esc_html__('Name Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-schedule-speakers-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'speaker_name_margin',
            [
                'label'      => esc_html__('Margin (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-schedule-speakers-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'speaker_designation_typography',
                'label'    => esc_html__('Designation Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .exhibz-speaker-designation',
            ]
        );
        $this->add_control(
            'speaker_designation_color',
            [
                'label'     => esc_html__('Designation Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-speaker-designation' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'speaker_designation_margin',
            [
                'label'      => esc_html__('Margin (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-speaker-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'more_options',
            [
                'label'     => esc_html__('Speaker Image', 'exhibz'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'speaker_slide_item_border',
                'label'          => esc_html__('Speaker Image Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => 'solid',
                        'selectors' => [
                            '{{WRAPPER}} .etn-schedule-single-speaker img' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'label'     => esc_html__('Border Width', 'exhibz'),
                        'default'   => [
                            'top'      => '2',
                            'right'    => '2',
                            'bottom'   => '2',
                            'left'     => '2',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .etn-schedule-single-speaker img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'label'     => esc_html__('Border Color', 'exhibz'),
                        'default'   => '#F7C831',
                        'selectors' => [
                            '{{WRAPPER}} .etn-schedule-single-speaker img' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->add_responsive_control(
            'speaker_slide_item_border_radius',
            [
                'label'      => esc_html__('Image Border Radius', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => '50',
                    'right'  => '50',
                    'bottom' => '50',
                    'left'   => '50',
                    'unit'   => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-schedule-single-speaker img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        // End of desc section

        // Start of title section
        $this->start_controls_section(
            'schedule_time_style',
            [
                'label' => esc_html__('Schedule Time style', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'etn_schedule_time_typography',
                'label'          => esc_html__('Schedule Time Typography', 'exhibz'),
                'fields_options' => [
                    'typography'     => [
                        'default' => 'Default',
                    ],
                    'font_size'      => [
                        'label'      => esc_html__('Font Size (px)', 'exhibz'),
                        'size_units' => ['px'],
                        'default'    => [
                            'size' => '20',
                            'unit' => 'px'
                        ]
                    ],
                    'font_weight'    => [
                        'default' => '700',
                    ],
                    'text_transform' => [
                        'default' => 'uppercase',
                    ],
                    'line_height'    => [
                        'default' => [
                            'size' => '24',
                            'unit' => 'px'
                        ]
                    ],
                    'letter_spacing' => [
                        'default' => [
                            'size' => '',
                        ]
                    ],
                ],
                'selector'       => '{{WRAPPER}}  .etn-schedule-info .exhibz-schedule-time',
            ]
        );

        $this->add_control(
            'etn_schedule_time_color',
            [
                'label'     => esc_html__('Schedule Time Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-info .exhibz-schedule-time' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_schedule_time_padding',
            [
                'label'      => esc_html__('Padding (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '30',
                    'bottom'   => '0',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-schedule-time p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->end_controls_section();
        // End of time style
        // Start of schedule item style
        $this->start_controls_section(
            'schedule_item_style',
            [
                'label' => esc_html__('Schedule Item Style', 'exhibz'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'etn_schedule_item_background',
            [
                'label'     => esc_html__('Item Background Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#101114',
                'selectors' => [
                    '{{WRAPPER}} .etn-single-schedule-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_schedule_item_margin',
            [
                'label'      => esc_html__('Margin (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '10',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-schedule-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'etn_schedule_item_padding',
            [
                'label'      => esc_html__('Padding (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-schedule-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'etn_schedule_item_border',
                'label'          => esc_html__('Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => 'solid',
                        'selectors' => [
                            '{{WRAPPER}} .etn-single-schedule-item' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'label'     => esc_html__('Border Width', 'exhibz'),
                        'default'   => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '0',
                            'left'     => '0',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .etn-single-schedule-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'label'     => esc_html__('Border Color', 'exhibz'),
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .etn-single-schedule-item' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->add_responsive_control(
            'etn_schedule_item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => '%',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-schedule-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function get_schedules()
    {
        return Helper::get_schedules();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $settings['widget_id'] = $this->get_id();
        $style = $settings["schedule_style"];
        $etn_schedule_order = $settings["etn_schedule_order"];
        $etn_schedule_ids = $settings["schedule_id"];
        $order = isset($etn_schedule_order) ? $etn_schedule_order : 'ASC';

        require "style/schedule/creative-schedule-tab.php";
    }
}
