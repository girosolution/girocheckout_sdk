<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * sample code for GiroCheckout integration of an apple pay transaction via form
 *
 * @filesource
 * @package Samples
 * @version $Revision$ / $Date$
 */
require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 0;        // Your merchant ID (Verkaufer-ID)
$projectID = 0;         // Your project ID (Projekt-ID)
$projectPassword = "";  // Your project password

$basket = [
    "basket_id" => "basket".random_int(10000,999999), // Unique identifier for the basket
    "basket_type" => "DIGITAL", // Type of basket: DIGITAL, PHYSICAL, or MIXED
    "basket_items" => [ // List of items in the basket
        [
            "name" => "Item 1", // Name of the item
            "quantity" => [
                "quantity_amount" => 1, // Amount of units
                "quantity_unit" => "pcs" // Unit of measurement
            ],
            "unit_price" => [
                "net" => 1000, // Amount excluding tax (minor unit)
                "gross" => 1000, // Amount including tax (minor unit)
                "currency" => "EUR", // ISO 4217 currency code
                "tax" => 0 // Tax percentage (with two implied decimals, e.g., 20.00%)
            ]
        ]
    ]
];

try {
	$request = new GiroCheckout_SDK_Request( GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_APPLE_PAY_FORM_TRANSACTION);
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('merchantTxId',1234567890)
	        ->addParam('amount',1000)
	        ->addParam('currency','EUR')
	        ->addParam('purpose','Beispieltransaktion 2')
	        //->addParam('type','AUTH')
	        ->addParam('urlRedirect','https://www.my-domain.de/girocheckout/redirect-applepay')
	        ->addParam('urlNotify','https://www.my-domain.de/girocheckout/redirect-applepay')
          ->addParam('kassenzeichen','1234567890')
//          ->addParam( 'billingAddress', json_encode( $billingAddress ) )
//          ->addParam( 'shippingAddress', json_encode( $shippingAddress ) )
//          ->addParam( 'customerInfo', json_encode( $customerInformation ) )
          ->addParam( 'basket', json_encode($basket))
	        ->submit();

  //echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";

  /* if transaction succeeded update your local system an redirect the customer */
	if($request->requestHasSucceeded()) {
	   $request->getResponseParam('reference');
	   $request->getResponseParam('redirect');

    $request->redirectCustomerToPaymentProvider();
	}
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
	   $request->getResponseParam('rc');
	   $request->getResponseParam('msg');
	   $msg = $request->getResponseMessage($request->getResponseParam('rc'),'DE');

     echo "ERROR: $msg";
	}
}
catch (Exception $e) {
  echo $e->getMessage();
  echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";
}