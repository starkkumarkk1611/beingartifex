<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Exhibz_Events_Location extends Widget_Base {

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name() {
        return 'exhibz-event-location';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Exhibz Events Location', 'exhibz' );
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-sort-amount-desc';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     * Used to determine where to display the widget in the editor.
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['etn-event'];
    }

    /**
     * Register the widget controls.
     * @access protected
     */
    protected function register_controls() {

        // Start of event section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__( 'Eventin Events Location', 'exhibz' ),
            ]
        );

        $this->add_control(
            'etn_event_count',
            [
                'label'   => esc_html__( 'Event location', 'exhibz' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '8',
            ]
        );

        $this->add_control(
            'etn_event_col',
            [
                'label'   => esc_html__( 'Event column', 'exhibz' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '3' => esc_html__( '4 Column ', 'exhibz' ),
                    '4' => esc_html__( '3 Column', 'exhibz' ),
                    '6' => esc_html__( '2 Column', 'exhibz' ),

                ],
            ]
        );

        $this->add_control(
            'event_locations_list',
            [
               'label'       => esc_html__( 'Select Locations', 'exhibz' ),
               'label_block' => true,
               'type'        => Controls_Manager::SELECT2,
               'options'     => $this->exhibz_all_taxonomy(),
               'multiple'    => true,
               'default'     => '',
            ]
         );

        $this->end_controls_section();

        // location style section
        $this->start_controls_section(
            'category_style',
            [
                'label' => esc_html__( 'Location Style', 'exhibz' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_location_title_typography',
                'label'    => esc_html__( 'Title Typography', 'exhibz' ),
                'selector' => '{{WRAPPER}} .location-box .location-des .location-name',
            ]
        );

        $this->add_control(
            'etn_location_color',
            [
                'label'     => esc_html__( 'Title Color', 'exhibz' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-box .location-des .location-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'etn_location_hover_color',
            [
                'label'     => esc_html__( 'Title Hover Color', 'exhibz' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-box:hover .location-des .location-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_typography',
                'label'    => esc_html__( 'Event Typography', 'exhibz' ),
                'selector' => '{{WRAPPER}} .location-box .location-des .event-number',
            ]
        );

        $this->add_control(
            'location_event',
            [
                'label'     => esc_html__( 'Event Color', 'exhibz' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-box .location-des .event-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        

        $this->end_controls_section();

        // location style section
        $this->start_controls_section(
            'wrapper_style',
            [
                'label' => esc_html__( 'Wrapper Style', 'exhibz' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'wrapper_margin',
			[
				'label' => __( 'Wrapper Margin', 'exhibz' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .location-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->add_responsive_control(
            'thumb_border_radius',
            [
                'label'      => esc_html__( 'border radius', 'exhibz' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .location-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

    }

    protected function render() {
        $settings           = $this->get_settings();
        $event_count        = $settings["etn_event_count"];
        $etn_event_col      = $settings["etn_event_col"];
        $location_slugs     =  $settings["event_locations_list"];

        include (locate_template("components/editor/elementor/widgets/style/event-location/style1.php", false, false )); 
    }

    protected function exhibz_all_taxonomy(){
        $tax_terms = get_terms('event_location', array('hide_empty' => false));
        $category_list = [];
        if(!empty($tax_terms)){
            foreach($tax_terms as $term_single) {      
                $category_list[$term_single->slug] = [$term_single->name];
            }
        }        
        return $category_list;
    }

}
