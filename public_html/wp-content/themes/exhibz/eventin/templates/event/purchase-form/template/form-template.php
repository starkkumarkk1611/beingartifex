<div class="etn-form-wrap">
    <form action="" method="post" class="etn-event-form-parent">
        <?php
        if( $attendee_reg_enable ){
            ?>
                <?php wp_nonce_field('ticket_purchase_next_step_two','ticket_purchase_next_step_two'); ?>
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
        <div class="etn-row etn-item-row">
            <div class="col-item etn-qty-field etn-col-lg-3">
                <label for="etn_product_qty">
                    <?php echo esc_html__('Quantity', 'exhibz'); ?>
                </label>
               <input id="etn_product_qty" class="attr-form-control etn-event-form-qty etn_product_qty" name="quantity" type="number" value="<?php echo esc_attr( $min_purchase_qty ); ?>" min="<?php echo esc_attr( $min_purchase_qty ); ?>" max="<?php echo esc_attr( $max_purchase_qty ); ?>" data-min_purchase_qty='<?php echo esc_attr( $min_purchase_qty ); ?>' data-max_purchase_qty='<?php echo esc_attr( $max_purchase_qty ); ?>' data-left_ticket="<?php echo esc_html($etn_left_tickets); ?>" />
            </div>
            <div class="etn-price-field etn-col-lg-3">
                <label for="etn_product_price">
                    <?php echo isset($event_options["etn_price_label"]) && ( "" != $event_options["etn_price_label"]) ? esc_html($event_options["etn_price_label"]) : esc_html__('Price', 'exhibz'); ?>
                </label>
                <input id="etn_product_price" class="attr-form-control etn-event-form-price etn_product_price" readonly
                    name="price" type="number" value="<?php echo esc_attr($etn_ticket_price); ?>" min="1" />
            </div>
            <div class="col-item etn-col-lg-3">
                <div class="etn-total-price">
                    <?php echo esc_html__('Total price', 'exhibz'); ?>
                    <?php 
                        if(function_exists("get_woocommerce_currency_symbol")){
                            echo esc_html(get_woocommerce_currency_symbol()); 
                        }
                    ?>
                    <span id="etn_form_price" class="etn_form_price">
                        <?php echo esc_html($etn_ticket_price); ?>
                    </span>
                </div>
                <?php do_action( 'etn_before_add_to_cart_button'); ?>
                <?php                   $show_form_button = apply_filters("etn_form_submit_visibility", true, $single_event_id);

                    if ($show_form_button === false) {
                        ?>
                <small><?php echo esc_html__('Event already expired!', 'exhibz'); ?></small>
                <?php                   } else {
                        if (!isset($event_options["etn_purchase_login_required"]) || (isset($event_options["etn_purchase_login_required"]) && is_user_logged_in())) {
                            ?>
                <input name="submit" class="xx etn-btn etn-primary etn-add-to-cart-block" type="submit"
                    value="<?php echo esc_html__("Buy ticket", 'exhibz');?>" />
                <?php                       } else {
                            ?>
                <small>
                    <?php echo esc_html__('Please', 'exhibz'); ?> <a
                        href="<?php echo wp_login_url( get_permalink( ) ); ?>"><?php echo esc_html__( "Login", 'exhibz' ); ?></a>
                    <?php echo esc_html__(' to buy ticket!', 'exhibz'); ?>
                </small>
                <?php                       }
                    }
                    ?>

                
            </div>
            <div class="col-item etn-col-lg-3">
                <div class="etn-single-page-ticket-count-text-holder">
                    <?php                       if ( !isset($event_options["etn_hide_seats_from_details"]) ) {
                    ?>
                    <div class="etn-form-ticket-text">
                        <?php                   if( $etn_ticket_unlimited ){
                        echo esc_html__( "This event offers unlimited tickets", 'exhibz' );
                    }else {
                        echo esc_html($etn_left_tickets) . esc_html__(' seats remaining', 'exhibz');
                    }
                    ?>
                    </div>
                    <?php                   } 
                    if( !isset($event_options["etn_hide_attendee_count_from_details"]) ){
                    ?>
                    <div class="etn-form-ticket-text">
                        <?php echo esc_html( $total_sold_ticket ) . esc_html__(" attendees so far.", 'exhibz'); ?>
                    </div>
                    <?php                   }
                ?>
                </div>
            </div>
        </div>


        <?php do_action( 'etn_after_add_to_cart_button'); ?>
    </form>
</div>
