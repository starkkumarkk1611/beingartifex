<?php

use Etn\Utils\Helper;

defined('ABSPATH') || exit;

$settings =  \Etn\Core\Settings\Settings::instance()->get_settings_option();

//pick a sample date to show on dropdown options
$sample_date = strtotime( date('d') . " " . date('M') . " " .  date('Y') );
$date_formats = Helper::get_date_formats();
$sell_tickets                           =  (isset($settings['sell_tickets']) ? 'checked' : '');
$checked_exclude_from_search            =  isset( $settings['etn_include_from_search'] ) ? $settings['etn_include_from_search'] : 'on';
$checked_purchase_login_required        =  (isset($settings['etn_purchase_login_required']) ? 'checked' : '');
$attendee_registration                  =  (isset($settings['attendee_registration']) ? 'checked' : '');
$reg_require_phone                      =  (isset($settings['reg_require_phone']) ? 'checked' : '');
$reg_require_email                      =  (isset($settings['reg_require_email']) ? 'checked' : '');
$disable_ticket_email                   =  (isset($settings['disable_ticket_email']) ? 'checked' : '');
$checked_hide_date_from_details         =  (isset($settings['etn_hide_date_from_details']) ? 'checked' : '');
$checked_hide_time_from_details         =  (isset($settings['etn_hide_time_from_details']) ? 'checked' : '');
// $checked_expired_event                  =  (isset($settings['checked_expired_event']) ? 'checked' : '');
$checked_hide_location_from_details     =  (isset($settings['etn_hide_location_from_details']) ? 'checked' : '');
$checked_hide_seats_from_details        =  (isset($settings['etn_hide_seats_from_details']) ? 'checked' : '');
$checked_hide_attendee_count_from_details= (isset($settings['etn_hide_attendee_count_from_details']) ? 'checked' : '');
$checked_hide_organizers_from_details   =  (isset($settings['etn_hide_organizers_from_details']) ? 'checked' : '');
$checked_hide_schedule_from_details     =  (isset($settings['etn_hide_schedule_from_details']) ? 'checked' : '');
$checked_hide_address_from_details      =  (isset($settings['etn_hide_address_from_details']) ? 'checked' : '');
$selected_date_format                   =  isset( $settings['date_format'] ) ? $settings['date_format'] : "";
$selected_time_format                   =  !empty( $settings['time_format'] ) ? $settings['time_format'] : "";
$attendee_remove                        =  (isset($settings['attendee_remove']) ? $settings['attendee_remove'] : '');
$event_slug                             =  (isset($settings['event_slug']) ? $settings['event_slug'] : '');
$speaker_slug                           =  (isset($settings['speaker_slug']) ? $settings['speaker_slug'] : '');
$etn_price_label                        =  (isset($settings['etn_price_label']) ? $settings['etn_price_label'] : '');
$etn_zoom_api                           =  (isset($settings['etn_zoom_api']) ? 'checked' : '');
$zoom_api_key                           =  (isset($settings['zoom_api_key']) ? $settings['zoom_api_key'] : '');
$zoom_secret_key                        =  (isset($settings['zoom_secret_key']) ? $settings['zoom_secret_key'] : '');
$zoom_class                             =  ( $etn_zoom_api == 'checked' ) ?  'zoom_section' : 'zoom_section_hide';
$settings_arr                           =  apply_filters( 'eventin/settings/pro_settings', [] );
$is_registration_disabled_if_expired    =  isset( $settings['disable_registration_if_expired'] ) ? 'checked' : '';
$remainder_email_sending_day            =  isset( $settings['remainder_email_sending_day'] ) ? $settings['remainder_email_sending_day'] : '';
$selected_speaker_template              =  isset( $settings['speaker_template'] ) ? $settings['speaker_template'] : "";
$selected_event_template                =  isset( $settings['event_template'] ) ? $settings['event_template'] : "";
$selected_expiry_point                  =  isset( $settings['expiry_point'] ) ? $settings['expiry_point'] : "";
$events_per_page                        =  isset( $settings['events_per_page'] ) ? $settings['events_per_page'] : 10;
$selected_add_to_cart_redirect          =  isset( $settings['add_to_cart_redirect'] ) ? $settings['add_to_cart_redirect'] : "event";
$event_template_array                   =  apply_filters('etn_event_templates', [
    'event-one' => esc_html__( 'Template One', 'eventin' ),
]);
$speaker_template_array                   = apply_filters('etn_speaker_templates', [
    'speaker-one' => esc_html__( 'Template One Free', 'eventin' ),
    'speaker-two-lite' => esc_html__( 'Template Two Free ', 'eventin' ),
]);
$redirect_after_cart_array  = [
    'event'     => esc_html__( 'Event', 'eventin' ),
    'cart'      => esc_html__( 'Cart', 'eventin' ),
    'checkout'  => esc_html__( 'Checkout', 'eventin' ),
];

$settings_tabs = [
    "etn-general_options" => [
        "class"         => "nav-tab",
        "icon_class"    => "eventin-general_icon",
        "data_id"       => "tab1",
        "title"         => esc_html__('General', 'eventin'),
        "content"       => \Wpeventin::plugin_dir() . "core/settings/views/parts/general-settings-view.php"
    ],
    "etn-details_options" => [
        "class"         => "nav-tab",
        "icon_class"    => "eventin-details_icon",
        "data_id"       => "tab2",
        "title"         => esc_html__('Details', 'eventin'),
        "content"       => \Wpeventin::plugin_dir() . "core/settings/views/parts/details-settings-view.php"
    ],
    "etn-notification_data" => [
        "class"         => "nav-tab",
        "icon_class"    => "eventin-notification_icon",
        "data_id"       => "tab3",
        "title"         => esc_html__('Notification', 'eventin'),
        "content"       => \Wpeventin::plugin_dir() . "core/settings/views/parts/notification-settings-view.php"
    ],
    "etn-attendee_data" => [
        "class"         => "etnshortcode-nav nav-tab",
        "icon_class"    => "eventin-user_icon",
        "data_id"       => "tab4",
        "title"         => esc_html__('Attendee', 'eventin'),
        "content"       => \Wpeventin::plugin_dir() . "core/settings/views/parts/attendee-settings-view.php"
    ],
    "etn-user_data" => [
        "class"         => "etnshortcode-nav nav-tab",
        "icon_class"    => "eventin-user_icon",
        "data_id"       => "tab5",
        "title"         => esc_html__('Integrations', 'eventin'),
        "content"       => \Wpeventin::plugin_dir() . "core/settings/views/parts/zoom-settings-view.php"
    ],
];
?>
<div class="wrap  etn-settings-dashboard">
    <h2 class="etn-main-title"> <i class="eventin-general_icon"></i> <?php esc_html_e('Eventin Settings', 'eventin'); ?></h2>
    <div class="etn-settings-tab">
        <ul class="nav-tab-wrapper etn-tab">
            <?php
            $settings_tabs = apply_filters("eventin/settings/tab_titles", $settings_tabs);
            foreach( $settings_tabs as $tab_id => $tab_attrs ){
                ?>
                <li>
                    <a href="#<?php echo esc_attr( $tab_id ); ?>" class="<?php echo esc_attr( $tab_attrs["class"] ); ?>" id="<?php echo esc_attr( $tab_id ); ?>" data-id="<?php echo esc_attr( $tab_attrs["data_id"] );?>"> <i class="<?php echo esc_attr( $tab_attrs["icon_class"] ); ?>"></i> <?php echo esc_html( $tab_attrs["title"] ); ?></a>
                </li>
                <?php
            }
            ?>
        </ul>

    </div>
    <div class="etn-admin-container stuffbox">
        <div class=" etn-admin-container--body">
            <form action="" method="post" class="attr-tab-content form-group etn-admin-input-text etn-settings-from ">
                <?php
                foreach( $settings_tabs as $tab_id => $tab_attrs ){
                    if( file_exists( $tab_attrs["content"] ) ){
                        include_once $tab_attrs["content"];
                    }
                }
                ?>
                <input type="hidden" name="etn_settings_page_action" value="save">
                <input type="submit" name="submit" id="submit" class="etn-btn etn-btn-secondary etn_save_settings" value="<?php esc_html_e('Save Changes', 'eventin'); ?>">

                <?php wp_nonce_field('etn-settings-page', 'etn-settings-page'); ?>
            </form>
        </div>
    </div>
</div>