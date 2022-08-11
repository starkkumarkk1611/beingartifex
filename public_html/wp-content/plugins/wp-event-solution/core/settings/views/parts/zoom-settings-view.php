
<!-- Zoom data tab -->
<div class="attr-tab-pane etn-settings-section" data-id="tab5" id="etn-user_data">
    <?php do_action( 'etn_before_integration_settings' ); ?>
    <div class="attr-form-group etn-label-item">
        <div class="etn-label">
            <label>
                <?php esc_html_e('Zoom', 'eventin'); ?>
            </label>
            <div class="etn-desc"> <?php esc_html_e('You will get all zoom options and shortcode to show meeting.', 'eventin'); ?> </div>
        </div>
        <div class="etn-meta">
            <input id="zoom_api" type="checkbox" <?php echo esc_html($etn_zoom_api); ?> class="etn-admin-control-input" name="etn_zoom_api" />
            <label for="zoom_api" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
        </div>
    </div>
    <div class="zoom_block  <?php echo esc_attr($zoom_class); ?> ">
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label class="etn-setting-label" for="zoom_api_key"><?php esc_html_e('Api key', 'eventin'); ?></label>
                <div class="etn-desc"> <?php esc_html_e('Place api key here that you get from zoom account', 'eventin'); ?> </div>
            </div>
            <div class="etn-meta">
                <div class="etn-secret-key">
                    <input type="password" class="etn-setting-input attr-form-control" name="zoom_api_key" value="<?php echo esc_attr($zoom_api_key); ?>" id="zoom_api_key" />
                    <span><i class="fa fa-eye-slash eye_toggle_click"></i></span>
                </div>
            </div>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label class="etn-setting-label" for="zoom_secret_key"><?php esc_html_e('Secret key', 'eventin'); ?></label>
                <div class="etn-desc"> <?php esc_html_e('Place api key here that you get from zoom account', 'eventin'); ?> </div>
            </div>
            <div class="etn-meta">
                <div class="etn-secret-key">
                    <input type="password" class="etn-setting-input attr-form-control" name="zoom_secret_key" value="<?php echo esc_attr($zoom_secret_key); ?>" id="zoom_secret_key" />
                    <span><i class="fa fa-eye-slash eye_toggle_click"></i></span>
                </div>

                <div class="etn-api-connect-wrap">
                    <div class="mb-3 api-keys-msg"><?php echo esc_html__('Note:  Save changes before checking connection.', 'eventin') ?></div>
                    <div class="etn-desc"> <?php esc_html_e('Check the official documentation from', 'eventin'); ?><a href="<?php echo esc_url('//support.themewinter.com/docs/plugins/eventin/zoom-meeting-2/')?>" target="_blank"><?php esc_html_e(' here', 'eventin'); ?></a> </div>
                    <button type="button" class="etn-btn etn-btn-primary check_api_connection"><?php echo esc_html__('Check connection', 'eventin') ?></button>
                </div>
            </div>
        </div>

    </div>
    <?php do_action( 'etn_after_integration_settings' ); ?>
</div>
<!-- End Zoom Tab -->