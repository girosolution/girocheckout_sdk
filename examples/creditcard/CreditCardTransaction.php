<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * sample code for GiroCheckout integration of a credit card transaction
 *
 * @filesource
 * @package Samples
 * @version $Revision: 176 $ / $Date: 2017-01-09 13:29:27 -0300 (Mon, 09 Jan 2017) $
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

/* init cc transaction an parameters */
try {
	$request = new GiroCheckout_SDK_Request(GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_CREDITCARD_TRANSACTION );
	$request->setSecret($projectPassword);

	$aTdsOptionalInfo = new stdClass();
	$aTdsOptionalInfo->email = "myemail@example.com"; // Optional email address
	$aTdsOptionalInfo->addressesMatch = "false"; // Shipping address matches billing address, array( "true", "false" );

  $aTdsOptionalInfo->billingAddress = new stdClass();
  $aTdsOptionalInfo->billingAddress->line2 = "Beim Nachbarn klingeln";
  $aTdsOptionalInfo->billingAddress->line3 = "zw. 22-24 Uhr";
  $aTdsOptionalInfo->billingAddress->state = "BW";

  $aTdsOptionalInfo->shippingAddress = new stdClass();
  $aTdsOptionalInfo->shippingAddress->city = "Berlin";
  $aTdsOptionalInfo->shippingAddress->postcode = "11113";
  $aTdsOptionalInfo->shippingAddress->country = "DE";
  $aTdsOptionalInfo->shippingAddress->line1 = "Unter den Linden 1";
  $aTdsOptionalInfo->shippingAddress->line2 = "Brandenburger Tor";
  $aTdsOptionalInfo->shippingAddress->line3 = "(linker Bogen)";
  $aTdsOptionalInfo->shippingAddress->state = "BER";

  $aTdsOptionalInfo->homePhoneNumber = new stdClass();
  $aTdsOptionalInfo->homePhoneNumber->country = "49";  // phone number country code
  $aTdsOptionalInfo->homePhoneNumber->regional = "75519209309";  // phone number rest

  $aTdsOptionalInfo->mobilePhoneNumber = new stdClass();
  $aTdsOptionalInfo->mobilePhoneNumber->country = "49";  // phone number country code
  $aTdsOptionalInfo->mobilePhoneNumber->regional = "17093902978";  // phone number rest

  $aTdsOptionalInfo->workPhoneNumber = new stdClass();
  $aTdsOptionalInfo->workPhoneNumber->country = "49";  // phone number country code
  $aTdsOptionalInfo->workPhoneNumber->regional = "8938928938";  // phone number rest

  $aTdsOptionalInfo->cardholderAccountInfo = new stdClass();
  $aTdsOptionalInfo->cardholderAccountInfo->accountAgeIndicator = "more30less60";  // array( "less30", "more30less60", "more60", "never", "now" );
  $aTdsOptionalInfo->cardholderAccountInfo->passwordChangeIndicator = "never";    // array( "less30", "more30less60", "more60", "never", "now" );
  $aTdsOptionalInfo->cardholderAccountInfo->paymentAccountAgeIndicator = "less30";  // array( "less30", "more30less60", "more60", "never", "now" );
  $aTdsOptionalInfo->cardholderAccountInfo->accountChange = "now";  // array( "less30", "more30less60", "more60", "now" );
  $aTdsOptionalInfo->cardholderAccountInfo->shippingAddressAgeIndicator = "more60";  // array( "less30", "more30less60", "more60", "now" );
  $aTdsOptionalInfo->cardholderAccountInfo->shippingNameIndicator = "different";  // array( "different", "identical" );
  $aTdsOptionalInfo->cardholderAccountInfo->suspiciousAccountActivity = "false";  // array( "true", "false" );
  $aTdsOptionalInfo->cardholderAccountInfo->provisioningDayCount = 10;

  $aTdsOptionalInfo->tdsMerchantRiskIndicators = new stdClass();
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->deliveryTimeframe = "overnight";  // array( "electronic", "moreThanOneDay", "overnight", "sameDay" );
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->deliveryEmailAddress = "hans-mueller@example.com";
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardAmount = 0;
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardCount = 2;
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardCurrency = "EUR";
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->preOrderDate = "2020-12-20";
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->preOrderPurchaseIndicator = "available";  // array( "available", "future" );
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->reorderItemsIndicator = "first";  // array( "first", "reordered" );
  $aTdsOptionalInfo->tdsMerchantRiskIndicators->shippingIndicator = "store";  // array( "digital", "other", "billingAddress", "differentAddress", "store", "verifiedAddress" );

  $aTdsOptionalInfo->tdsRequestorAuthenticationInformation = new stdClass();
  $aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationData = "123Hdajkd/dasjdkk";
  $aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationTimestamp = "2020-11-09T12:09:09";
  $aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationMethod = "ownCredentials";  // array( "federatedId", "fido", "fidoSigned", "issuerCredentials", "none", "ownCredentials", "srcAssurance", "thirdParty" );

  $aTdsOptionalInfo->tdsTransactionAttributes = new stdClass();
  $aTdsOptionalInfo->tdsTransactionAttributes->purchaseInstalmentData = 2;
  $aTdsOptionalInfo->tdsTransactionAttributes->recurringExpiry = "2020-11-30";
  $aTdsOptionalInfo->tdsTransactionAttributes->recurringFrequency = 1234;
  $aTdsOptionalInfo->tdsTransactionAttributes->type = "quasiCash";  // array( "purchase", "checkAcceptance", "accountFunding", "quasiCash", "prepaidActivation" );

	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('merchantTxId',123456330)
	        ->addParam('amount',1000)
	        ->addParam('currency','EUR')
	        ->addParam('type','SALE')
	        ->addParam('purpose','Test Kreditkarte')
	        ->addParam('tds2Address','Mustergasse 89')
	        ->addParam('tds2Postcode','77777')
	        ->addParam('tds2City','Musterort')
	        ->addParam('tds2Country','DE')
	        ->addParam('tds2Optional',json_encode($aTdsOptionalInfo))
	        ->addParam('urlRedirect','https://dev.girosolution.de/redirect.php')
	        ->addParam('urlNotify','https://dev.girosolution.de/notify.php')
	        //the hash field is auto generated by the SDK
	        ->submit();

    //  echo "<pre>";print_r( $request->getResponseRaw() ); echo "</pre>\n";

  /* if transaction succeeded update your local system an redirect the customer */
	if($request->requestHasSucceeded()) {
	   $request->getResponseParam('reference');
	   $request->getResponseParam('redirect');
	   $request->redirectCustomerToPaymentProvider();
	}
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
	   echo "<pre>";print_r( $request->getResponseRaw() ); echo "</pre>\n";

	   $request->getResponseParam('rc');
	   $request->getResponseParam('msg');
	   $request->getResponseMessage($request->getResponseParam('rc'),'DE');
	}
}
catch (Exception $e) { echo $e->getMessage(); }