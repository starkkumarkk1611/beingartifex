<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [

    'exhibz_etn_speaker_style' => [
        'type'     => 'box',
        'priority' => 'high',
        'options'  => [
            'speaker_image_overlay_color' => [
                'type'     => 'color-picker',
                'value'    => '#FF2E00',
                'palettes' => ['#EB00FF', '#09BD1B', '#FFB800', '#FF2E00', '#128DFF', '#B3D000', '#FFB41D', '#54E9CF', '#C4A0FF'],
                'label'    => __('Image Overlay Color', 'exhibz'),
            ],
            'speaker_image_blend_mode'    => [
                'type'        => 'select',
                'label'       => esc_html__('Overlay Blend Mode', 'exhibz'),
                'desc'        => esc_html__('Select speaker image overly blend mode.', 'exhibz'),
                'choices'     => [
                    'darken'   => esc_html__('Darken', 'exhibz'),
                    'multiply' => esc_html__('Multiply', 'exhibz'),
                ],
                'no-validate' => false,
            ],
        ],
        'title'    => esc_html__('Speaker Style', 'exhibz'),
    ]
];