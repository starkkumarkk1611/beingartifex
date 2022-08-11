<?php

use Etn\Utils\Helper;

if ( $check && !empty( $post_arr["variation_picked_total_qty"] ) && !empty( $post_arr["event_id"] ) ) {

    $total_qty = 0;
    if ( isset( $post_arr["variation_picked_total_qty"] ) ) {
        $total_qty = absint( $post_arr["variation_picked_total_qty"] );
    }

    if( empty($total_qty) ){
        return;
    }

    $attendee_info_update_key = md5( md5( "etn-access-token" . time() . $total_qty ) );
    wp_head();

    ?>
 
    <div class="etn-es-events-page-container etn-attendee-registration-page">
        <div class="etn-event-single-wrap">
            <div class="etn-container">
                <div class="etn-attendee-form">
                    <h3 class="attendee-title"><?php echo esc_html__( "Attendee Details for ", "eventin" ) . esc_html( $post_arr["event_name"] ); ?></h3>
                    <form action="" method="post" id="etn-event-attendee-data-form" class="attende_form">
                        <?php wp_nonce_field( 'ticket_purchase_next_step_three', 'ticket_purchase_next_step_three' );?>
                        <input type="hidden" name="ticket_purchase_next_step" value="three" />

                        <!-- for compatibility with deposit plugin: check two variables are set in request. if set, deposit is running and pass them in reg form popup -->
                        <?php if ( ! empty( $deposit_enabled ) ) { ?>
                            <input type="hidden" name="wc_deposit_option" value="yes" />
                        <?php } ?>

                        <?php if ( ! empty( $deposit_payment_plan ) ) { ?>
                            <input type="hidden" name="wc_deposit_payment_plan" value="<?php echo esc_attr( $deposit_payment_plan ); ?>" />
                        <?php } ?>

                        <?php 
                            $add_to_cart_id = $post_arr["event_id"];
                            if ( isset( $post_arr["lang_event_id"] ) ) {
                                $add_to_cart_id = $post_arr["lang_event_id"];
                            }

                            $specific_lang = '';
                            if ( isset( $_GET['lang'] ) ) {
                                $specific_lang = $_GET["lang"];
                            }
                        ?>

                        <input type="hidden" name="event_name" value="<?php echo esc_html( $post_arr["event_name"] ); ?>" />
                        <input type="hidden" name="add-to-cart" value="<?php echo intval( $add_to_cart_id ); ?>" />
                        <input type="hidden" name="specific_lang" value="<?php echo esc_html( $specific_lang ); ?>" />
                        <input type="hidden" name="quantity" value="1" />
                        <input type="hidden" name="attendee_info_update_key" value="<?php echo esc_html( $attendee_info_update_key ); ?>" />
                        <input type="hidden" name="variation_picked_total_qty" value="<?php echo esc_attr( $total_qty ); ?>" />

                        <?php
                        if ( !empty( $post_arr["ticket_name"] ) &&  count( $post_arr["ticket_name"] ) > 0 ) {
                            foreach ( $post_arr["ticket_name"] as $key => $ticket_name ) {
                                ?>
                                <div class="etn-ticket-single-variation-details">
                                    <div class="etn-ticket-single-variation-title">
                                        <h3><?php echo esc_html( $ticket_name );?></h3>
                                    </div>
                                    <?php
                                    $ticket_quantity = !empty( $post_arr["ticket_quantity"] ) ? $post_arr["ticket_quantity"] : [];
                                    
                                    if ( !empty( $post_arr["ticket_quantity"] )  && count( $post_arr["ticket_quantity"] ) >0 ) {
                                    
                                        $variation_qty = (int) $post_arr["ticket_quantity"][$key];
                                        for ( $i = 1; $i <= $variation_qty; $i++ ) {
                                            
                                            if ( isset( $attendees_ticket_names[ $i ] ) ) {
                                                echo '<h3>' . esc_html__( 'Ticket name: ', 'eventin' ) . $attendees_ticket_names[ $i ] . '</h3>';
                                            }
                                            ?>
                                            <div class="etn-attendee-form-wrap">
                                                <div class="etn-attendy-count">
                                                    <h4><?php echo esc_html__( "Attendee - ", "eventin" ) . $i; ?></h4>
                                                </div>
                                                <div class="etn-name-field etn-group-field">
                                                    <label for="attendee_name_<?php echo intval( $i ) ?>">
                                                        <?php echo esc_html__( 'Name', "eventin" ); ?> <span class="etn-input-field-required">*</span>
                                                    </label>
                                                    <input required placeholder="<?php echo esc_html__('Enter attendee full name', 'eventin'); ?>" class="attr-form-control" id="attendee_name_<?php echo intval( $i ) ?>" name="attendee_name[]"  type="text"/>
                                                    <input type="hidden" name="ticket_index[]" value="<?php esc_attr_e( $key ); ?>" />
                                                    <div class="etn-error attendee_name_<?php echo intval( $i ) ?>"></div>
                                                </div>
                                                <?php
                
                                                if ( $include_email ) {
                                                    ?>
                                                    <div class="etn-email-field etn-group-field">
                                                        <label for="attendee_email_<?php echo intval( $i ) ?>">
                                                            <?php echo esc_html__( 'Email', "eventin" ); ?><span class="etn-input-field-required"> *</span>
                                                        </label>
                                                        <input required placeholder="<?php echo esc_html__('Enter email address', 'eventin'); ?>" class="attr-form-control" id="attendee_email_<?php echo intval( $i ) ?>" name="attendee_email[]" type="email"/>
                                                        <div class="etn-error attendee_email_<?php echo intval( $i ) ?>"></div>
                                                    </div>
                                                    <?php
                                                }
                
                                                if ( $include_phone ) {
                                                    ?>
                                                    <div class="etn-phone-field etn-group-field">
                                                        <label for="attendee_phone_<?php echo intval( $i ) ?>">
                                                            <?php echo esc_html__( 'Phone', "eventin" ); ?><span class="etn-input-field-required"> *</span>
                                                        </label>
                                                        <input required placeholder="<?php echo esc_html__('Enter phone number', 'eventin'); ?>" class="attr-form-control" maxlength="15" id="attendee_phone_<?php echo intval( $i ) ?>" name="attendee_phone[]" type="tel"/>
                                                        <div class="etn-error attendee_phone_<?php echo intval( $i ) ?>"></div>
                                                    </div>
                                                    <?php
                                                }
                
                                                $attendee_extra_fields = isset($settings['attendee_extra_fields']) ? $settings['attendee_extra_fields'] : [];
                
                                                if ( is_array($attendee_extra_fields) && !empty($attendee_extra_fields) ){
                                                    foreach( $attendee_extra_fields as $index => $attendee_extra_field ){
                                                        
                                                        $label_content = $attendee_extra_field['label'];
                                                        if( !empty($label_content) && !empty($attendee_extra_field['type']) ){ 
                                                            $name_from_label       = \Etn\Utils\Helper::generate_name_from_label( "etn_attendee_extra_field_" , $label_content); 
                                                            $class_name_from_label = \Etn\Utils\Helper::get_name_structure_from_label($label_content);
                                                            ?>
                
                                                            <div class="etn-<?php echo esc_attr( $class_name_from_label ); ?>-field etn-group-field">
                                                                <label for="etn_attendee_extra_field_<?php echo esc_attr( $index ) . "_attendee_" . intval( $i ) ?>">
                                                                    <?php echo esc_html( $label_content ); ?><span class="etn-input-field-required"> *</span>
                                                                </label>
                                                                
                                                                <?php
                                                                    if( $attendee_extra_field['type'] == 'radio' ){
                                                                        $radio_arr = isset( $attendee_extra_field['radio'] ) ? $attendee_extra_field['radio'] : [];
                                                                        
                                                                        if( is_array($radio_arr) && !empty($radio_arr) ){
                                                                            ?>
                                                                            <div class="etn-radio-field-wrap">
                                                                            <?php
                                                                            foreach( $radio_arr as $radio_index => $radio_val ){
                                                                                ?>
                                                                                <div class="etn-radio-field">
                                                                                    <input type="radio" name="<?php echo esc_attr( $name_from_label ) . '_' . ( $i-1 ); ?>[]" value="<?php echo esc_attr( $radio_index ); ?>"
                                                                                        class="etn-attendee-extra-fields" id="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_attendee_<?php echo intval( $i ); ?>_radio_<?php echo esc_attr( $radio_index ); ?>" required/>
                                                                                    <label for="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_attendee_<?php echo intval( $i ); ?>_radio_<?php echo esc_attr( $radio_index ); ?>"><?php echo esc_html( $radio_val ); ?></label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <div class="etn-error <?php echo esc_attr( $name_from_label ); ?>"></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else if( $attendee_extra_field['type'] == 'checkbox' ){
                                                                        $checkbox_arr = isset( $attendee_extra_field['checkbox'] ) ? $attendee_extra_field['checkbox'] : [];
                                                                        
                                                                        if( is_array($checkbox_arr) && !empty($checkbox_arr) ){
                                                                            ?>
                                                                            <div class="etn-checkbox-field-wrap">
                                                                            <?php
                                                                                foreach( $checkbox_arr as $checkbox_index => $checkbox_val ){
                                                                                    ?>
                                                                                        <div class="etn-checkbox-field">
                                                                                            <input type="checkbox" name="<?php echo esc_attr( $name_from_label ) . '_' . ( $i-1 ); ?>[]" value="<?php echo esc_attr( $checkbox_index ); ?>"
                                                                                                class="etn-attendee-extra-fields" id="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_attendee_<?php echo intval( $i ); ?>_checkbox_<?php echo esc_attr( $checkbox_index ); ?>" />
                                                                                            <label for="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_attendee_<?php echo intval( $i ); ?>_checkbox_<?php echo esc_attr( $checkbox_index ); ?>"><?php echo esc_html( $checkbox_val ); ?></label>
                                                                                        </div>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else { 
                                                                        ?>
                                                                        <input type="<?php echo esc_html( $attendee_extra_field['type'] ); ?>" 
                                                                            name="<?php echo esc_attr( $name_from_label ); ?>[]"
                                                                            class="attr-form-control etn-attendee-extra-fields" 
                                                                            id="etn_attendee_extra_field_<?php echo esc_attr( $index ) . "_attendee_" . intval( $i ) ?>" 
                                                                            placeholder="<?php echo esc_attr( $attendee_extra_field['place_holder'] ); ?>" 
                                                                            <?php echo ($attendee_extra_field['type'] == 'number') ? "pattern='\d+'" : '' ?> required /> 
                                                                        <?php
                                                                    }
                                                                ?>
                                                                
                                                                <div class="etn-error etn_attendee_extra_field_<?php echo esc_attr( $index ) . "_attendee_" . intval( $i ) ?>"></div>
                                                            </div>
                                                            <?php
                                                            } else { ?>
                                                                <p class="error-text"><?php echo esc_html__( 'Please Select input type & label name from admin', 'eventin' ); ?></p>
                                                            <?php 
                                                        } 
                
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <input type="hidden" name="ticket_quantity[]" value="<?php echo absint( $post_arr["ticket_quantity"][$key] ); ?>" />
                                    <input type="hidden" name="ticket_price[]" value="<?php echo Helper::render($post_arr["ticket_price"][$key]); ?>" />
                                    <input type="hidden" name="ticket_name[]" value="<?php echo esc_html( $ticket_name ); ?>" />
                                    <input type="hidden" name="ticket_slug[]" value="<?php echo esc_html( $post_arr["ticket_slug"][$key] ); ?>" />
                                </div>
                                <?php
                            }
                        }

                        ?>
                        <input type="submit" name="submit" class="etn-btn etn-primary attendee_sumbit" value="<?php echo esc_html__( "Confirm", "eventin" ); ?>" />
                        <a href="<?php echo get_permalink(); ?>" class="etn-btn etn-btn-secondary"><?php echo esc_html__( "Go Back", "eventin" ); ?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
    wp_footer();
    exit;
} else {
    wp_redirect( get_permalink() );
}

return;

