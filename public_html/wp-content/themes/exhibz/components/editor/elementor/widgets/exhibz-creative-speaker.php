<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Exhibz_Creative_Speaker_Widget extends Widget_Base
{

    public $base;

    public function get_title()
    {
        return esc_html__('Creative Speakers', 'exhibz');
    }
    public function get_name()
    {
        return 'exhibz-creative-speaker';
    }
    public function get_icon()
    {
        return 'eicon-lock-user';
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
            'speakers_category',
            [
                'label'    => esc_html__('Speaker Category', 'exhibz'),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'options'  => $this->get_speakers_category(),
            ]
        );
        $this->add_control(
            'speaker_count',
            [
                'label'   => esc_html__('Number of Speaker to Show', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '6',
            ]
        );
        $this->add_control(
            'speaker_orderby',
            [
                'label'   => esc_html__('Order Speaker By', 'exhibz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'ID'        => esc_html__('Id', 'exhibz'),
                    'title'     => esc_html__('Title', 'exhibz'),
                    'post_date' => esc_html__('Post Date', 'exhibz'),
                ],
            ]
        );

        $this->add_control(
            'speaker_order',
            [
                'label'   => esc_html__('Speaker Order', 'exhibz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'exhibz'),
                    'ASC'  => esc_html__('Ascending', 'exhibz'),
                ],
            ]
        );
        $this->add_control(
            'enable_carousel',
            [
                'label'        => esc_html__('Enable Carousel?', 'exhibz'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'exhibz'),
                'label_off'    => esc_html__('No', 'exhibz'),
                'return_value' => 'yes',
                'default'      => ''
            ]
        );
        $this->add_control(
            'enable_scrollbar',
            [
                'label'        => esc_html__('Enable Scrollbar?', 'exhibz'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'exhibz'),
                'label_off'    => esc_html__('No', 'exhibz'),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'slider_settings',
            [
                'label'     => esc_html__('Slider Settings', 'exhibz'),
                'condition' => [
                    'enable_carousel' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'slider_items',
            [
                'label'   => esc_html__('Slides to Show', 'exhibz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->add_control(
            'slider_space_between',
            [
                'label'        => esc_html__('Slider Item Space', 'exhibz'),
                'description'  => esc_html__('Space between slides', 'exhibz'),
                'type'         => Controls_Manager::NUMBER,
                'return_value' => 'yes',
                'default'      => 30,
                'condition'    => ['enable_carousel' => 'yes']
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
                'default'   => 'yes'
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
                'condition' => ['show_navigation' => 'yes']
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
                'condition' => ['show_navigation' => 'yes']
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'speaker_settings',
            [
                'label'     => esc_html__('Grid Settings', 'exhibz'),
                'condition' => [
                    'enable_carousel!' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'speaker_column_count',
            [
                'label'           => esc_html__('Number of Column', 'exhibz'),
                'type'            => Controls_Manager::NUMBER,
                'min'             => 1,
                'max'             => 6,
                'step'            => 1,
                'desktop_default' => 3,
                'tablet_default'  => 2,
                'mobile_default'  => 1,
                'selectors'       => [
                    '{{WRAPPER}} .speakers-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
            ]
        );
        $this->add_responsive_control(
            'speaker_column_gap',
            [
                'label'      => esc_html__('Column Gap', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '30',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .speakers-grid' => 'grid-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'speaker_style_settings',
            [
                'label' => esc_html__('Speaker Style', 'exhibz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'speaker_name_typography',
                'label'          => esc_html__('Speaker Name Typography', 'exhibz'),
                'fields_options' => [
                    'typography'     => [
                        'default' => 'Anton',
                    ],
                    'font_size'      => [
                        'label'      => esc_html__('Font Size (px)', 'exhibz'),
                        'size_units' => ['px'],
                        'default'    => [
                            'size' => '50',
                            'unit' => 'px'
                        ]
                    ],
                    'font_weight'    => [
                        'default' => '400',
                    ],
                    'text_transform' => [
                        'default' => 'uppercase',
                    ],
                    'line_height'    => [
                        'default' => [
                            'size' => '62',
                            'unit' => 'px'
                        ]
                    ],
                    'letter_spacing' => [
                        'default' => [
                            'size' => '',
                        ]
                    ],
                ],
                'selector'       => '{{WRAPPER}} .exh-speaker-title',
            ]
        );
        $this->add_control(
            'speaker_name_color',
            [
                'label'     => esc_html__('Speaker Name Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exh-speaker-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'speaker_first_name_color',
            [
                'label'     => esc_html__('First Name Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff00',
                'selectors' => [
                    '{{WRAPPER}} .exh-speaker-title .first-name' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'speaker_name_stroke_color',
            [
                'label'     => esc_html_x('Speaker Name Stroke  Color', 'Border Control', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exh-speaker-title .first-name' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'exhibz_name_stroke_width',
            array(
                'label'      => esc_html__('Name Stroke Width', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px'
                ),
                'default'    => [
                    'unit' => 'px',
                    'size' => '2',
                ],
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .exh-speaker-title .first-name' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};'
                ),
            )
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
                    'left'     => '30',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exh-speaker-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'speaker_designation_typography',
                'label'    => esc_html__('Speaker Designation Typography', 'exhibz'),
                'selector' => '{{WRAPPER}} .exh-speaker-designation',
            ]
        );
        $this->add_control(
            'speaker_designation_color',
            [
                'label'     => esc_html__('Icon Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exh-speaker-designation' => 'color: {{VALUE}}',
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
                    'left'     => '30',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exh-speaker-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'speaker_social_style',
            [
                'label' => esc_html__('Speaker Social', 'exhibz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'social_icon_width',
            [
                'label'      => esc_html__('width', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 36,
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'social_icon_height',
            [
                'label'      => esc_html__('Height', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 36,
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'social_icon_typography',
                'label'          => esc_html__('Typography', 'exhibz'),
                'exclude'        => ['font_family', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing', 'word_spacing'],
                'fields_options' => [
                    'font_size'   => [
                        'label'      => esc_html__('Font Size (px)', 'exhibz'),
                        'size_units' => ['px'],
                        'default'    => [
                            'size' => '14',
                            'unit' => 'px'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                    'line_height' => [
                        'default' => [
                            'size' => '34',
                            'unit' => 'px'
                        ]
                    ],
                ],
                'selector'       => '{{WRAPPER}} .etn-speakers-social',
            ]
        );
        $this->start_controls_tabs(
            'icon_style_tabs'
        );

        $this->start_controls_tab(
            'icon_style_normal_tab',
            [
                'label' => __('Normal', 'exhibz'),
            ]
        );
        $this->add_control(
            'social_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'social_icon_bg_color',
            [
                'label'     => esc_html__('Icon Background Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'social_icon_border',
                'label'          => esc_html__('Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => 'solid',
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'default'   => [
                            'top'      => '2',
                            'right'    => '2',
                            'bottom'   => '2',
                            'left'     => '2',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'default'   => '#E5E5E5',
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_style_hover_tab',
            [
                'label' => __('Hover', 'exhibz'),
            ]
        );
        $this->add_control(
            'social_icon_color_hover',
            [
                'label'     => esc_html__('Icon Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'social_icon_bg_color_hover',
            [
                'label'     => esc_html__('Icon Background Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F75B57',
                'selectors' => [
                    '{{WRAPPER}} .etn-speakers-social a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'social_icon_border_hover',
                'label'          => esc_html__('Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => 'solid',
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a:hover' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'default'   => [
                            'top'      => '2',
                            'right'    => '2',
                            'bottom'   => '2',
                            'left'     => '2',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'default'   => '#FFFFFF00',
                        'selectors' => [
                            '{{WRAPPER}} .etn-speakers-social a:hover' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'social_icon_border_radius',
            [
                'label'      => esc_html__('Icon Border Radius', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '50',
                    'right'    => '50',
                    'bottom'   => '50',
                    'left'     => '50',
                    'unit'     => '%',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // Slider Navigation Style
        $this->start_controls_section(
            'slider_section_style',
            [
                'label'     => esc_html__('Slider Nav Style', 'exhibz'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['enable_carousel' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'icon_width',
            [
                'label'      => esc_html__('width', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    '%'  => [
                        'min' => -100,
                        'max' => 200,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_height',
            [
                'label'      => esc_html__('Height', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    '%'  => [
                        'min' => -100,
                        'max' => 200,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'icon_typography',
                'label'    => esc_html__('Typography', 'exhibz'),
                'exclude'  => ['font_family', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing', 'word_spacing'],
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );
        $this->start_controls_tabs(
            'deal_style_tabs'
        );

        $this->start_controls_tab(
            'deal_style_normal_tab',
            [
                'label' => __('Normal', 'exhibz'),
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color',
            [
                'label'     => esc_html__('Icon Background Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'navigation_icon_border',
                'label'          => esc_html__('Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next' => 'border-style: {{VALUE}};',
                            '{{WRAPPER}} .swiper-button-prev' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'default'   => [
                            'top'      => '',
                            'right'    => '',
                            'bottom'   => '',
                            'left'     => '',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}} .swiper-button-prev' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'default'   => '#E5E5E5',
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .swiper-button-prev' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'deal_style_hover_tab',
            [
                'label' => __('Hover', 'exhibz'),
            ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Icon Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_color_hover',
            [
                'label'     => esc_html__('Icon Background Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'navigation_icon_border_hover',
                'label'          => esc_html__('Border', 'exhibz'),
                'fields_options' => [
                    'border' => [
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next:hover' => 'border-style: {{VALUE}};',
                            '{{WRAPPER}} .swiper-button-prev:hover' => 'border-style: {{VALUE}};',
                        ],
                    ],
                    'width'  => [
                        'default'   => [
                            'top'      => '',
                            'right'    => '',
                            'bottom'   => '',
                            'left'     => '',
                            'isLinked' => true,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}} .swiper-button-prev:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'default'   => '#E5E5E5',
                        'selectors' => [
                            '{{WRAPPER}} .swiper-button-next:hover' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                        ],
                    ]
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'nav_border_radius',
            [
                'label'      => esc_html__('Nav Border Radius', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_navigation_margin',
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
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .speaker-slider-nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        // Slider Navigation Style
        $this->start_controls_section(
            'slider_scrollbar_style',
            [
                'label'     => esc_html__('Scrollbar Style', 'exhibz'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['enable_scrollbar' => 'yes']
            ]
        );
        $this->add_responsive_control(
            'slider_scrollbar_width',
            [
                'label'      => esc_html__('Width', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => [
                    'unit' => '%',
                    'size' => 85,
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .exhibz-speaker-scrollbar.swiper-pagination' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_scrollbar_height',
            [
                'label'      => esc_html__('Height', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .exhibz-speaker-scrollbar.swiper-pagination' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_scrollbar_margin',
            [
                'label'      => esc_html__('Margin (px)', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '60',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-speaker-scrollbar.swiper-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            'slider_scrollbar_color',
            [
                'label'     => esc_html__('Scrollbar Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#E3E3E4',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-speaker-scrollbar.swiper-pagination' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'slider_scrollbar_active_color',
            [
                'label'     => esc_html__('Scrollbar Active Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        // end styles
    }

    public static function get_speakers_category($id = null)
    {
        $speaker_category = [];
        try {

            if (is_null($id)) {
                $terms = get_terms([
                    'taxonomy'   => 'etn_speaker_category',
                    'hide_empty' => false,
                ]);

                foreach ($terms as $speakers) {
                    $speaker_category[$speakers->term_id] = $speakers->name;
                }

                return $speaker_category;
            } else {
                // return single speaker
                return get_post($id);
            }

        } catch (\Exception $es) {
            return [];
        }

    }

    protected function render()
    {

        $settings = $this->get_settings();
        $settings['widget_id'] = $this->get_id();

        $speakers_category = $settings["speakers_category"];
        $item_class = ($settings['enable_carousel'] == 'yes') ? 'swiper-slide' : 'speaker-grid-item';
        $args = array(
            'post_type'      => 'etn-speaker',
            'posts_per_page' => isset($settings['speaker_count']) ? $settings['speaker_count'] : 6,
            'order'          => isset($settings['speaker_order']) ? $settings['speaker_order'] : 'DESC',
            'orderby'        => isset($settings['speaker_orderby']) ? $settings['speaker_orderby'] : 'date',
            'tax_query'      => [
                'taxonomy' => $speakers_category,
                'field'    => 'slug',
            ]
        );
        if (is_array($speakers_category) && !empty($speakers_category)) {
            $categories = [
                'taxonomy'         => 'etn_speaker_category',
                'terms'            => $speakers_category,
                'field'            => 'id',
                'include_children' => true,
                'operator'         => 'IN',
            ];
            array_push($args['tax_query'], $categories);
        }
        $query = get_posts($args);
        ?>
        <div class="<?php echo esc_attr($this->get_name()); ?>" data-widget_settings='<?php echo json_encode($settings); ?>'>
            <?php if (!empty($settings['enable_carousel']) && $settings['enable_carousel'] == 'yes') : ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php else: ?>
                    <div class="speakers-grid">
                        <?php endif;
                        ?>
                        <?php
                        foreach ($query as $post):
                            $social = get_post_meta($post->ID, 'etn_speaker_socials', true);
                            $etn_speaker_designation = get_post_meta($post->ID, 'etn_speaker_designation', true);
                            $speaker_overlay_color = $data['speaker_image_overlay_color'] = exhibz_meta_option($post->ID, 'speaker_image_overlay_color', '#FF2E00');
                            $speaker_overlay_blend_mode = $data['speaker_image_blend_mode'] = exhibz_meta_option($post->ID, 'speaker_image_blend_mode', 'darken');
                            $speaker_name = get_the_title($post->ID);
                            ?>
                            <div class="speaker-item <?php echo esc_attr($item_class); ?>"
                                 style="--speaker-overlay-color: <?php echo esc_attr($speaker_overlay_color); ?>; --speaker-overlay-blend-mode: <?php echo esc_attr($speaker_overlay_blend_mode); ?>">
                                <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>" class="exhibz-img-link">
                                    <div class="speaker-thumb">
                                        <?php
                                        if (get_the_post_thumbnail_url($post->ID)) {
                                            ?>
                                                <img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>"
                                                    alt="<?php the_title_attribute($post->ID); ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </a>
                                <div class="speaker-content-wrapper">
                                    <div class="etn-speakers-social">
                                        <?php
                                        if (is_array($social) & !empty($social)) {
                                            ?>
                                            <?php
                                            foreach ($social as $social_value) {
                                                ?>
                                                <a href="<?php echo esc_url($social_value["etn_social_url"]); ?>"
                                                   title="<?php echo esc_attr($social_value["etn_social_title"]); ?>">
                                                    <i class="<?php echo esc_attr($social_value["icon"]); ?>"></i>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="speaker-information">
                                        <h3 class="exh-speaker-title">
                                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php echo esc_html($speaker_name); ?></a>
                                        </h3>
                                        <?php if($etn_speaker_designation !=''): ?>
                                            <p class="exh-speaker-designation">
                                                <?php
                                                    echo esc_html($etn_speaker_designation);                                               
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                        <a class="speaker-details-arrow"
                                           href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata();
                        ?>
                        <?php if (!empty($settings['enable_carousel']) && $settings['enable_carousel'] == 'yes') : ?>
                    </div>
                </div>
                <?php if ($settings['show_navigation'] == 'yes') { ?>
                    <div class="speaker-slider-nav-item swiper-button-prev swiper-prev-<?php echo esc_attr($this->get_id()); ?>">
                        <?php \Elementor\Icons_Manager::render_icon($settings['left_arrow_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                    <div class="speaker-slider-nav-item swiper-button-next swiper-next-<?php echo esc_attr($this->get_id()); ?>">
                        <?php \Elementor\Icons_Manager::render_icon($settings['right_arrow_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                <?php } ?>
                <?php if ($settings['enable_scrollbar'] == 'yes') { ?>
                    <div class="exhibz-speaker-scrollbar swiper-pagination">
                    </div>
                <?php } ?>
                <?php else: ?>
            </div>
        <?php endif; ?>

        </div>
        <?php

    }

    protected function content_template() {}
}
