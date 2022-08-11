<?php if (!defined('ABSPATH')) die('Direct access forbidden.');
/**
 * customizer option: optimization
 */

$options =[
    'optimization_settings' => [
        'title'		 => esc_html__( 'Optimization settings', 'exhibz' ),

        'options'	 => [
            'optimization_blocklibrary_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Block Library css files?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load block library css files?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_fontawesome_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Fontawesome icons?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load font awesome icons?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_elementoricons_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Elementor Icons?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load elementor icons?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_elementkitsicons_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Elementskit Icons?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load elementskit icons?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_dashicons_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Dash Icons?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load dash icons?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_meta_viewport' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Meta Description?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to load meta description in header?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
            'optimization_eventin_enable' => [
                'type'			 => 'switch',
                'label'			 => esc_html__( 'Load Eventin CSS/Js in Frontpage?', 'exhibz' ),
                'desc'			 => esc_html__( 'Do you want to eventin css/js in frontpage?', 'exhibz' ),
                'value'          => 'yes',
                'left-choice'	 => [
                    'value'	 => 'yes',
                    'label'	 => esc_html__( 'Yes', 'exhibz' ),
                ],
                'right-choice'	 => [
                    'value'	 => 'no',
                    'label'	 => esc_html__( 'No', 'exhibz' ),
                ],
            ],
        ],
    ]
];