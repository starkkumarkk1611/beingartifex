<?php
namespace Elementor;
use \Etn\Utils\Helper;

if (!defined('ABSPATH')) exit;


class Exhibz_Event_Ticket_Widget extends Widget_Base
{


    public $base;

    public function get_name()
    {
        return 'exhibz-event-ticket';
    }

    public function get_title()
    {
        return esc_html__('Exhibz Event Ticket ', 'exhibz');
    }

    public function get_icon()
    {
        return 'eicon-price-list';
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
                'label' => esc_html__('Pricing settings', 'exhibz'),
            ]
        );

        $this->add_control(
            "event_id",
            [
                "label"     => esc_html__("Select Event", "exhibz"),
                "type"      => Controls_Manager::SELECT2,
                "multiple"  => false,
                "options"   => Helper::get_events(),
            ]
        );

        $this->add_control(
            "show_title",
            [
                "label" => esc_html__("Show Title", "exhibz"),
                "type"  => Controls_Manager::SWITCHER,
                "label_on"  => esc_html__("Show", "exhibz"),
                "label_on"  => esc_html__("Hide", "exhibz"),
                "default"   => "yes"
            ]
        );

        $this->add_control(
            "plan_title",
            [
                "label" => esc_html__("Plan Title", "exhibz"),
                "type"  => Controls_Manager::TEXT,           
            ]
        );

        $this->end_controls_section();

         //style
        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style Section', 'exhibz' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        ); 
        
        $this->add_control(
			'plan_title_color',
			[
				'label' => esc_html__( 'Plan Title Color', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plan-title' => 'color: {{VALUE}}',
				],
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'plan_typography',
                'label' => esc_html__( 'Plan Typo', 'exhibz' ),
				'selector' => '{{WRAPPER}} .plan-title',
			]
		);

        $this->add_control(
			'plan_end_color',
			[
				'label' => esc_html__( 'Plan Date Color', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .end-date' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'price_image',
				'label' => esc_html__( 'Background', 'exhibz' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .price-image',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_form_price_typography',
                'label' => esc_html__( 'Price Typo', 'exhibz' ),
				'selector' => '{{WRAPPER}} .etn-price-field .etn-event-form-price',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
                'label' => esc_html__( 'Total Price Typo', 'exhibz' ),
				'selector' => '{{WRAPPER}} .exhibz-ticket-widget .etn-total-price',
			]
		);

        $this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Button Color', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exhibz-ticket-widget .exhibz-btn' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
                'label' => esc_html__( 'Button Typo', 'exhibz' ),
				'selector' => '{{WRAPPER}} .exhibz-ticket-widget .exhibz-btn',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_image',
				'label' => esc_html__( 'Wrapper Background', 'exhibz' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .exhibz-ticket-widget',
			]
		);

        $this->add_responsive_control(
			'wrapper_padding',
			[
				'label' => esc_html__( 'Wrapper Padding', 'exhibz' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exhibz-ticket-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    } //Register control end

    protected function render() {
        $settings               = $this->get_settings();
        $single_event_id        = !empty( $settings['event_id'] ) ? $settings['event_id'] : 0;
        $plan_title             =  $settings["plan_title"];

        if ( class_exists( 'WooCommerce' ) ) {
            if( function_exists('wc_print_notices') ){
             wc_print_notices();
            }
         }
        ?>
        <div class="exhibz-ticket-widget etn-event-form-widget">
            <?php
            if( !empty( $settings["show_title"] ) ){
                ?>
                <div>
                    <h3 class="etn-event-form-widget-title"><?php echo esc_html( get_the_title( $single_event_id ) );?></h3>
                </div>
                <?php
            }
            
            ?>
            <?php
            if( class_exists('WooCommerce') ){
                 
                $data = \Etn\Utils\Helper::single_template_options( $single_event_id );
                $etn_left_tickets = !empty( $data['etn_left_tickets'] ) ? $data['etn_left_tickets'] : 0;
                $etn_ticket_unlimited = ( isset( $data['etn_ticket_unlimited'] ) && $data['etn_ticket_unlimited'] == "no" ) ? true : false;
                $etn_ticket_price = isset( $data['etn_ticket_price']) ? $data['etn_ticket_price'] : '';
                $etn_deadline_value = isset( $data['etn_deadline_value']) ? $data['etn_deadline_value'] : '';
                $total_sold_ticket = isset( $ticket_qty ) ? intval( $ticket_qty ) : 0;
                $ticket_qty = get_post_meta( $single_event_id, "etn_sold_tickets", true );
                $is_zoom_event = get_post_meta( $single_event_id, 'etn_zoom_event', true );
                $event_options = !empty( $data['event_options']) ? $data['event_options'] : [];
                $event_title = get_the_title( $single_event_id );
                $min_purchase_qty       = !empty(get_post_meta( $single_event_id, 'etn_min_ticket', true )) ? get_post_meta( $single_event_id, 'etn_min_ticket', true ) : 1;
                $max_purchase_qty       = !empty(get_post_meta( $single_event_id, 'etn_max_ticket', true )) ? get_post_meta( $single_event_id, 'etn_max_ticket', true ) : $etn_left_tickets;
                $max_purchase_qty       =  min($etn_left_tickets, $max_purchase_qty);

                $ticket_variation = get_post_meta($single_event_id,"etn_ticket_variations",true);
                $etn_ticket_availability = get_post_meta($single_event_id,"etn_ticket_availability",true);
 
                ?>
              
                <div class="etn-widget etn-ticket-widget ticket-widget-banner">
                    <?php
                        if ($etn_left_tickets > 0) {
                            ?>
                            <h4 class="etn-widget-title etn-title etn-form-title"> <?php echo esc_html__(" Register Now:", 'exhibz'); ?>
                            </h4>
                            <?php
                            $attendee_reg_enable = !empty( \Etn\Utils\Helper::get_option( "attendee_registration" ) ) ? true : false;
                            ?>
                            <form method="post" class="etn-event-form-parent etn-ticket-variation">
                            <?php
                                if( $attendee_reg_enable ){
                                    ?>
                                    <?php  wp_nonce_field('ticket_purchase_next_step_two','ticket_purchase_next_step_two'); ?>
                                    <input name="ticket_purchase_next_step" type="hidden" value="two" />
                                    <input name="event_id" type="hidden" value="<?php echo intval($single_event_id); ?>" />
                                    <input name="event_name" type="hidden" value="<?php echo esc_html($event_title); ?>" />
                                    <?php
                                }else{
                                    ?>
                                    <input name="add-to-cart" type="hidden" value="<?php echo intval($single_event_id); ?>" />
                                    <input name="event_name" type="hidden" value="<?php echo esc_html($event_title); ?>" />
                                    <?php
                                }
                                ?>
                            <!-- Ticket Markup Starts Here -->
                            <?php
                            $ticket_variation = get_post_meta($single_event_id,"etn_ticket_variations",true);
                            $etn_ticket_availability = get_post_meta($single_event_id,"etn_ticket_availability",true);


                            if ( is_array($ticket_variation) && count($ticket_variation) > 0 ) { 
                                $cart_ticket = [];
                                if ( class_exists('Woocommerce') && !is_admin()){
                                    global $woocommerce;
                                    $items = $woocommerce->cart->get_cart();

                                    foreach($items as $item => $values) { 
                                        if ( !empty( $values['etn_ticket_variations']) ) {
                                            $variations = $values['etn_ticket_variations'];
                                            if ( !empty($variations) && !empty($variations[0]['etn_ticket_slug'])) {
                                                if ( !empty($cart_ticket[$variations[0]['etn_ticket_slug']])) {
                                                    $cart_ticket[$variations[0]['etn_ticket_slug']] += $variations[0]['etn_ticket_qty'];
                                                }else {
                                                    $cart_ticket[$variations[0]['etn_ticket_slug']] = $variations[0]['etn_ticket_qty'];
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                $number = !empty($i) ? $i : 0;

                                ?>
                                <div class="variations_<?php echo intval($number);?>">

                                    <input type="hidden" name="variation_picked_total_qty" value="0" class="variation_picked_total_qty" />
                                    <?php foreach ($ticket_variation as $key => $value) { 
                                        $etn_min_ticket   = !empty( $value['etn_min_ticket'] ) ? absint( $value['etn_min_ticket'] ) : 0 ;
                                        $etn_max_ticket   = !empty( $value['etn_max_ticket'] ) ? absint( $value['etn_max_ticket'] ) : 0 ;
                                        $sold_tickets  = absint( $value['etn_sold_tickets'] );
                                        $total_tickets = absint( $value['etn_avaiilable_tickets'] );

                                        $etn_cart_limit = 0;
                                        if (  !empty($cart_ticket) ) {
                                            $etn_cart_limit = !empty( $cart_ticket[$value['etn_ticket_slug']] ) ? $cart_ticket[$value['etn_ticket_slug']] : 0;
                                        }

                                        $etn_current_stock = absint( $total_tickets - $sold_tickets ); 
                                        $stock_outClass = ($etn_current_stock === 0) ? 'stock_out' : '';
                                        ?>
                                        <div class="event-registration variation_<?php esc_attr_e($key)?>">
                                            <div class="etn-row align-items-center etn-form-wrap">
                                                <div class="etn-col-md-4">
                                                    <div class="price-image">
                                                        <div class="content">
                                                            <h2 class="plan-title">
                                                                <?php esc_html_e($value['etn_ticket_name']);  ?>
                                                            </h2>
                                                            <p class="end-date">
                                                                <?php esc_html_e('Until ','exhibz'); echo esc_html($etn_deadline_value); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div><!-- ./col -->
                                                <div class="col-md-5 etn-single-ticket-item">
                                                    <div class="item">
                                                    <div class="ticket-price-item">
                                                            <div class="etn-ticket-price">
                                                                <?php 
                                                                    if(function_exists("get_woocommerce_currency_symbol")){
                                                                        echo esc_html(get_woocommerce_currency_symbol()); 
                                                                    }  esc_html_e($value['etn_ticket_price']);
                                                                ?>
                                                            </div>
                                                            <label><?php echo esc_html__("/ Seat","exhibz");?></label>
                                                        </div>
                                                    </div><!-- ./item -->
                                                    
                                                    <div class="item etn-variable-ticket-widget">
                                                    <!-- Min , Max and stock quantity checking start -->
                                                    <div class="ticket-price-item etn-quantity">
                                                            <button type="button" class="qt-btn qt-sub" data-multi="-1" data-key="<?php echo intval($key)?>">-</button>
                                                            <input name="ticket_quantity[]" type="number" 
                                                            data-price="<?php echo floatval($value['etn_ticket_price']);?>"
                                                            data-etn_min_ticket="<?php echo absint( $etn_min_ticket ); ?>"
                                                            data-etn_max_ticket="<?php echo absint( $etn_max_ticket ); ?>" 
                                                            data-etn_current_stock="<?php echo absint( $etn_current_stock ); ?>" 
                                                            data-stock_out="<?php echo esc_attr__("All ticket has has been sold","exhibz") ?>" 
                                                            data-cart_ticket_limit="<?php echo esc_attr__("You have already added 5 tickets.
                                                            You can't purchase more than $etn_max_ticket tickets","exhibz") ?>" 
                                                            data-stock_limit="<?php echo esc_attr__("Stock limit $etn_current_stock. You can purchase within $etn_current_stock.","exhibz") ?>" 
                                                            data-qty_message="<?php echo esc_attr__("Total Ticket quantity must be greater than or equal ","exhibz")
                                                            . $etn_min_ticket . esc_attr__(" and less than or equal ","exhibz") . $etn_max_ticket ; ?>"
                                                            data-etn_cart_limit="<?php echo absint( $etn_cart_limit ); ?>" 
                                                            data-etn_cart_limit_message="<?php echo esc_attr__("You have already added $etn_cart_limit,
                                                            Which is greater than maximum quantity $etn_max_ticket . You can add maximum $etn_max_ticket tickets. ","exhibz"); ?>" 

                                                            class="etn_ticket_variation ticket_<?php esc_attr_e($key)?>"
                                                            value="0" <?php echo ( !empty( $total_tickets ) && ( $sold_tickets == $total_tickets ) ) ? 'disabled' : '';  ?> />
                                                            <button type="button" class="qt-btn qt-add" data-multi="1" data-key="<?php echo intval($key)?>">+</button>
                                                        </div>

                                                        <!-- Min , Max and stock quantity checking start -->
                                                    </div><!-- ./item -->
                                                    
                                                    <div class="item">
                                                        <div class="etn-subtotal" data-subtotal="<?php esc_attr_e($value['etn_ticket_price']);?>">
                                                            <label><?php echo esc_html__("Sub Total :","exhibz");?></label> 
                                                            <strong>
                                                                <?php 
                                                                    if(function_exists("get_woocommerce_currency_symbol")){
                                                                    echo esc_html(get_woocommerce_currency_symbol( )); 
                                                                    } 
                                                                ?>
                                                                <span class="_sub_total_<?php echo absint( $key ); ?>">0</span>
                                                            </strong>
                                                        </div>
                                                    </div><!-- ./item -->
                                                    <div class="item">
                                                        <?php 
                                                        if($etn_current_stock > 0){
                                                            if($etn_ticket_availability == 'on'){
                                                            ?>
                                                            <span class="seat-remaining-text">(<?php echo $etn_current_stock; echo esc_html__(' seats remaining', 'eventin'); ?>)</span>
                                                            <?php }else {?>
                                                                <span class="seat-remaining-text">(<?php echo esc_html__(' Unlimited tickets', 'eventin'); ?>)</span>
                                                            <?php } ?>
                                                        <?php }else{ ?>
                                                            <span class="seat-remaining-text">(<?php echo esc_html__('All tickets have been sold out', 'eventin'); ?>)</span>
                                                        <?php } ?>
                                                    </div><!-- ./item -->
                                                    <input name="ticket_price[]" type="hidden" value="<?php echo floatval($value['etn_ticket_price']);?>"/>
                                                    <input name="ticket_name[]" type="hidden" value="<?php esc_html_e($value['etn_ticket_name']);?>"/>
                                                    <input name="ticket_slug[]" type="hidden" value="<?php esc_html_e($value['etn_ticket_slug']);?>"/>
                                                </div><!-- ./col -->
                                                <div class="col-md-3">
                                                    <!-- price_btn -->
                                                    <?php do_action( 'etn_before_add_to_cart_button', $single_event_id); ?>
                                                        <?php
                                                            $show_form_button = apply_filters("etn_form_submit_visibility", true, $single_event_id);

                                                            if ($show_form_button === false) {
                                                                ?>
                                                                <small><?php echo esc_html__('Event already expired!', "exhibz"); ?></small>
                                                                <?php
                                                            } else {
                                                                if (!isset($event_options["etn_purchase_login_required"]) || (isset($event_options["etn_purchase_login_required"]) && is_user_logged_in())) {
                                                                    ?>
                                                                <button name="submit" class="exhibz-btn whitespace--normal" type="submit">
                                                                        <span class="exhibz-button-text">
                                                                            <?php echo esc_html__("Grab", 'exhibz');?> 
                                                                            <span><?php echo esc_html__("Ticket", 'exhibz');?></span>
                                                                        </span>
                                                                        <i class="icon icon-double-angle-pointing-to-right"></i>
                                                                    </button>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <small>
                                                                    <?php echo esc_html__('Please', 'eventin'); ?> <a href="<?php echo wp_login_url( get_permalink( ) ); ?>"><?php echo esc_html__( "Login", "exhibz" ); ?></a> <?php echo esc_html__(' to buy ticket!', "exhibz"); ?>
                                                                    </small>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                        <?php do_action( 'etn_after_add_to_cart_button', $single_event_id); ?>
                                                        <!-- price_btn -->
                                                    
                                                </div> <!-- ./col -->
                                                
                                                <div class="show_message show_message_<?php echo intval($key);?> quantity-error-msg"></div>

                                            </div>
                                        </div>
                                        <?php do_action( 'etn_before_add_to_cart_total_price', $single_event_id, $key, $value ); ?>
                                        <?php 
                                    } 
                                    ?>

                                    
                                </div>
                                <?php 
                            } 
                            ?>
                            </form>
                            <?php

                        } else {
                            ?>
                            <h6><?php echo esc_html__('No Tickets Available!!', 'exhibz'); ?></h6>
                            <?php
                        }

                        // show if this is a zoom event
                        if( isset( $is_zoom_event ) && "on" == $is_zoom_event){
                        ?>
                            <div class="etn-zoom-event-notice">
                                <?php echo esc_html__("[Note: This event will be held on zoom. Attendee will get zoom meeting URL through email]", 'exhibz');?>
                            </div>
                            <?php
                        }
                        ?>
                </div>
                
           <?php 
            }
           ?>
        </div>
        <?php
    }
    protected function content_template(){}
}
