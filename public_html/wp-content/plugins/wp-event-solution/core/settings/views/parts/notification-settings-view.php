
<!-- Attendee data tab -->
<div class="attr-tab-pane etn-settings-section" data-id="tab3" id="etn-notification_data">

    <?php do_action( 'etn_before_notification_settings' ); ?>
    
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label class="etn-setting-label" for="admin_mail_address"><?php esc_html_e('Admin Email Address', 'eventin'); ?></label>
            <div class="etn-desc"> <?php esc_html_e('Email will be sent to users from this mail address', 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
        <input type="text" name="admin_mail_address"
            value="<?php echo esc_attr( isset($settings['admin_mail_address'] ) && $settings['admin_mail_address'] !== '' ? $settings['admin_mail_address'] : wp_get_current_user()->data->user_email ); ?>"
            class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Admin Email Address', 'eventin'); ?>">
        </div>
    </div>

    <?php do_action( 'etn_after_notification_settings' ); ?>
</div>
<!-- End Attendee data tab -->