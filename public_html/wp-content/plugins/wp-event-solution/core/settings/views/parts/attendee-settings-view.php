
<!-- Attendee data tab -->
<div class="attr-tab-pane etn-settings-section" data-id="tab4" id="etn-attendee_data">
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label for="attendee_registration"><?php esc_html_e('Enable Attendee Registration', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e("Enable attendee registration for unique tickets and attendee tracking.", 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id="attendee_registration" type="checkbox" <?php echo esc_html($attendee_registration); ?> class="etn-admin-control-input" name="attendee_registration" />
            <label for="attendee_registration" class="etn_switch_button_label"></label>
        </div>
    </div>
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label for="disable_ticket_email"><?php esc_html_e('Disable Ticket Email', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e("Disable sending separate email with unique attendee ticket PDF and attendee information update option.", 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id="disable_ticket_email" type="checkbox" <?php echo esc_html($disable_ticket_email); ?> class="etn-admin-control-input" name="disable_ticket_email" />
            <label for="disable_ticket_email" class="etn_switch_button_label"></label>
        </div>
    </div>
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label for="reg_require_phone"><?php esc_html_e('Require Phone for Registration', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e("Require attendee phone number for ticket purchase.", 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id="reg_require_phone" type="checkbox" <?php echo esc_html($reg_require_phone); ?> class="etn-admin-control-input" name="reg_require_phone" />
            <label for="reg_require_phone" class="etn_switch_button_label"></label>
        </div>
    </div>
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label for="reg_require_email"><?php esc_html_e('Require E-mail for Registration', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e("Require attendee e-mail number for ticket purchase.", 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id="reg_require_email" type="checkbox" <?php echo esc_html($reg_require_email); ?> class="etn-admin-control-input" name="reg_require_email" />
            <label for="reg_require_email" class="etn_switch_button_label"></label>
        </div>
    </div>
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label for="attendee_remove"><?php esc_html_e('Remove Attendees After Failed Payment', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e("Attendees with failed status will be removed from attendee list. Given number will be calculated in days.", 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id='attendee_remove' type="number" value="<?php echo ( $attendee_remove ) ? esc_html( $attendee_remove ): 30; ?>" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" name="attendee_remove"
            placeholder="<?php esc_html_e( 'no. of days' );?>" min="1"/>
        </div>
    </div>
    <?php 
        if( is_array( $settings_arr ) && isset( $settings_arr['pro_attendee_options'] ) && file_exists( $settings_arr['pro_attendee_options'] )){
            include_once $settings_arr['pro_attendee_options'];
        }
    ?>
</div>
<!-- End Attendee data tab -->