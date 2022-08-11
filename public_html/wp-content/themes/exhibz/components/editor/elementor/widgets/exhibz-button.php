<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Exhibz_Button_Widget extends Widget_Base
{

    public $base;

    public function get_name()
    {
        return 'exhibz-button';
    }

    public function get_title()
    {
        return esc_html__('Exhibz Button', 'exhibz');
    }

    public function get_icon()
    {
        return 'eicon-dual-button';
    }

    public function get_categories()
    {
        return ['exhibz-elements'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'exhibz_btn_section_content',
            array(
                'label' => esc_html__('Content', 'exhibz'),
            )
        );

        $this->add_control(
            'exhibz_btn_text',
            [
                'label'       => esc_html__('Button Text', 'exhibz'),
                'description' => esc_html__('"If you use this {} around text, it will be wrapped within a HTML span tag ex:{text}"', 'exhibz'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Grab {Ticket}', 'exhibz'),
                'placeholder' => esc_html__('Grab {Ticket}', 'exhibz'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'exhibz_btn_url',
            [
                'label'       => esc_html__('URL', 'exhibz'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_url('https://wpmet.com'),
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'exhibz_btn_section_settings',
            [
                'label'     => esc_html__('Settings', 'exhibz'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'exhibz_btn_icons__switch',
            [
                'label'     => esc_html__('Add icon? ', 'exhibz'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__('Yes', 'exhibz'),
                'label_off' => esc_html__('No', 'exhibz'),
            ]
        );

        $this->add_control(
            'exhibz_btn_icons',
            [
                'label'            => esc_html__('Icon', 'exhibz'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'exhibz_btn_icon',
                'label_block'      => true,
                'default'          => [
                    'value' => 'icon icon-right-arrow1',
                ],
                'condition'        => [
                    'exhibz_btn_icons__switch' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'exhibz_btn_icon_align',
            [
                'label'     => esc_html__('Icon Position', 'exhibz'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => [
                    'left'  => esc_html__('Before', 'exhibz'),
                    'right' => esc_html__('After', 'exhibz'),
                ],
                'condition' => [
                    'exhibz_btn_icons__switch' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'exhibz_btn_align',
            [
                'label'     => esc_html__('Alignment', 'exhibz'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'exhibz'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'exhibz'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'exhibz'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ekit-btn-wraper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'exhibz_btn_class',
            [
                'label'       => esc_html__('Class', 'exhibz'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Class Name', 'exhibz'),
            ]
        );

        $this->add_control(
            'exhibz_btn_id',
            [
                'label'       => esc_html__('id', 'exhibz'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ID', 'exhibz'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exhibz_btn_section_style',
            [
                'label' => esc_html__('Button', 'exhibz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'     => esc_html__('Width (%)', 'exhibz'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn' => 'width: {{SIZE}}%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'exhibz_btn_text_padding',
            [
                'label'      => esc_html__('Padding', 'exhibz'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '15',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'exhibz_btn_typography',
                'label'          => esc_html__('Typography', 'exhibz'),
                'fields_options' => [
                    'typography'     => [
                        'default' => 'Anton',
                    ],
                    'font_size'      => [
                        'label'      => esc_html__('Font Size (px)', 'exhibz'),
                        'size_units' => ['px'],
                        'default'    => [
                            'size' => '22',
                            'unit' => 'px'
                        ]
                    ],
                    'font_weight'    => [
                        'default' => '800',
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
                'selector'       => '{{WRAPPER}} .exhibz-btn',
            ]
        );
        $this->add_responsive_control(
            'exhibz_btn_text_align',
            [
                'label'     => esc_html__('Alignment', 'exhibz'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'exhibz'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'exhibz'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'exhibz'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-button-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'exhibz_btn_shadow',
                'selector' => '{{WRAPPER}} .exhibz-btn',
            ]
        );

        $this->start_controls_tabs('exhibz_btn_tabs_style');

        $this->start_controls_tab(
            'exhibz_btn_tabnormal',
            [
                'label' => esc_html__('Normal', 'exhibz'),
            ]
        );

        $this->add_control(
            'exhibz_btn_text_color',
            [
                'label'     => esc_html__('Text Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F52722',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'exhibz_btn_bg_color',
                'default'  => '',
                'selector' => '{{WRAPPER}} .exhibz-btn',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'exhibz_btn_tab_button_hover',
            [
                'label' => esc_html__('Hover', 'exhibz'),
            ]
        );

        $this->add_control(
            'exhibz_btn_hover_color',
            [
                'label'     => esc_html__('Text Color', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn:hover'          => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exhibz-btn:hover svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'exhibz_btn_bg_hover_color',
                'default'  => '',
                'selector' => '{{WRAPPER}} .exhibz-btn:hover',
            )
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'exhibz_btn_border_style_tabs',
            [
                'label' => esc_html__('Border Style', 'exhibz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'border_height',
			[
				'label' => esc_html__( 'Height', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .exhibz-btn::before, 
                    {{WRAPPER}} .exhibz-btn::after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exhibz-btn::before, 
                    {{WRAPPER}} .exhibz-btn::after' => 'background: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'border_color_on_hover',
			[
				'label' => esc_html__( 'Border Color On Hover', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exhibz-btn:hover::after' => 'background: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exhibz_btn_box_shadow_style',
            [
                'label' => esc_html__('Shadow', 'exhibz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exhibz_btn_box_shadow_group',
                'selector' => '{{WRAPPER}} .exhibz-btn',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exhibz_btn_iconw_style',
            [
                'label'     => esc_html__('Icon', 'exhibz'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exhibz_btn_icons__switch' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'exhibz_btn_normal_icon_font_size',
            array(
                'label'      => esc_html__('Font Size', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', 'rem',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .exhibz-btn > i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exhibz-btn > svg' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'exhibz_btn_normal_icon_padding_left',
            [
                'label'      => esc_html__('Add space after icon', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-btn > i, {{WRAPPER}} .exhibz-btn > svg'           => 'margin-right: {{SIZE}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .exhibz-btn > i, .rtl {{WRAPPER}} .exhibz-btn > svg' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ],
                'condition'  => [
                    'exhibz_btn_icon_align' => 'left',
                ],
            ]
        );
        $this->add_responsive_control(
            'exhibz_btn_normal_icon_padding_right',
            [
                'label'      => esc_html__('Add space before icon', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exhibz-btn > i, {{WRAPPER}} .exhibz-btn > svg'           => 'margin-left: {{SIZE}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .exhibz-btn > i, .rtl {{WRAPPER}} .exhibz-btn > svg' => 'margin-left: 0; margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'exhibz_btn_icon_align' => 'right',
                ],
            ]
        );

        $this->add_responsive_control(
            'exhibz_btn_normal_icon_vertical_align',
            array(
                'label'      => esc_html__('Move icon  Vertically', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', 'rem',
                ),
                'range'      => array(
                    'px'  => array(
                        'min' => -20,
                        'max' => 20,
                    ),
                    'em'  => array(
                        'min' => -5,
                        'max' => 5,
                    ),
                    'rem' => array(
                        'min' => -5,
                        'max' => 5,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .exhibz-btn i, {{WRAPPER}} .exhibz-btn svg' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}})',
                ),
            )
        );

        //  Icon style controls
        $this->start_controls_tabs(
            'icon_style_tabs'
        );

        $this->start_controls_tab(
            'data_style_normal_tab',
            [
                'label' => __('Normal', 'exhibz'),
            ]
        );

        $this->add_control(
            'exhibz_btn_icon_color',
            [
                'label'     => esc_html_x('Icon Color', 'Border Control', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn i'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exhibz-btn svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'exhibz_btn_icon_stroke_color',
            [
                'label'     => esc_html_x('Icon Stroke Color', 'Border Control', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn i'        => '-webkit-text-stroke-color: {{VALUE}};',
                    '{{WRAPPER}} .exhibz-btn svg path' => 'stroke: {{VALUE}};',
                ],
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
            'exhibz_btn_icon_hover_color',
            [
                'label'     => esc_html_x('Icon Hover Color', 'Border Control', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn:hover i'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exhibz-btn:hover svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'exhibz_btn_icon_stroke_hover_color',
            [
                'label'     => esc_html_x('Icon Stroke Hover Color', 'Border Control', 'exhibz'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exhibz-btn:hover i'        => '-webkit-text-stroke-color: {{VALUE}};',
                    '{{WRAPPER}} .exhibz-btn:hover svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_responsive_control(
            'exhibz_btn_icon_stroke_width',
            array(
                'label'      => esc_html__('Icon Stroke Width', 'exhibz'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px'
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .exhibz-btn > i' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};'
                ),
            )
        );


        $this->end_controls_section();

    }

    protected function render()
    {
        echo '<div class="ekit-wid-con" >';
        $this->render_raw();
        echo '</div>';
    }

    protected function render_raw()
    {
        $settings = $this->get_settings_for_display();

        $btn_text = $settings['exhibz_btn_text'];
        $btn_text = str_replace(['{', '}'], ['<span>', '</span>'], $btn_text);


        $btn_class = ($settings['exhibz_btn_class'] != '') ? $settings['exhibz_btn_class'] : '';
        $btn_id = ($settings['exhibz_btn_id'] != '') ? 'id=' . $settings['exhibz_btn_id'] : '';

        $icon_align = $settings['exhibz_btn_icon_align'];

      
        if (!empty($settings['exhibz_btn_url']['url'])) {
            $this->add_link_attributes('button', $settings['exhibz_btn_url']);
        }

        // Reset Whitespace for this specific widget
        $btn_class .= ' whitespace--normal';
        ?>
        <div class="ekit-btn-wraper">
            <?php
            if ($icon_align == 'right'): ?>
                <a <?php echo $this->get_render_attribute_string('button'); ?>
                        class="exhibz-btn <?php echo esc_attr($btn_class); ?>" <?php echo esc_attr($btn_id); ?>>
                    <span class="exhibz-button-text">
                        <?php echo exhibz_kses($btn_text); ?>
                    </span>

                    <?php
                    // new icon
                    $migrated = isset($settings['__fa4_migrated']['exhibz_btn_icons']);
                    // Check if its a new widget without previously selected icon using the old Icon control
                    $is_new = empty($settings['exhibz_btn_icon']);

                    if ($is_new || $migrated) {
                        // new icon
                        Icons_Manager::render_icon($settings['exhibz_btn_icons'], ['aria-hidden' => 'true']);
                    } else {
                        ?>
                        <i class="<?php echo esc_attr($settings['exhibz_btn_icon']); ?>" aria-hidden="true"></i>
                        <?php
                    }

                    ?>
                </a>
            <?php elseif ($icon_align == 'left'): ?>
                <a <?php echo $this->get_render_attribute_string('button'); ?>
                        class="exhibz-btn <?php echo esc_attr($btn_class); ?>" <?php echo esc_attr($btn_id); ?>>

                    <?php
                    // new icon
                    $migrated = isset($settings['__fa4_migrated']['exhibz_btn_icons']);
                    // Check if its a new widget without previously selected icon using the old Icon control
                    $is_new = empty($settings['exhibz_btn_icon']);

                    if ($is_new || $migrated) {
                        // new icon
                        Icons_Manager::render_icon($settings['exhibz_btn_icons'], ['aria-hidden' => 'true']);
                    } else {
                        ?>
                        <i class="<?php echo esc_attr($settings['exhibz_btn_icon']); ?>" aria-hidden="true"></i>
                        <?php
                    }

                    ?>

                    <span class="exhibz-button-text">
                        <?php echo exhibz_kses($btn_text); ?>
                    </span>
                </a>
            <?php else: ?>
                <a <?php echo $this->get_render_attribute_string('button'); ?>
                        class="exhibz-btn <?php echo esc_attr($btn_class); ?>" <?php echo esc_attr($btn_id); ?>>
                   <span class="exhibz-button-text">
                        <?php echo exhibz_kses($btn_text); ?>
                   </span>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function content_template()
    {
    }

}
