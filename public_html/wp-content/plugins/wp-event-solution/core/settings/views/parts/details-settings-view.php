                <!-- details Tab -->
                <div class="etn-settings-section attr-tab-pane" data-id="tab2" id="etn-details_options">

                    <div class="etn-settings-single-section">
                        <div class="etn-recaptcha-settings-wrapper">
                            <div class="etn-recaptcha-settings">
                         
                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Date', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide event date from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_date_from_details" type="checkbox" <?php echo esc_html($checked_hide_date_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_date_from_details" />
                                        <label for="checked_hide_date_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>
                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Time', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hid evente time from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_time_from_details" type="checkbox" <?php echo esc_html($checked_hide_time_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_time_from_details" />
                                        <label for="checked_hide_time_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>

                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Location', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide event location from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_location_from_details" type="checkbox" <?php echo esc_html($checked_hide_location_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_location_from_details" />
                                        <label for="checked_hide_location_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>

                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Total Seats', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide total seats from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_seats_from_details" type="checkbox" <?php echo esc_html($checked_hide_seats_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_seats_from_details" />
                                        <label for="checked_hide_seats_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>

                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Attendee Count', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide total attendee count from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_attendee_count_from_details" type="checkbox" <?php echo esc_html($checked_hide_attendee_count_from_details); ?> class="etn-admin-control-input" name="etn_hide_attendee_count_from_details" />
                                        <label for="checked_hide_attendee_count_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>


                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Organizers', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide organizers from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_organizers_from_details" type="checkbox" <?php echo esc_html($checked_hide_organizers_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_organizers_from_details" />
                                        <label for="checked_hide_organizers_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>

                                <div class="attr-form-group etn-label-item">
                                    <div class="etn-label">
                                        <label>
                                            <?php esc_html_e('Hide Event Schedule Details', 'eventin'); ?>
                                        </label>
                                        <div class="etn-desc"> <?php esc_html_e('Hide schedule details from event details.', 'eventin'); ?> </div>
                                    </div>
                                    <div class="etn-meta">
                                        <input id="checked_hide_schedule_from_details" type="checkbox" <?php echo esc_html($checked_hide_schedule_from_details); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_hide_schedule_from_details" />
                                        <label for="checked_hide_schedule_from_details" class="etn_switch_button_label"></label>
                                    </div>
                                </div>

                                <?php
                                    if( is_array( $settings_arr ) && isset( $settings_arr['pro_details_options'] ) && file_exists($settings_arr['pro_details_options'])){
                                        include_once $settings_arr['pro_details_options'];
                                    }
                                ?>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- ./End Description Tab -->