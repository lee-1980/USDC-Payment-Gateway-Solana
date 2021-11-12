<?php
if (!defined('ABSPATH')) exit;

class WC_FYFYUSDC_Gateway extends WC_Payment_Gateway {

    public function __construct()
    {
        $this->id = 'fyfy_usdc'; // payment gateway plugin ID
        $this->icon = plugin_dir_url(__DIR__) . 'assets/images/coin_payment_logo.png'; // URL of the icon that will be displayed on checkout page near your gateway name
        $this->has_fields = true; // in case you need a custom credit card form
        $this->method_title = 'FyFy USDC Gateway';
        $this->method_description = 'Allow customers to pay using USDC'; // will be displayed on the options page


        // but in this tutorial we begin with simple payments
        $this->supports = array(
            'products'
        );

        // Method with all the options fields
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->enabled = $this->get_option('enabled');
        $this->store_address =  $this->get_option('store_address_key');


        // This action hook saves the settings
        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }


    public function init_form_fields(){

        $this->form_fields = array(
            'enabled' => array(
                'title'       => 'Enable/Disable',
                'label'       => 'Enable FyFy USDC Payment Gateway',
                'type'        => 'checkbox',
                'description' => '',
                'default'     => 'no'
            ),
            'title' => array(
                'title'       => 'Title',
                'type'        => 'text',
                'description' => 'This controls the title which the user sees during checkout.',
                'default'     => 'FyFy USDC Payment Gateway',
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => 'Description',
                'type'        => 'textarea',
                'description' => 'This controls the description which the user sees during checkout.',
                'default'     => 'Pay with your Phantom and SolFare in USDC.',
            ),
            'store_address_key' => array(
                'title'       => 'Store Wallet Address',
                'type'        => 'text'
            )
        );
    }


}