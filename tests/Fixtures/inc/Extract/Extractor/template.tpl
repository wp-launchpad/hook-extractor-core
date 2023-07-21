<?php

namespace Monetico\Engine\Checkout;

use Monetico\Dependencies\DansMaCulotte\Monetico\Receipts\PurchaseReceipt;
use Monetico\Dependencies\DansMaCulotte\Monetico\Requests\PurchaseRequest;
use Monetico\Dependencies\DansMaCulotte\Monetico\Resources\BillingAddressResource;
use Monetico\Dependencies\DansMaCulotte\Monetico\Resources\ClientResource;
use Monetico\Dependencies\DansMaCulotte\Monetico\Resources\ShippingAddressResource;
use Monetico\Dependencies\DansMaCulotte\Monetico\Responses\PurchaseResponse;
use DateTime;
use Monetico\Dependencies\RocketLauncherCore\EventManagement\SubscriberInterface;
use Monetico\Dependencies\RocketLauncherLogger\Logger;

class GatewaySubscriber implements SubscriberInterface
{
    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param Gateway $gateway
     */
    public function __construct(Gateway $gateway, Logger $logger, string $prefix)
    {
        $this->gateway = $gateway;
        $this->logger = $logger;
        $this->prefix = $prefix;
    }


    public function get_subscribed_events()
    {
        return [
            "woocommerce_api_{$this->prefix}success" => 'success',
            "woocommerce_api_{$this->prefix}error" => 'error',
            "woocommerce_api_{$this->prefix}request" => 'request',
            'monetico_process_payment' => ['process', 7, 2],
        ];
    }

    public function success() {

        if( ! key_exists( "{$this->prefix}order_ref", $_GET ) ) {
            return;
        }

        $order_id = (int) $_GET["{$this->prefix}order_ref"];

        do_action("{$this->prefix}success_order_before", $order_id);

        $order = wc_get_order($order_id);
        if(! $order) {
            return ;
        }

        do_action("{$this->prefix}success_order_after", $order_id);

        wp_redirect($this->gateway->get_return_url( $order ));
        wp_die();
    }

    public function error() {

        if( ! key_exists( "{$this->prefix}order_ref", $_GET ) ) {
            return;
        }

        $order_id = (int) $_GET["{$this->prefix}order_ref"];

        do_action("{$this->prefix}error_order_before", $order_id);

        $order = wc_get_order($order_id);
        if(! $order) {
            return ;
        }

        $order->update_status( 'cancelled' );

        do_action("{$this->prefix}error_order_after", $order_id);

        wp_redirect(home_url());
        wp_die();
    }

    public function request() {

        $response = new PurchaseResponse($_POST);

        $result = $this->gateway->getMonetico()->validate($response);

        if($result) {
            $order = wc_get_order($response->reference);
            do_action("{$this->prefix}process_request_order_before", $response->reference);
            $order->payment_complete();
            do_action("{$this->prefix}process_request_order_after", $response->reference);
        }

        $receipt = new PurchaseReceipt($result);
        echo $receipt;
        wp_die();
    }


    public function process(array $answer, $order_id) {
        do_action("{$this->prefix}process_order_before", $order_id);

        $order = wc_get_order($order_id);

        $language = strtoupper(explode('_', get_locale())[0]);

        $purchase_params = apply_filters(
            "{$this->prefix}purchase_request_data",
            [
                'reference' => $order->get_id(),
                'description' => 'Documentation',
                'language' => $language,
                'email' => $order->get_billing_email(),
                'amount' => $order->get_total(),
                'currency' => $order->get_currency(),
                'dateTime' => new DateTime(),
                'successUrl' => str_replace(
                    'https:',
                    'http:',
                    add_query_arg( "{$this->prefix}order_ref", $order->get_id(), home_url( '/monetico/success/' ) ) ),
                'errorUrl' => str_replace(
                    'https:',
                    'http:',
                    add_query_arg( "{$this->prefix}order_ref", $order->get_id(), home_url( '/monetico/error/' ) ) ),
            ]
        );

        $this->logger->info("purchase_request_data : " . json_encode($purchase_params));

        $purchase = new PurchaseRequest(
            $purchase_params
        );

        $billing_address_data = apply_filters(
            "{$this->prefix}billing_address_data",
            [
                'addressLine1' =>  $order->get_billing_address_1(),
                'city' => $order->get_billing_city(),
                'postalCode' => $order->get_billing_postcode(),
                'country' => $order->get_billing_country(),
            ]
        );

        $this->logger->info("billing_address_data : " . json_encode($billing_address_data));

        $billingAddress = new BillingAddressResource(
            $billing_address_data
        );

        $purchase->setBillingAddress($billingAddress);
        if($order->get_shipping_method()) {

            $shipping_address_data = apply_filters("{$this->prefix}shipping_address_data",
                [
                    'addressLine1' =>  $order->get_shipping_address_1(),
                    'city' => $order->get_shipping_city(),
                    'postalCode' => $order->get_shipping_postcode(),
                    'country' => $order->get_shipping_country(),
                ]
            );

            $this->logger->info("shipping_address_data : " . json_encode($shipping_address_data));

            $shippingAddress = new ShippingAddressResource(
                $shipping_address_data
            );
            $purchase->setShippingAddress($shippingAddress);
        }

        $client_data = apply_filters(
            "{$this->prefix}client_data",
            [
                'firstName' => $order->get_billing_first_name(),
                'lastName' => $order->get_billing_last_name(),
            ]
        );

        $this->logger->info("client_data : " . json_encode($client_data));

        $client = new ClientResource(
            $client_data
        );
        $order->get_billing_company();
        $purchase->setClient($client);
        $url = PurchaseRequest::getUrl($this->gateway->isTestmode());
        $fields = $this->gateway->getMonetico()->getFields($purchase);

        wc_reduce_stock_levels($order->get_id());
        // Remove cart
        WC()->cart->empty_cart();

        do_action("{$this->prefix}process_order_after", $order_id);

        $answer['redirect'] = add_query_arg( $fields, $url );

        return $answer;
    }
}