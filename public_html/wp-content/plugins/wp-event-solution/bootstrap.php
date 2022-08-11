<?php

namespace Etn;

use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

include_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Plugin final Class.
 * Handles dynamically loading classes only when needed. CheFck Elementor Plugin.
 *
 * @since 1.0.0
 */
final class Bootstrap {

    private static $instance;
    private $event;
    private $speaker;
    private $schedule;
    private $attendee;
    private $has_pro;

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct() {
        // load autoload method
        Autoloader::run();
    }

    /**
     * Public function name.
     * set for plugin name
     *
     * @since 1.0.0
     */
    public function name() {
        return __( "WP Event Solution", "eventin" );
    }

    /**
     * Public function init.
     * call function for all
     *
     * @since 1.0.0
     */
    public function init() {

        $this->prepare_roles_capabilities();

        $this->create_table();

        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        //handle woocommerce notice depending on settings
        $this->handle_woo_dependency();

        $this->has_pro = defined('ETN_PRO_FILES_LOADED');

        //handle buy-pro notice
        $this->handle_buy_pro_module();

        // Do all migrations
        Core\Migration\Migration::instance()->init();

        // check permission for manage user
        add_action( 'admin_menu', [$this, 'register_admin_menu'] );
        add_action( 'after_setup_theme', [$this, 'initialize_settings_dependent_cpt_modules'], 11 );

        //register all styles and scripts
        add_action( 'admin_enqueue_scripts', [$this, 'js_css_admin'] );
        add_action( 'wp_enqueue_scripts', [$this, 'js_css_public'] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );
        
        // archive search filter 
        add_filter( 'pre_get_posts', '\Etn\Utils\Helper::event_etn_search_filter', 999999 );
        add_action( 'wp_ajax_etn_event_ajax_get_data', '\Etn\Utils\Helper::etn_event_ajax_get_data' );
	    add_action( 'wp_ajax_nopriv_etn_event_ajax_get_data', '\Etn\Utils\Helper::etn_event_ajax_get_data' );
        
        // archive pagination filter
        add_filter( 'pre_get_posts', '\Etn\Utils\Helper::etn_event_archive_pagination_per_page' );
  
        
        // Initialize plugin settings module
        Core\Settings\Settings::instance()->init( $this->name(), \Wpeventin::version() );

        // Initialize woocommerce module
        Core\Woocommerce\Base::instance()->init();

        // initialize niche shortcode
        Core\Shortcodes\Hooks::instance()->init();

        // initialize elementor widget
        Widgets\Manifest::instance()->init();

        //make admin menu open if custom taxonomy is selected
        add_action( 'parent_file', [$this, 'keep_taxonomy_menu_open'] );

        // add minicart to header
        add_action('wp_head', [$this, 'etn_custom_inline_css']);

        // register gutenberg blocks
        if( file_exists( \Wpeventin::plugin_dir() . 'core/guten-block/inc/init.php' )){
            include_once \Wpeventin::plugin_dir() . 'core/guten-block/inc/init.php';
        } 
        
        if ( file_exists( \Wpeventin::plugin_dir() . 'core/woocommerce/etn-product-data-store-cpt.php' ) ) {
            include_once \Wpeventin::plugin_dir() . 'core/woocommerce/etn-product-data-store-cpt.php';
        }

        if ( file_exists( \Wpeventin::plugin_dir() . '/core/woocommerce/etn-order-item-product.php' ) ) {
            include_once \Wpeventin::plugin_dir() . '/core/woocommerce/etn-order-item-product.php';
        }

        // register wpml functions
        if( class_exists('SitePress') && function_exists('icl_object_id')  && file_exists( \Wpeventin::plugin_dir() . 'core/wpml/init.php' )){
            include_once \Wpeventin::plugin_dir() . 'core/wpml/init.php';
        } 

        // add_action( 'admin_menu', [ $this, 'change_attendee_submenu_position' ] );
    }
    
    /**
     * Initialize some cpt modules like attendee, zoom, schedules, speakers
     *
     * @return void
     */
    public function initialize_settings_dependent_cpt_modules() {
                      
        // Initialize event module
        Core\Event\Hooks::instance()->init();

        // Initialize attendee module
        Core\Attendee\Hooks::instance()->init();
        Core\Attendee\Attendee_List::instance()->init();

        // recurring event
        Core\Recurring_Event\Hooks::instance()->init();
        
        // initialize zoom module
        Core\Zoom_Meeting\Hooks::instance()->init();

        // Iinitialize event ticket registration module
        Core\Event\Registration::instance()->init();

        // Initialize attendee information-update module
        Core\Attendee\InfoUpdate::instance()->init();

        // Initialize schedule module
        Core\Schedule\Hooks::instance()->init();

        // Initialize speaker module
        Core\Speaker\Hooks::instance()->init();

    }

    /**
     * Handle woocommerce admin notice depending on settings
     *
     * @return void
     */
    public function handle_woo_dependency(){
        
        $eventin_global_settings = \Etn\Utils\Helper::get_settings();
        $sell_tickets            = !empty( $eventin_global_settings["sell_tickets"] ) ? true : false;

        if( $sell_tickets && !is_plugin_active( 'woocommerce/woocommerce.php' )){
            add_action( 'admin_head',[$this, 'admin_notice_wc_not_active'] );
            return;
        }
    }

    /**
     * Show buy-pro menu if pro plugin not active
     *
     * @return void
     */
    public function handle_buy_pro_module(){

        /**
        * Show banner (codename: jhanda)
        */
        $filter_string = 'eventin,eventin-free-only';
        
        if( $this->has_pro ) {
            
            $filter_string .= ',eventin-pro';
            $filter_string = str_replace(',eventin-free-only', '', $filter_string);

        }

        \Wpmet\Libs\Banner::instance('eventin')
        // ->is_test(true)
        ->set_filter( ltrim($filter_string, ',') )
        ->set_api_url('https://themefunction.com/public/jhanda')
        ->set_plugin_screens('edit-etn')
        ->set_plugin_screens('edit-etn-attendee')
        ->set_plugin_screens('edit-etn_category')
        ->set_plugin_screens('edit-etn_tags')
        ->set_plugin_screens('edit-etn-schedule')
        ->set_plugin_screens('edit-etn_speaker_category')
        ->set_plugin_screens('edit-etn-speaker')
        ->set_plugin_screens('eventin_page_etn-event-settings')
        ->set_plugin_screens('eventin_page_etn_sales_report')
        ->set_plugin_screens('edit-etn-zoom-meeting')
        ->set_plugin_screens('eventin_page_eventin_get_help')
        ->call();
        
        //show get-help and upgrade-to-premium menu
        $this->handle_get_help_and_upgrade_menu();
    }

    /**
     * Show menu for get-help
     * Show menu for upgrade-te-premium if pro version not active
     *
     * @return void
     */
    public function handle_get_help_and_upgrade_menu(){

        /**
         * Show go Premium menu
         */
        \Wpmet\Libs\Pro_Awareness::instance('eventin')
        ->set_parent_menu_slug('etn-events-manager')
        ->set_plugin_file('wp-event-solution/eventin.php')
        ->set_pro_link( $this->has_pro ? "" : 'https://themewinter.com/eventin/' )
        ->set_default_grid_thumbnail( \Wpeventin::plugin_url() . '/utils/pro-awareness/assets/support.png' )
        ->set_default_grid_link('https://themewinter.com/support/')
        ->set_default_grid_desc(esc_html__('Our experienced support team is ready to resolve your issues any time.', 'eventin'))
        ->set_page_grid([
            'url' => 'https://www.facebook.com/groups/themewinter',
                'title' => esc_html__('Join the Community', 'eventin'),
                'thumbnail' => \Wpeventin::plugin_url() . '/utils/pro-awareness/assets/community.png',
                'description' => esc_html__('Join our Facebook group to get 20% discount coupon on premium products. Follow us to get more exciting offers.', 'eventin'),
        ])
        ->set_page_grid([
            'url' => 'https://www.youtube.com/channel/UCfdo_ujAqztsz4QnjkrrPlw',
                'title' => esc_html__('Video Tutorials', 'eventin'),
                'thumbnail' => \Wpeventin::plugin_url() . '/utils/pro-awareness/assets/video_tutorial.png',
                'description' => esc_html__('Learn the step by step process for developing your site easily from video tutorials.', 'eventin'),
        ])
        ->set_page_grid([
            'url' => 'https://themewinter.com/eventin-roadmaps/#ideas',
                'title' => esc_html__('Feature Request', 'eventin'),
                'thumbnail' => \Wpeventin::plugin_url() . '/utils/pro-awareness/assets/feature_request.png',
                'description' => esc_html__('Have any special feature in mind? Let us know through the feature request.', 'eventin'),
        ])
        ->set_page_grid([
            'url' => 'https://support.themewinter.com/docs/plugins/docs-category/eventin/',
            'title' => esc_html__('Documentation', 'eventin'),
            'thumbnail' => \Wpeventin::plugin_url() . '/utils/pro-awareness/assets/documentation.png',
            'description' => esc_html__('Detailed documentation to help you understand the functionality of each feature.', 'eventin'),
        ])
        ->set_plugin_row_meta('Documentation','https://support.themewinter.com/docs/plugins/docs-category/eventin/', ['target'=>'_blank'])
        ->set_plugin_row_meta('Facebook Community','https://www.facebook.com/groups/themewinter', ['target'=>'_blank'])
        ->set_plugin_action_link('Settings', admin_url() . 'admin.php?page=etn-event-settings')
        ->set_plugin_action_link( ( $this->has_pro ? '' : 'Go Premium'),'https://themewinter.com/eventin/', ['target'=>'_blank', 'style' => 'color: #FCB214; font-weight: bold;'])
        ->set_plugin_row_meta('Rate the plugin ★★★★★', 'https://wordpress.org/support/plugin/wp-event-solution/reviews/#new-post', ['target' => '_blank'])
        ->call();
    }

        /**
     * Show notice if woocommerce not active
     */
    public function admin_notice_pro_not_active() {

        if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$btn = [
            'default_class' => 'button',
            'class' => 'button-primary '
        ];
        if ( file_exists( WP_PLUGIN_DIR . '/eventin-pro/eventin-pro.php' ) ) {
            $btn['text'] = esc_html__( 'Activate Eventin Pro', 'eventin' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=eventin-pro/eventin-pro.php&plugin_status=all&paged=1', 'activate-plugin_eventin-pro/eventin-pro.php' );
        } else {
            $btn['text'] = esc_html__( 'Buy Eventin Pro', 'eventin' );
            $btn['url']   = esc_url( $this->get_pro_link() );
        }

		\Oxaim\Libs\Notice::instance('eventin', 'buy-eventin-pro')
		->set_class( 'error' )
        ->set_dismiss( 'global', ( 3600 * 24 * 30 ) )
		->set_message( sprintf( esc_html__( 'Get Eventin Pro for more exciting features.', 'eventin' ) ) )
		->set_button( $btn )
		->call();
    }

    /**
     * Undocumented function
     *
     * @param [type] $parent_file
     * @return void
     */
    public function keep_taxonomy_menu_open( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        $eligible_taxonomies = ['etn_category', 'etn_tags', 'etn_speaker_category'];

        if ( in_array($taxonomy, $eligible_taxonomies ) ) {
            $parent_file = 'etn-events-manager';
        }

        return $parent_file;
    }

    /**
     * Show notice if woocommerce not active
     */
    public function admin_notice_wc_not_active() {

        if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$btn = [
            'default_class' => 'button',
            'class' => 'button-primary '
        ];
        if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
            $btn['text'] = esc_html__( 'Activate WooCommerce', 'eventin' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
        } else {
            $btn['text'] = esc_html__( 'Install WooCommerce', 'eventin' );
            $btn['url']   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
        }

		\Oxaim\Libs\Notice::instance('eventin', 'unsupported-woocommerce-version')
		->set_class('error')
        ->set_dismiss('global', (3600 * 24 * 30))
		->set_message(sprintf( esc_html__( 'Eventin requires WooCommerce to get all features, which is currently NOT RUNNING.', 'eventin' ) ) )
		->set_button($btn)
		->call();
    }

    /**
     * Public function package_type.
     * set for plugin package type
     *
     * @since 1.0.0
     */
    public function package_type() {
        return 'free';
    }
    
    public function text_domain() {
        return 'eventin';
    }

    /**
     * Public function js_css_public .
     * Include public function
     */
    public function js_css_public() {

        if ( is_rtl() ) {
            wp_enqueue_style( 'etn-rtl', \Wpeventin::assets_url() . 'css/rtl.css' );
        }

        wp_enqueue_style( 'fontawesome', \Wpeventin::assets_url() . 'css/font-awesome.css', [], '5.0', 'all' );
        wp_enqueue_style( 'etn-app-index', \Wpeventin::plugin_url() . 'build/index.css', [], \Wpeventin::version(), 'all' );
        wp_enqueue_style( 'etn-public-css', \Wpeventin::assets_url() . 'css/event-manager-public.css', [], \Wpeventin::version(), 'all' );

        wp_enqueue_script( 'etn-public', \Wpeventin::assets_url() . 'js/event-manager-public.js', ['jquery'], \Wpeventin::version(), true );
       
        wp_enqueue_script( 'etn-app-index', \Wpeventin::plugin_url() . 'build/index.js', ['jquery', 'wp-element'] , \Wpeventin::version(), true );

        // locallize data
        $translated_data                                = [];
        $translated_data['ajax_url']                    = admin_url( 'admin-ajax.php' );
        $translated_data['site_url']                    = site_url();
        $translated_data['locale_name']                 = strtolower(str_replace('_','-', get_locale()));
        $translated_data['start_of_week']               = get_option("start_of_week");
        $translated_data['expired']                     = esc_html__( "Expired", "eventin" );

        $attendee_form_validation_msg = [];

        $email_error_msg = [];
        $email_error_msg['invalid']   = esc_html__( "Email is not valid", "eventin" );
        $email_error_msg['empty']     = esc_html__( "Please fill the field", "eventin" );

        $tel_error_msg = [];
        $tel_error_msg['empty']       = esc_html__( "Please fill the field", "eventin" );
        $tel_error_msg['invalid']     = esc_html__( "Invalid phone number", "eventin" );
        $tel_error_msg['only_number'] = esc_html__( "Only number allowed", "eventin" );

        $attendee_form_validation_msg['email']           = $email_error_msg;
        $attendee_form_validation_msg['tel']             = $tel_error_msg;
        $attendee_form_validation_msg['text']            = esc_html__( "Please fill the field", "eventin" );
        $attendee_form_validation_msg['number']          = esc_html__( "Please input a number", "eventin" );
        $attendee_form_validation_msg['date']            = esc_html__( "Please fill the field", "eventin" );
        $attendee_form_validation_msg['radio']           = esc_html__( "Please check the field", "eventin" );
        $translated_data['attendee_form_validation_msg'] = $attendee_form_validation_msg;

        wp_localize_script( 'etn-public', 'localized_data_obj', $translated_data );

    }

    public function elementor_js() {

        wp_enqueue_script( 'etn-elementor-inputs', \Wpeventin::assets_url() . 'js/elementor.js', ['elementor-frontend'], \Wpeventin::version(), true );
    }

    public function js_css_admin() {

        // get screen id
        $screen    = get_current_screen();
        $screen_id = $screen->id;

        $allowed_screen_ids = [
            'post',
            'page',
            'etn',
            'edit-etn',
            'etn-attendee',
            'edit-etn-attendee',
            'edit-etn_category',
            'edit-etn_tags',
            'etn-schedule',
            'edit-etn-schedule',
            'edit-etn_speaker_category',
            'etn-speaker',
            'edit-etn-speaker',
            'etn-zoom-meeting',
            'edit-etn-zoom-meeting',
            'eventin_page_etn-event-settings',
            'eventin_page_etn_sales_report',
            'eventin_page_eventin_get_help',
            'eventin_page_etn-license',
            'eventin_page_etn-event-shortcode',
        ];

        if( in_array($screen_id, $allowed_screen_ids) ){

            $form_cpt = $this->event;

            if ( !wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
                wp_enqueue_style( 'wp-color-picker' );
            }

            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'select2', \Wpeventin::assets_url() . 'css/select2.min.css', [], '4.0.10', 'all' );
            
            wp_enqueue_style( 'fontawesome', \Wpeventin::assets_url() . 'css/font-awesome.css', [], '5.0', 'all' );
            wp_enqueue_style( 'etn-ui', \Wpeventin::assets_url() . 'css/etn-ui.css', [], \Wpeventin::version(), 'all' );
            wp_enqueue_style( 'etn-icon', \Wpeventin::assets_url() . 'css/etn-icon.css', [], \Wpeventin::version(), 'all' );
            wp_enqueue_style( 'jquery-ui', \Wpeventin::assets_url() . 'css/jquery-ui.css', ['wp-color-picker'], \Wpeventin::version(), 'all' );
            wp_enqueue_style( 'flatpickr-min', \Wpeventin::assets_url() . 'css/flatpickr.min.css', [], \Wpeventin::version(), 'all' );
            wp_enqueue_style( 'event-manager-admin', \Wpeventin::assets_url() . 'css/event-manager-admin.css', [], \Wpeventin::version(), 'all' );
            wp_enqueue_style( 'etn-common', \Wpeventin::assets_url() . 'css/event-manager-public.css', [], \Wpeventin::version(), 'all' );

            if ( !did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }

            // js
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
            wp_enqueue_script( 'jquery-ui-datepicker' );

            wp_enqueue_script( 'jquery-ui', \Wpeventin::assets_url() . 'js/etn-ui.min.js', ['jquery'], '4.0.10', true );
            // wp_enqueue_script( 'popper', \Wpeventin::assets_url() . 'js/Popper.js', ['jquery'], '4.0.10', false );
            wp_enqueue_script( 'etn', \Wpeventin::assets_url() . 'js/event-manager-admin.js', ['jquery'], \Wpeventin::version(), false );
            wp_enqueue_script( 'select2', \Wpeventin::assets_url() . 'js/select2.min.js', ['jquery'], '4.0.10', false );
            wp_enqueue_script( 'jquery-repeater', \Wpeventin::assets_url() . 'js/jquery.repeater.min.js', ['jquery'], '4.0.10', true );
            wp_enqueue_script( 'flatpickr', \Wpeventin::assets_url() . 'js/flatpickr.js', ['jquery'], \Wpeventin::version(), true );
            // locallize data
            $settings                                 = \Etn\Core\Settings\Settings::instance()->get_settings_option();
            $form_data                                = [];
            $form_data['ajax_url']                    = admin_url( 'admin-ajax.php' );
            $form_data['zoom_connection_check_nonce'] = wp_create_nonce( 'zoom_connection_check_nonce' );
            $form_data['zoom_module']                 = empty( $settings['etn_zoom_api'] ) ? "no" : "yes";
            $form_data['attendee_module']             = empty( $settings['attendee_registration'] ) ? "no" : "yes";
    
            wp_localize_script( 'etn', 'form_data', $form_data );
        }
    }

    function register_admin_menu() {

        if ( current_user_can( 'manage_etn_event' ) || current_user_can( 'manage_etn_speaker' ) || current_user_can( 'manage_etn_schedule' ) || current_user_can( 'manage_etn_attendee' ) || current_user_can( 'manage_etn_zoom' ) || current_user_can( 'manage_etn_settings' ) ) {
            add_menu_page(
                'Eventin',
                'Eventin',
                'read',
                'etn-events-manager',
                '',
                'dashicons-calendar',
                10
            );
        } 
    }

    public function flush_rewrites() {
        $event = new Core\Event\Cpt();
        $event->flush_rewrites();

        $speaker = new Core\Speaker\Cpt();
        $speaker->flush_rewrites();

        $schedule = new Core\Schedule\Cpt();
        $schedule->flush_rewrites();
        
        $attendee = new Core\Attendee\Cpt();
        $attendee->flush_rewrites();
    }

    public static function instance() {

        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Create plugin specific tables to store data
     *
     * @return void
     */
    public function create_table() {
        global $wpdb;
        $tableName       = ETN_EVENT_PURCHASE_HISTORY_TABLE;
        $charset_collate = $wpdb->get_charset_collate();
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // create table for events
        if ( $wpdb->get_var( "SHOW TABLES LIKE '$tableName'" ) != $tableName ) {

            // create table to store event purchase history
            // post_id is the event id
            // form_id is the woo order id
            // create events table
            $wdp_sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
			  `event_id` mediumint(9) NOT NULL AUTO_INCREMENT,
			  `post_id` bigint(20) NOT NULL COMMENT 'This id is teh event id',
			  `form_id` bigint(20) NOT NULL COMMENT 'This id From wp post table',
			  `invoice` varchar(150) NOT NULL,
			  `event_amount` double NOT NULL DEFAULT '0',
			  `user_id` mediumint(9) NOT NULL,
			  `email` varchar(200) NOT NULL,
			  `event_type` ENUM('ticket') DEFAULT 'ticket',
			  `payment_type` ENUM('woocommerce') DEFAULT 'woocommerce',
			  `pledge_id` varchar(20) NOT NULL DEFAULT '0',
			  `payment_gateway` ENUM('offline_payment', 'online_payment', 'bank_payment', 'check_payment', 'stripe_payment', 'other_payment') default 'online_payment',
			  `date_time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  `status` ENUM('Active','Review', 'DeActive', 'Failed', 'Processing', 'Pending', 'Hold', 'Refunded', 'Delete', 'Completed', 'Cancelled') DEFAULT 'Pending',
			  PRIMARY KEY (`event_id`)
			) $charset_collate;";
            dbDelta( $wdp_sql );

            // create meta table
            $tableNameMeta = ETN_EVENT_PURCHASE_HISTORY_META_TABLE;

            $wdp_meta = "
				CREATE TABLE IF NOT EXISTS `$tableNameMeta`(
					`meta_id` mediumint NOT NULL AUTO_INCREMENT,
					`event_id` mediumint NOT NULL,
					`meta_key` varchar(255),
					`meta_value` longtext,
					PRIMARY KEY(`meta_id`)
				) $charset_collate;
			";
            dbDelta( $wdp_meta );

            update_option( 'etn_version', \Wpeventin::version() );
        }
        

        //run table column migration for older version than 2.3.3 
        if( version_compare(get_option( 'etn_version'), '2.3.3', '<' )){

            $migration_query = "ALTER TABLE `$tableName` MODIFY COLUMN `status` ENUM('Failed', 'Processing', 'Pending', 'Hold', 'Refunded', 'Completed', 'Cancelled') DEFAULT 'Pending';";

            $wpdb->query( $migration_query );
        }

    }

    /**
     * Custom inline css
     */
    public function etn_custom_inline_css(){
      $settings =  \Etn\Core\Settings\Settings::instance()->get_settings_option();
      $etn_custom_css = '';
      $primary_color = "#5D78FF";
      $secondary_color = "";

        // cart bg color
        if( !empty( $settings['etn_primary_color'] ) ){
            $primary_color =  $settings['etn_primary_color'] ;
        } 

        // cart icon color
        if( !empty( $settings['etn_secondary_color'] ) ){
            $secondary_color = $settings['etn_secondary_color'] ;
        }

      $etn_custom_css.="
        .etn-event-single-content-wrap .etn-event-meta .etn-event-category span,
        .etn-event-item .etn-event-footer .etn-atend-btn .etn-btn-border,
        .etn-btn.etn-btn-border, .attr-btn-primary.etn-btn-border, 
        .etn-attendee-form .etn-btn.etn-btn-border, 
        .etn-ticket-widget .etn-btn.etn-btn-border,
        .etn-settings-dashboard .button-primary.etn-btn-border,
        .etn-single-speaker-item .etn-speaker-content a:hover,
        .etn-event-style2 .etn-event-date,
        .etn-event-style3 .etn-event-content .etn-title a:hover,
        .event-tab-wrapper ul li a.etn-tab-a,
        .etn-speaker-item.style-3:hover .etn-speaker-content .etn-title a,
        .etn-event-item:hover .etn-title a{
            color: {$primary_color}; 
        }
        .etn-event-item .etn-event-category span,
        .etn-btn, .attr-btn-primary, 
        .etn-attendee-form .etn-btn, 
        .etn-ticket-widget .etn-btn,
        .schedule-list-1 .schedule-header,
        .speaker-style4 .etn-speaker-content .etn-title a,
        .etn-speaker-details3 .speaker-title-info,
        .etn-event-slider .swiper-pagination-bullet, .etn-speaker-slider .swiper-pagination-bullet,
        .etn-event-slider .swiper-button-next, .etn-event-slider .swiper-button-prev,
         .etn-speaker-slider .swiper-button-next, .etn-speaker-slider .swiper-button-prev,
        .etn-single-speaker-item .etn-speaker-thumb .etn-speakers-social a,
        .etn-event-header .etn-event-countdown-wrap .etn-count-item, 
        .schedule-tab-1 .etn-nav li a.etn-active,
        .schedule-list-wrapper .schedule-listing.multi-schedule-list .schedule-slot-time,
        .etn-speaker-item.style-3 .etn-speaker-content .etn-speakers-social a,
        .event-tab-wrapper ul li a.etn-tab-a.etn-active,
        .etn-btn, button.etn-btn.etn-btn-primary,
        .etn-schedule-style-3 ul li:before,
        .etn-zoom-btn,
        .cat-radio-btn-list [type=radio]:checked+label:after, 
        .cat-radio-btn-list [type=radio]:not(:checked)+label:after,
        .etn-default-calendar-style .fc-button:hover,
        .etn-default-calendar-style .fc-state-highlight,
        .etn-settings-dashboard .button-primary{
            background-color: {$primary_color}; 
        }

        .etn-event-item .etn-event-footer .etn-atend-btn .etn-btn-border,
        .etn-btn.etn-btn-border, .attr-btn-primary.etn-btn-border,
        .etn-attendee-form .etn-btn.etn-btn-border,
        .etn-ticket-widget .etn-btn.etn-btn-border,
        .event-tab-wrapper ul li a.etn-tab-a,
        .event-tab-wrapper ul li a.etn-tab-a.etn-active,
        .etn-schedule-style-3 ul li:after,
        .etn-default-calendar-style .fc-ltr .fc-basic-view .fc-day-top.fc-today .fc-day-number,
        .etn-default-calendar-style .fc-button:hover,
        .etn-settings-dashboard .button-primary.etn-btn-border{
            border-color: {$primary_color}; 
        }
        .schedule-tab-wrapper .etn-nav li a.etn-active,
        .etn-speaker-item.style-3 .etn-speaker-content{
            border-bottom-color: {$primary_color}; 
        }
        .schedule-tab-wrapper .etn-nav li a:after,
        .etn-event-list2 .etn-event-content,
        .schedule-tab-1 .etn-nav li a.etn-active:after{
            border-color: {$primary_color} transparent transparent transparent;
        }
 
        .etn-default-calendar-style .fc .fc-daygrid-bg-harness:first-of-type:before{
            background-color: {$primary_color}2A;
         }

        
        .etn-event-item .etn-event-location,
        .etn-event-tag-list a:hover,
        .etn-schedule-wrap .etn-schedule-info .etn-schedule-time{
            color: {$secondary_color}; 
        }
        .etn-event-tag-list a:hover{
            border-color: {$secondary_color}; 
        }
        .etn-btn:hover, .attr-btn-primary:hover,
        .etn-attendee-form .etn-btn:hover,
        .etn-ticket-widget .etn-btn:hover,
        .speaker-style4 .etn-speaker-content p,
        .etn-btn, button.etn-btn.etn-btn-primary:hover,
        .etn-zoom-btn,
        .etn-speaker-item.style-3 .etn-speaker-content .etn-speakers-social a:hover,
        .etn-single-speaker-item .etn-speaker-thumb .etn-speakers-social a:hover,
        .etn-settings-dashboard .button-primary:hover{
            background-color: {$secondary_color}; 
        }";

      // add inline css
      wp_register_style('etn-custom-css', false);
      wp_enqueue_style('etn-custom-css');
      wp_add_inline_style('etn-custom-css', $etn_custom_css);
    }

    public function get_pro_link(){
        return 'https://themewinter.com/eventin/';
    }

	/**
	 * Create roles and capabilities.
	 */
	public function prepare_roles_capabilities() {
		$initialize_capabilities = !empty( get_option( "etn_initialize_capabilities_done" ) ) ? true : false;
        
        if( !$initialize_capabilities ){

            global $wp_roles;

            if ( ! class_exists( 'WP_Roles' ) ) {
                return;
            }

            if ( ! isset( $wp_roles ) ) {
                $wp_roles = new \WP_Roles();
            }

            $capabilities = self::get_core_capabilities();

            foreach ( $capabilities as $cap_group ) {
                foreach ( $cap_group as $cap ) {
                    $wp_roles->use_db = true;
                    $wp_roles->add_cap( 'administrator', $cap );
                    $wp_roles->add_cap( 'editor', $cap );
                    // $wp_roles->add_cap( 'author', $cap );
                    // $wp_roles->add_cap( 'contributor', $cap );
                }
            }
            update_option( "etn_initialize_capabilities_done", true );

        }
	}

	/**
	 * Get capabilities for WooCommerce - these are assigned to admin/shop manager during installation or reset.
	 *
	 * @return array
	 */
	public static function get_core_capabilities() {
		$capabilities = array();

		$capabilities['eventin'] = array(
			'manage_etn_event',
			'manage_etn_speaker',
			'manage_etn_schedule',
			'manage_etn_attendee',
			'manage_etn_zoom',
			'manage_etn_settings',
		);

		return $capabilities;
	}

    /**
     * change attendee submenu position if attendee section is enabled through setting
     *
     * @return array
     */
    function change_attendee_submenu_position() {
        global $submenu;
        
        
        $settings        = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $attendee_module = ! empty( $settings['attendee_registration'] ) ? true : false;
        $zoom_module     = ! empty( $settings['etn_zoom_api'] ) ? true : false;
                
    }

}
