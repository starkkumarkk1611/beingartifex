<?php

require_once ('razorpay-sdk/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors;

GFForms::include_payment_addon_framework();

class GFRazorpay extends GFPaymentAddOn
{
    /**
     * Razorpay plugin config key ID and key secret
     */
    const GF_RAZORPAY_KEY                  = 'gf_razorpay_key';
    const GF_RAZORPAY_SECRET               = 'gf_razorpay_secret';
    const GF_RAZORPAY_PAYMENT_ACTION       = 'gf_razorpay_payment_action';
    const GF_RAZORPAY_ENABLE_WEBHOOK       = 'gf_razorpay_enable_webhook';
    const GF_RAZORPAY_WEBHOOK_SECRET       = 'gf_razorpay_webhook_secret';

    /**
     * Razorpay API attributes
     */
    const RAZORPAY_ORDER_ID                = 'razorpay_order_id';
    const RAZORPAY_PAYMENT_ID              = 'razorpay_payment_id';
    const RAZORPAY_SIGNATURE               = 'razorpay_signature';
    const CAPTURE                          = 'capture';
    const AUTHORIZE                        = 'authorize';
    const ORDER_PAID                       = 'order.paid';

    /**
     * Cookie set for one day
     */
    const COOKIE_DURATION                  = 86400;

    /**
     * Customer related fields
     */
    const CUSTOMER_FIELDS_NAME             = 'name';
    const CUSTOMER_FIELDS_EMAIL            = 'email';
    const CUSTOMER_FIELDS_CONTACT          = 'contact';

    // TODO: Check if all the variables below are needed

    /**
     * @var string Version of current plugin
     */
    protected $_version                    = GF_RAZORPAY_VERSION;

    /**
     * @var string Minimum version of gravity forms
     */
    protected $_min_gravityforms_version   = '1.9.3';

    /**
     * @var string URL-friendly identifier used for form settings, add-on settings, text domain localization...
     */
    protected $_slug                       = 'razorpay-gravity-forms';

    /**
     * @var string Relative path to the plugin from the plugins folder. Example "gravityforms/gravityforms.php"
     */
    protected $_path                       = 'razorpay-gravity-forms/razorpay.php';

    /**
     * @var string Full path the the plugin. Example: __FILE__
     */
    protected $_full_path                  = __FILE__;

    /**
     * @var string URL to the Gravity Forms website. Example: 'http://www.gravityforms.com' OR affiliate link.
     */
    protected $_url                        = 'http://www.gravityforms.com';

    /**
     * @var string Title of the plugin to be used on the settings page, form settings and plugins page. Example: 'Gravity Forms MailChimp Add-On'
     */
    protected $_title                      = 'Gravity Forms Razorpay Add-On';

    /**
     * @var string Short version of the plugin title to be used on menus and other places where a less verbose string is useful. Example: 'MailChimp'
     */
    protected $_short_title                = 'Razorpay';

    /**
     * Defines if the payment add-on supports callbacks.
     *
     * If set to true, callbacks/webhooks/IPN will be enabled and the appropriate database table will be created.
     *
     * @since  Unknown
     * @access protected
     *
     * @used-by GFPaymentAddOn::upgrade_payment()
     *
     * @var bool True if the add-on supports callbacks. Otherwise, false.
     */
    protected $_supports_callbacks         = true;


    /**
     * If true, feeds will be processed asynchronously in the background.
     *
     * @since 2.2
     * @var bool
     */
    public $_async_feed_processing         = false;

    // --------------------------------------------- Permissions Start -------------------------------------------------

    /**
     * @var string|array A string or an array of capabilities or roles that have access to the settings page
     */
    protected $_capabilities_settings_page = 'gravityforms_razorpay';

    /**
     * @var string|array A string or an array of capabilities or roles that have access to the form settings
     */
    protected $_capabilities_form_settings = 'gravityforms_razorpay';

    /**
     * @var string|array A string or an array of capabilities or roles that can uninstall the plugin
     */
    protected $_capabilities_uninstall     = 'gravityforms_razorpay_uninstall';

    // --------------------------------------------- Permissions End ---------------------------------------------------

    /**
     * @var bool Used by Rocketgenius plugins to activate auto-upgrade.
     * @ignore
     */
    protected $_enable_rg_autoupgrade      = true;

    /**
     * @var GFRazorpay
     */
    private static $_instance              = null;



    public static function get_instance()
    {
        if (self::$_instance === null)
        {
            self::$_instance = new GFRazorpay();
        }

        return self::$_instance;
    }


    public function init_frontend()
    {
        parent::init_frontend();
        add_action('gform_after_submission', array($this, 'generate_razorpay_order'), 10, 2);
    }

    public function plugin_settings_fields()
    {
        $webhookUrl = esc_url(admin_url('admin-post.php')) . '?action=gf_razorpay_webhook';

        return array(
            array(
                'title'               => 'Razorpay Settings',
                'fields'              => array(
                    array(
                        'name'        => self::GF_RAZORPAY_KEY,
                        'label'       => esc_html__('Razorpay Key', $this->_slug),
                        'type'        => 'text',
                        'class'       => 'medium',
                    ),
                    array(
                        'name'        => self::GF_RAZORPAY_SECRET,
                        'label'       => esc_html__('Razorpay Secret', $this->_slug),
                        'type'        => 'text',
                        'class'       => 'medium',
                    ),
                    array(
                        'name'   => self::GF_RAZORPAY_PAYMENT_ACTION,
                        'label' => esc_html__('Payment Action', 'razorpay'),
                        'tooltip' => esc_html__('Payment action on order complete.', $this->_slug),
                        'type' => 'select',
                        'size' => 'regular',
                        'default' => self::CAPTURE,
                        'choices' => array(
                            array(
                                'label' => esc_html__( 'Authorize and Capture', $this->_slug ),
                                'value' => self::CAPTURE
                            ),
                            array(
                                'label' => esc_html__( 'Authorize', $this->_slug ),
                                'value' => self::AUTHORIZE
                            ),
                        )
                    ),
                    array(
                        'name'   => self::GF_RAZORPAY_ENABLE_WEBHOOK,
                        'type' => 'checkbox',
                        'label' => esc_html__( 'Enable Webhook', $this->_slug ),
                        'description' => __( 'Enable Razorpay Webhook <a href="https://dashboard.razorpay.com/#/app/webhooks">here</a> with the URL listed below.' ). '<br/>' . __( '<span style="width:300px;font-weight: bold; margin:5px 0;" class="rzp-webhook-url">'.$webhookUrl.'</span>
                            <span class="rzp-webhook-to-clipboard" style="background-color: #337ab7; color: white; border: none;cursor: pointer; padding: 2px 4px; text-decoration: none;display: inline-block;"">Copy</span>
                            <br/>Instructions and guide to <a href="https://razorpay.com/docs/webhooks/">Razorpay webhooks</a>

                            <script type="text/javascript">
                                (jQuery)(function() {
                                    (jQuery)(".rzp-webhook-to-clipboard").click(function() {
                                        var temp = (jQuery)("<input>");
                                        (jQuery)("body").append(temp);
                                        temp.val((jQuery)(".rzp-webhook-url").text()).select();
                                        document.execCommand("copy");
                                        temp.remove();
                                        (jQuery)(".rzp-webhook-to-clipboard").text("Copied");
                                    });
                                });
                            </script>', $this->_slug ),
                        'choices' => array(
                            array(
                                'name' => self::GF_RAZORPAY_ENABLE_WEBHOOK,
                                'value' => '1',
                                'label' => ''
                            ),
                        )
                    ),
                    array(
                        'name'   => self::GF_RAZORPAY_WEBHOOK_SECRET,
                        'label' => esc_html__('Webhook Secret', $this->_slug),
                        'tooltip' => esc_html__('<br/> Webhook secret is used for webhook signature verification. This has to match the one added <a href="https://dashboard.razorpay.com/#/app/webhooks">here</a>', $this->_slug),
                        'type' => 'text',
                        'size' => 'regular',
                    ),
                    array(
                        'type'        => 'save',
                        'messages'    => array(
                            'success' => esc_html__('Settings have been updated.', $this->_slug)
                        ),
                    ),
                ),
            ),
        );
    }

    public function get_customer_fields($form, $feed, $entry)
    {
        $fields = array();

        $billing_fields = $this->billing_info_fields();

        foreach ($billing_fields as $field)
        {
            $field_id = $feed['meta']['billingInformation_' . $field['name']];

            $value = $this->get_field_value($form, $entry, $field_id);

            $fields[$field['name']] = $value;
        }

        return $fields;
    }

    public function callback()
    {
        $razorpayOrderId = $_COOKIE[self::RAZORPAY_ORDER_ID];

        $key = $this->get_plugin_setting(self::GF_RAZORPAY_KEY);

        $secret = $this->get_plugin_setting(self::GF_RAZORPAY_SECRET);

        $api = new Api($key, $secret);

        try
        {
            $order = $api->order->fetch($razorpayOrderId);
        }
        catch (\Exception $e)
        {
            $action = array(
                'type'  => 'fail_payment',
                'error' => $e->getMessage()
            );

            return $action;
        }

        $entryId = $order['receipt'];

        $entry = GFAPI::get_entry($entryId);

        $attributes = $this->get_callback_attributes();

        $action = array(
            'id'             => $attributes[self::RAZORPAY_PAYMENT_ID],
            'type'           => 'fail_payment',
            'transaction_id' => $attributes[self::RAZORPAY_PAYMENT_ID],
            'amount'         => $entry['payment_amount'],
            'payment_method' => 'razorpay',
            'entry_id'       => $entry['id'],
            'error'          => 'Payment Failed',
        );

        $success = false;

        if ((empty($entry) === false) and
            (empty($attributes[self::RAZORPAY_PAYMENT_ID]) === false) and
            (empty($attributes[self::RAZORPAY_SIGNATURE]) === false))
        {
            try
            {
                $api->utility->verifyPaymentSignature($attributes);

                $success = true;
            }
            catch (Errors\SignatureVerificationError $e)
            {
                $action['error'] = $e->getMessage();

                return $action;
            }
        }

        if ($success === true)
        {
            $action['type'] = 'complete_payment';

            $action['error'] = null;
        }

        return $action;
    }

    public function get_callback_attributes()
    {
        return array(
            self::RAZORPAY_ORDER_ID   => $_COOKIE[self::RAZORPAY_ORDER_ID],
            self::RAZORPAY_PAYMENT_ID => sanitize_text_field(rgpost(self::RAZORPAY_PAYMENT_ID)),
            self::RAZORPAY_SIGNATURE  => sanitize_text_field(rgpost(self::RAZORPAY_SIGNATURE)),
        );
    }

    public function post_callback($callback_action, $callback_result) 
    {
        if (is_wp_error( $callback_action ) || ! $callback_action) 
        {
            return false;
        }
        
        $entry = null;

        $feed = null;

        $ref_id    = url_to_postid(wp_get_referer());
        $ref_title = $ref_id > 0 ? get_the_title($ref_id): "Home";
        $ref_url   = get_home_url();
        $form_id   = 0;

        if (isset($callback_action['entry_id']) === true)
        {
            $entry          = GFAPI::get_entry($callback_action['entry_id']);
            $feed           = $this->get_payment_feed($entry);
            $transaction_id = rgar($callback_action, 'transaction_id');
            $amount         = rgar($callback_action, 'amount');
            $status         = rgar($callback_action, 'type');
            $ref_url        = $entry['source_url'];
            $form_id        = $entry['form_id'];
        }

        if ($status === 'complete_payment') 
        {
          do_action('gform_razorpay_complete_payment', $callback_action['transaction_id'], $callback_action['amount'], $entry, $feed);
        }
        else
        {
            do_action('gform_razorpay_fail_payment', $entry, $feed);
        } 

        $form = GFAPI::get_form($form_id);

        if ( ! class_exists( 'GFFormDisplay' ) ) {
            require_once( GFCommon::get_base_path() . '/form_display.php' );
        }

        $confirmation = GFFormDisplay::handle_confirmation( $form, $entry, false );

        if ( is_array( $confirmation ) && isset( $confirmation['redirect'] ) ) {
            header( "Location: {$confirmation['redirect']}" );
            exit;
        }

        ?>
        <head> <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) .'assets/css/style.css';?>" ><script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) .'assets/js/script.js'?>" ></script> </head>
        <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table> <tr> <td class="title"> <img src="https://razorpay.com/assets/razorpay-logo.svg" style="width:100%; max-width:300px;margin-left:30%"> </td>
                        </tr></table>
                    </td>
                </tr>
                <tr class="heading"> <td> Payment Details </td><td> Value </td></tr>
                <tr class="item"> <td> Status </td><td> <?php echo $status == 'complete_payment'? "Success ✅":"Fail 🚫"; ?> </td></tr>
                <?php 
                if($status == 'complete_payment')
                {
                ?>
                <tr class="item"> <td> Transaction Id </td><td> # <?php echo $transaction_id; ?> </td></tr>
                <?php
                }else{
                ?>
                <tr class="item"> <td> Transaction Error</td><td> <?php echo $callback_action['error']; ?> </td></tr>
                <?php
                }
                ?>
                <tr class="item"> <td> Transaction Date </td><td> <?php echo date("F j, Y"); ?> </td></tr>
                <tr class="item last"> <td> Amount </td><td> <?php echo $amount ?> </td></tr>
            </table>
            <p style="font-size:17px;text-align:center;">Go back to the <strong><a href="<?php echo $ref_url; ?>"><?php echo $ref_title; ?></a></strong> page. </p>
            <!-- <p style="font-size:17px;text-align:center;"><strong>Note:</strong> This page will automatically redirected to the <strong><?php echo $ref_title; ?></strong> page in <span id="rzp_refresh_timer"></span> seconds.</p> -->
            <!-- <progress style = "margin-left: 40%;" value="0" max="10" id="progressBar"></progress> -->
            <div style="margin-left:22%; margin-top: 20px;">
                <?php echo $confirmation; ?>
            </div>
        </div>
        </body>';
        <!-- <script type="text/javascript">setTimeout(function(){window.location.href="<?php echo $ref_url; ?>"}, 1e3 * rzp_refresh_time), setInterval(function(){rzp_actual_refresh_time > 0 ? (rzp_actual_refresh_time--, document.getElementById("rzp_refresh_timer").innerText=rzp_actual_refresh_time) : clearInterval(rzp_actual_refresh_time)}, 1e3);</script> -->
        <?php

    }

    public function generate_razorpay_form($entry, $form)
    {
        $feed = $this->get_payment_feed($entry, $form);

        $customerFields = $this->get_customer_fields($form, $feed, $entry);

        $key = $this->get_plugin_setting(self::GF_RAZORPAY_KEY);
        
        $callbackUrl = esc_url(site_url()) . '/?page=gf_razorpay_callback';
        
        $razorpayArgs = array(
            'key'           => $key,
            'name'          => get_bloginfo('name'),
            'amount'        => (int) round($entry['payment_amount'] * 100),
            'currency'      => $entry['currency'],
            'description'   => $form['description'],
            'prefill'       => array(
                'name'      => $customerFields[self::CUSTOMER_FIELDS_NAME],
                'email'     => $customerFields[self::CUSTOMER_FIELDS_EMAIL],
                'contact'   => $customerFields[self::CUSTOMER_FIELDS_CONTACT],
            ),
            'notes'         => array(
                'gravity_forms_order_id' => $entry['id']
            ),
            "_"             => array(
                'integration'                => "gravityforms",
                'integration_version'        => GF_RAZORPAY_VERSION,
                'integration_parent_version' => GFForms::$version
            ),
            'order_id'      => $entry[self::RAZORPAY_ORDER_ID],
            'callback_url'  => $callbackUrl,
            'integration'   => 'gravityforms',
        );

        wp_enqueue_script('razorpay_script',
                          plugin_dir_url(__FILE__). 'script.js',
                          array('checkout')
        );

        wp_localize_script('razorpay_script',
                           'razorpay_script_vars',
                           array(
                               'data' => $razorpayArgs
                           )
        );

        wp_register_script('checkout',
                           'https://checkout.razorpay.com/v1/checkout.js',
                           null,
                           null
        );

        wp_enqueue_script('checkout');

        $redirect_url = '?page=gf_razorpay_callback';

        return $this->generate_order_form($redirect_url);
    }

    function generate_order_form($redirect_url)
    {
        $html = <<<EOT
<form id ='razorpayform' name='razorpayform' action="$redirect_url" method='POST'>
    <input type='hidden' name='razorpay_payment_id' id='razorpay_payment_id'>
    <input type='hidden' name='razorpay_signature'  id='razorpay_signature' >
</form>
<p id='msg-razorpay-success'  style='display:none; text-align:center'>
    <h3 style='text-align:center'>Please wait while we are processing your payment.</h3>
</p>
<p>
    <button id='btn-razorpay' style='display:none'>Pay With Razorpay</button>
    <button id='btn-razorpay-cancel' style='display:none' onclick='document.razorpayform.submit()'>Cancel</button>
</p>
EOT;
        return $html;
    }
    public function is_callback_valid()
    {
        // Will check if the return url is valid
        if (rgget('page') !== 'gf_razorpay_callback')
        {
            return false;
        }

        return true;
    }

    public function generate_razorpay_order($entry, $form)
    {
        $feed            = $this->get_payment_feed( $entry );
        $submission_data = $this->get_submission_data( $feed, $form, $entry );

        //Check if gravity form is executed without any payment
        if ( ! $feed || empty( $submission_data['payment_amount'] ) ) {
            return true;
        }
        //gravity form method to get value of payment_amount key from entry
        $paymentAmount = rgar($entry, 'payment_amount' );

        //It will be null first time in the entry
        if (empty($paymentAmount) === true)
        {
            $paymentAmount = GFCommon::get_order_total($form, $entry);
            gform_update_meta($entry['id'], 'payment_amount', $paymentAmount);
            $entry['payment_amount'] = $paymentAmount;
        }

        $key = $this->get_plugin_setting(self::GF_RAZORPAY_KEY);

        $secret = $this->get_plugin_setting(self::GF_RAZORPAY_SECRET);

        $payment_action = $this->get_plugin_setting(self::GF_RAZORPAY_PAYMENT_ACTION) ? $this->get_plugin_setting(self::GF_RAZORPAY_PAYMENT_ACTION) : self::CAPTURE;

        $api = new Api($key, $secret);

        $data = array(
            'receipt'         => $entry['id'],
            'amount'          => (int) round($paymentAmount * 100),
            'currency'        => $entry['currency'],
            'payment_capture' => ($payment_action === self::CAPTURE) ? 1 : 0
        );

        try
        {
            $razorpayOrder = $api->order->create($data);


            gform_update_meta($entry['id'], self::RAZORPAY_ORDER_ID, $razorpayOrder['id']);

            $entry[self::RAZORPAY_ORDER_ID] = $razorpayOrder['id'];

            GFAPI::update_entry($entry);

            setcookie(self::RAZORPAY_ORDER_ID, $entry[self::RAZORPAY_ORDER_ID],
                time() + self::COOKIE_DURATION, COOKIEPATH, COOKIE_DOMAIN, false, true);

            echo $this->generate_razorpay_form($entry, $form);
        }
        catch (\Exception $e)
        {
            do_action('gform_razorpay_fail_payment', $entry, $feed);

            $errorMessage = $e->getMessage();

            echo $errorMessage;

        }
    }

    public function billing_info_fields()
    {
        $fields = array(
            array( 'name' => self::CUSTOMER_FIELDS_NAME, 'label' => esc_html__( 'Name', 'gravityforms' ), 'required' => false ),
            array( 'name' => self::CUSTOMER_FIELDS_EMAIL, 'label' => esc_html__( 'Email', 'gravityforms' ), 'required' => false ),
            array( 'name' => self::CUSTOMER_FIELDS_CONTACT, 'label' => esc_html__( 'Phone', 'gravityforms' ), 'required' => false ),
        );

        return $fields;
    }

    public function init()
    {
        add_filter( 'gform_notification_events', array( $this, 'notification_events' ), 10, 2 );

        // Supports frontend feeds.
        $this->_supports_frontend_feeds = true;

        parent::init();

    }

    // Added custom event to provide option to chose event to send notifications.
    public function notification_events($notification_events, $form)
    {
        $has_razorpay_feed = function_exists( 'gf_razorpay' ) ? gf_razorpay()->get_feeds( $form['id'] ) : false;

        if ($has_razorpay_feed) {
            $payment_events = array(
                'complete_payment'          => __('Payment Completed', 'gravityforms'),
            );

            return array_merge($notification_events, $payment_events);
        }

        return $notification_events;

    }

    //Add post payment action after payment success.
    public function post_payment_action($entry, $action)
    {
        $form = GFAPI::get_form( $entry['form_id'] );

        GFAPI::send_notifications( $form, $entry, rgar( $action, 'type' ) );
    }

    /**
     * [process_webhook to process the razorpay webhook]
     * @return [type] [description]
     */
    public function process_webhook()
    {
        $post = file_get_contents('php://input');

        $data = json_decode($post, true);

        if (json_last_error() !== 0)
        {
            return;
        }

        $enabled = $this->get_plugin_setting(self::GF_RAZORPAY_ENABLE_WEBHOOK);

        if (isset($enabled) === true and
            (empty($data['event']) === false))
        {
            if (isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']) === true)
            {
               $razorpay_webhook_secret = $this->get_plugin_setting(self::GF_RAZORPAY_WEBHOOK_SECRET);

                $key = $this->get_plugin_setting(self::GF_RAZORPAY_KEY);

                $secret = $this->get_plugin_setting(self::GF_RAZORPAY_SECRET);

                $api = new Api($key, $secret);
                //
                // If the webhook secret isn't set on wordpress, return
                //
                if (empty($razorpay_webhook_secret) === true)
                {
                    return;
                }

                try
                {
                    $api->utility->verifyWebhookSignature($post,
                                                                $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'],
                                                                $razorpay_webhook_secret);
                }
                catch (Errors\SignatureVerificationError $e)
                {
                    $log = array(
                        'message'   => $e->getMessage(),
                        'data'      => $data,
                        'event'     => 'gf.razorpay.signature.verify_failed'
                    );

                    error_log(json_encode($log));
                    status_header( 401 );
                    return;
                }

                switch ($data['event'])
                {
                    case self::ORDER_PAID:
                        return $this->order_paid($data);

                    default:
                        return;
                }
            }
        }
    }
    /**
     * [order_paid Consume 'order.paid' webhook payload for order processing]
     * @param  [array] $data [webhook payload]
     * @return [type]       [description]
     */
    private function order_paid($data)
    {
        $entry_id = $data['payload']['payment']['entity']['notes']['gravity_forms_order_id'];

        if(empty($entry_id) === false)
        {
            $entry = GFAPI::get_entry($entry_id);

            if(is_array($entry) === true)
            {
                $razorpay_payment_id = $data['payload']['payment']['entity']['id'];

                //check the payment status not set
                if(empty($entry['payment_status']) === true)
                {
                    //check for valid amount
                    $payment_amount = $data['payload']['payment']['entity']['amount'];

                    $order_amount =  (int) round(rgar($entry, 'payment_amount' ) * 100);

                    //if valid amount paid mark the order complete
                    if($payment_amount === $order_amount)
                    {
                        $action = array(
                            'id'             => $razorpay_payment_id,
                            'type'           => 'complete_payment',
                            'transaction_id' => $razorpay_payment_id,
                            'amount'         => rgar($entry, 'payment_amount' ),
                            'entry_id'       => $entry_id,
                            'payment_method' => 'razorpay',
                            'error'          => null,
                        );

                        $this->complete_payment($entry, $action );
                    }
                }
            }
        }
    }

}
