<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Exhibz_Event_Category_Widget extends Widget_Base
{

   public $base;

   public function get_name(){
      return 'exhibz-event-category';
   }

   public function get_title()
   {
      return esc_html__('Event Category List', 'exhibz');
   }

   public function get_icon()
   {
      return 'eicon-post-list';
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

      $this->end_controls_section();
   }

   protected function render() {

        $settings             = $this->get_settings();
        $category_style       = $settings['category_style'];
        $categories_id  = $settings['categories_id'];

        $exhibz_event_category_settings = array(
			'category_style'    =>  $settings['category_style'],
			'hide_empty'    => $settings['hide_empty'],
			'category-options'   => array(
				'category_limit'  => $settings['category_limit'],
				'categories_id'  => $settings['categories_id'],
				'post_sort_by'  => $settings['post_sort_by']
			)
		);

        include (locate_template("components/editor/elementor/widgets/style/category/{$category_style}.php", false, false ));  

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
