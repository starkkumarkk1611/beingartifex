<?php

use Etn\Utils\Helper;

$get_arr = filter_input_array( INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

if( empty( $get_arr["attendee_id"] ) || empty( $get_arr["etn_info_edit_token"] ) ){
    Helper::show_attendee_pdf_invalid_data_page();
    exit;
}

if( !Helper::verify_attendee_edit_token( $get_arr["attendee_id"], $get_arr["etn_info_edit_token"] ) ){
    Helper::show_attendee_pdf_invalid_data_page();
    exit;
}

    $user_id            = is_numeric( $get_arr["attendee_id"] ) ? $get_arr["attendee_id"] : 0;
    $access_token       = $get_arr['etn_info_edit_token'];
    $attendee_data      = Helper::get_attendee_by_token( 'etn_info_edit_token', $access_token  );
    $attendee_name      = get_the_title( $user_id );
    $attendee_email     = get_post_meta( $user_id, "etn_email", true );
    $attendee_phone     = get_post_meta( $user_id, "etn_phone", true );
    $base_url           = home_url( );
    $attendee_cpt       = new \Etn\Core\Attendee\Cpt();
    $attendee_endpoint  = $attendee_cpt->get_name();
    $action_url         = $base_url . "/" . $attendee_endpoint;
    wp_head(  );
    ?>

    <div class="etn-es-events-page-container">
        <div class="etn-event-single-wrap">
            <div class="etn-container">
                <div class="etn-attendee-form">
                    <h3 class="attendee-title"><?php echo esc_html__( "Update Attendee Details", "eventin" ); ?></h3>
                    <hr>
                    <form action="<?php echo esc_url( $action_url );?>" method="post" class="attende_form">
                        <div class="etn-attendee-form-wrap">
                            <div class="etn-name-field etn-group-field">
                                <label for="attendee_name">
                                    <?php echo esc_html__( 'Name', "eventin" ); ?>
                                    <span class="etn-input-field-required"> *</span>
                                </label>
                                <input placeholder="<?php echo esc_html__( 'Enter attendee full name', 'eventin' ); ?>" class="attr-form-control" id="attendee_name" name="name" type="text" value="<?php echo esc_html( $attendee_name ); ?>" required/>
                                <div class="etn-error attendee_name"></div>   
                            </div>
                            <?php 
                            if( $include_email ){
                                ?>
                                <div class="etn-email-field etn-group-field">
                                    <label for="attendee_email">
                                        <?php echo esc_html__( 'Email', "eventin" ); ?>
                                        <span class="etn-input-field-required"> *</span>
                                    </label>
                                    <input placeholder="<?php echo esc_html__( 'Enter email address', 'eventin' ); ?>"  class="attr-form-control"  id="attendee_email" name="email" type="email" value="<?php echo esc_html( $attendee_email ); ?>" required/>
                                    <div class="etn-error attendee_email"></div>   
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if( $include_phone ) {
                                ?>
                                <div class="etn-phone-field etn-group-field">
                                    <label for="attendee_phone">
                                        <?php echo esc_html__( 'Phone', "eventin" ); ?>
                                        <span class="etn-input-field-required"> *</span>
                                    </label>
                                    <input placeholder="<?php echo esc_html__( 'Enter phone number', 'eventin' ); ?>"  class="attr-form-control" id="attendee_phone" name="phone" type="tel" value="<?php echo esc_html( $attendee_phone ); ?>" required/>
                                    <div class="etn-error attendee_phone"></div>   
                                </div>
                                <?php
                            }

                            $settings              = Helper::get_settings();
                            $attendee_extra_fields = isset($settings['attendee_extra_fields']) ? $settings['attendee_extra_fields'] : [];

                            if( is_array( $attendee_extra_fields ) && !empty( $attendee_extra_fields ) ) {
                                foreach( $attendee_extra_fields as $index => $attendee_extra_field ){
                                            
                                    $label_content = $attendee_extra_field['label'];
                                    if( !empty($label_content) && !empty($attendee_extra_field['type']) ){ 
                                        $name_from_label         = \Etn\Utils\Helper::generate_name_from_label( "etn_attendee_extra_field_", $label_content ); 
                                        $extra_field_saved_value = get_post_meta( $user_id, $name_from_label, true );                                         
                                        $class_name_from_label   = \Etn\Utils\Helper::get_name_structure_from_label($label_content);
                                        ?>

                                        <div class="etn-<?php echo esc_attr( $class_name_from_label ); ?>-field etn-group-field">
                                            <label for="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>">
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
                                                                        <input type="radio" name="<?php echo esc_attr( $name_from_label ); ?>" value="<?php echo esc_attr( $radio_index ); ?>"
                                                                            class="attr-form-control1 etn-attendee-extra-fields1" 
                                                                            id="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_radio_<?php echo esc_attr( $radio_index ); ?>" 
                                                                            <?php checked( $extra_field_saved_value, $radio_index, true ) ?> required />
                                                                        <label for="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>_radio_<?php echo esc_attr( $radio_index ); ?>"><?php echo esc_html( $radio_val ); ?></label>
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
                                                        name="<?php echo esc_attr( $name_from_label ); ?>" 
                                                        value="<?php echo esc_attr( $extra_field_saved_value ); ?>" 
                                                        class="attr-form-control etn-attendee-extra-fields" 
                                                        id="etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>" 
                                                        placeholder="<?php echo esc_attr( $attendee_extra_field['place_holder'] ); ?>" 
                                                        <?php echo ($attendee_extra_field['type'] == 'number') ? "pattern='\d+'" : '' ?> required />
                                                    <?php
                                                }
                                            ?>
                                            <div class="etn-error etn_attendee_extra_field_<?php echo esc_attr( $index ); ?>"></div>
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

                        <?php wp_nonce_field( 'attendee_details_nonce', 'attendee_personal_data' );?>
                        <input type="hidden" name="etn_attendee_details_update_action" value="etn_attendee_details_update_action" required/>
                        <input type="hidden" name="etn_attendee_id" value="<?php echo esc_html( $user_id ); ?>" required/>
                        <input type="hidden" name="etn_info_edit_token" value="<?php echo esc_html( $access_token ); ?>" required/>
                        <input type="submit" name="submit" class="etn-btn etn-primary attendee_update_sumbit" value="<?php echo esc_html__( "Update", "eventin" ); ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    wp_footer(  );
exit;