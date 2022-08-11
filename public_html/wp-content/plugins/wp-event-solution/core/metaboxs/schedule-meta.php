<?php

namespace Etn\Core\Metaboxs;

use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Schedule_meta extends Event_manager_metabox {
    public $metabox_id      = 'etn_schedule_settings';
    public $schedule_fields = [];
    public $cpt_id          = 'etn-schedule';
    
    public function register_meta_boxes() {
        add_meta_box( 
            $this->metabox_id, 
            esc_html__( 'Schedule info', 'eventin' ), 
            [$this, 'display_callback'], 
            $this->cpt_id 
        );
    }

    /**
     * Input fields array for speaker meta
     *
     * @return void
     */
    public function etn_schedule_meta_fields() {
        $this->schedule_fields = [
            'etn_schedule_title'  => [
                'label'    => esc_html__( 'Title', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Place schedule title', 'eventin' ),
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_schedule_date'   => [
                'label'     => esc_html__( 'Date', 'eventin' ),
                'desc'      => esc_html__( 'Select schedule date', 'eventin' ),
                'type'      => 'date',
                'inline'    => false,
                'timestamp' => false,
                'priority'  => 1,
                'attr'      => ['class' => 'etn-label-item etn-date'],
                'required'  => true,
            ],
            'etn_schedule_day'    => [
                'label'    => esc_html__( 'Week Day', 'eventin' ),
                'type'     => 'select_single',
                'multiple' => false,
                'options'  => Helper::day_name(),
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Name of the day of week', 'eventin' ),
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_schedule_sorting'    => [
                'label'    => esc_html__( 'Sorting order', 'eventin' ),
                'type'     => 'hidden',
                'default'  => '',
                'value'    => '',
                'desc'     => "",
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_schedule_topics' => [
                'label'    => esc_html__( 'Schedule List', 'eventin' ),
                'type'     => 'repeater',
                'default'  => '',
                'value'    => '',
                'options'  => [
    
                    'etn_schedule_topic'     => [
                        'label'    => esc_html__( 'Topic', 'eventin' ),
                        'type'     => 'text',
                        'default'  => '',
                        'value'    => '',
                        'desc'     => esc_html__( 'Place schedule topic', 'eventin' ),
                        'priority' => 1,
                        'attr'     => ['class' => ''],
                        'required' => true,
                    ],
                    'etn_shedule_start_time' => [
                        'label'    => esc_html__( 'Start Time', 'eventin' ),
                        'type'     => 'time',
                        'default'  => '',
                        'value'    => '',
                        'desc'     => esc_html__( 'Select start time ', 'eventin' ),
                        'priority' => 1,
                        'attr'     => ['class' => 'etn-time'],
                        'required' => true,
                    ],
                    'etn_shedule_end_time'   => [
                        'label'    => esc_html__( 'End Time', 'eventin' ),
                        'type'     => 'time',
                        'default'  => '',
                        'value'    => '',
                        'desc'     => esc_html__( 'Select end time ', 'eventin' ),
                        'priority' => 1,
                        'attr'     => ['class' => 'etn-time'],
                        'required' => true,
                    ],
                    'etn_shedule_room'       => [
                        'label'    => esc_html__( 'Location', 'eventin' ),
                        'type'     => 'text',
                        'default'  => '',
                        'value'    => '',
                        'desc'     => esc_html__( 'Place location here ', 'eventin' ),
                        'priority' => 1,
                        'attr'     => ['class' => ''],
                        'required' => true,
                    ],
                    'etn_shedule_speaker'    => [
                        'label'    => esc_html__( 'Speaker', 'eventin' ),
                        'type'     => 'select2',
                        'multiple' => true,
                        'default'  => '',
                        'value'    => '',
                        'options'  => Helper::get_speakers(),
                        'priority' => 1,
                        'desc'     => esc_html__( 'Select speaker ', 'eventin' ),
                        'required' => true,
                        'attr'     => ['class' => 'etn-event-speakers-section'],
                    ],
                    'etn_shedule_objective'  => [
                        'label'    => esc_html__( 'Details', 'eventin' ),
                        'type'     => 'textarea',
                        'default'  => '',
                        'value'    => '',
                        'desc'     => esc_html__( 'Place some details / overview of this slot / schedule.', 'eventin' ),
                        'attr'     => [
                            'class' => 'schedule',
                            'row'   => 30,
                            'col'   => 50,
                        ],
                        'settings' => [],
                        'priority' => 1,
                        'required' => true,
                    ],
                ],
                'desc'     => '',
                'attr'     => ['class' => ''],
                'priority' => 1,
                'required' => true,
            ],
        ];

        

        return $this->schedule_fields;
    }

    public function banner_meta_field(){
        return [];
    }

}
