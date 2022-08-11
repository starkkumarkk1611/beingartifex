<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Event_Category_Slider_Widget extends Widget_Base
{

   public $base;

   public function get_name(){
      return 'exhibz-event-category-slider';
   }

   public function get_title()
   {
      return esc_html__('Event Category Slider', 'exhibz');
   }

   public function get_icon()
   {
      return 'eicon-slider-push';
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
            'label' => esc_html__('Event Category', 'exhibz'),
         ]
      );

      $this->add_control(
        'category_style',
        [
            'label' => esc_html__('Category Style', 'exhibz'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1'  => esc_html__( 'Style One', 'exhibz' ),
            ],
        ]
    );

      $this->add_control(
        'categories_id',
        [
          'label'     => esc_html__( 'Select Category', 'exhibz' ),
          'type'      => Controls_Manager::SELECT2,
          'options'   => $this->event_category(),
          'multiple' =>true,
        ]
      );

        $this->add_control(
            'category_limit',
            [
                'label'   => esc_html__( 'Limit categories', 'exhibz' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'step'    => 1,
            ]
        );

        $this->add_control(
         'post_sort_by',
         [
            'label' => esc_html__( 'Sort By', 'exhibz' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
               'ASC'  => esc_html__( 'ASC', 'exhibz' ),
               'DESC'  => esc_html__( 'DESC', 'exhibz' ),
            ],  
         ]
      );

      $this->add_control(
			'hide_empty',
			[
				'label'     => esc_html__( 'hide Empty?', 'exhibz' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
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

      $this->end_controls_section();

      //style
      $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'exhibz' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		); 

      $this->add_control(
         'category_title',
         [
             'label' => esc_html__('Title color', 'exhibz'),
             'type' => Controls_Manager::COLOR,
             'default' => '',
             'selectors' => [
                 '{{WRAPPER}} .ts-event-category-slider .event-slider-item .cat-content .ts-title a' => 'color: {{VALUE}};',
             
             ],
         ]
      );

      $this->add_control(
         'category_title_hover',
         [
             'label' => esc_html__('Title Hover color', 'exhibz'),
             'type' => Controls_Manager::COLOR,
             'default' => '',
             'selectors' => [
                 '{{WRAPPER}} .ts-event-category-slider .event-slider-item:hover .cat-content .ts-title a' => 'color: {{VALUE}};',
             
             ],
         ]
      );


      $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'category_title_typography',
				'label' => esc_html__( 'Typography', 'exhibz' ),
				'selector' => '{{WRAPPER}} .ts-event-category-slider .event-slider-item .cat-content .ts-title a',
			]
		);

      $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Title Padding', 'exhibz' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .ts-event-category-slider .event-slider-item .cat-content .ts-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


      $this->end_controls_section();


   }

   protected function render() {

        $settings             = $this->get_settings();
        $category_style       = $settings['category_style'];
        $categories_id  = $settings['categories_id'];
        
        $arrow_nav_show      =   $settings['ts_slider_arrow_nav_show'];

        $exhibz_event_category_settings = array(
			'category_style'    =>  $settings['category_style'],
			'hide_empty'    => $settings['hide_empty'],
			'category-options'   => array(
				'category_limit'  => $settings['category_limit'],
				'categories_id'  => $settings['categories_id'],
				'post_sort_by'  => $settings['post_sort_by']
			)
		);
        include (locate_template("components/editor/elementor/widgets/style/event-category-slider/event-category-slider.php", false, false ));  

   }
   protected function content_template(){}

   public function event_category(){
    if(!class_exists('\Etn\Bootstrap')){
      return [];
    }
    $tax_terms = get_terms('etn_category', array('hide_empty' => false));
    $category_list = [];
     
    foreach($tax_terms as $term_single) {      
        $category_list[$term_single->term_id] = [$term_single->name];
    }
  
    return $category_list;
  }
}
