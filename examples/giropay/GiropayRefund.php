<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * sample code for GiroCheckout integration of a giropay refund transaction
 *
 * Call through web server in two steps:
 * 1) Without arguments for initial SALE transaction: http://localhost/GiropayRefund.php, copy displayed reference
 * 2) With reference code from SALE for REFUND, parameter mode=ref (for refund), parameter ref for reference:
 * http://localhost/GiropayRefund.php?mode=ref&ref=bf766f27-d6ff-4706-846c-ba5dad32d15e
 * 3) Alternatively, you may skip the first step if you already have a reference to a giropay transaction,
 * and specify the reference directly in the command line or in the commented field $strReference below.
 *
 * Remember that you can only refund a transaction that has been captured or booked directly (type SALE) before.
 *
 * @filesource
 * @package Samples
 * @version $Revision: 109 $ / $Date: 2015-06-01 13:37:30 +0200 (Mo, 01 Jun 2015) $
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

// Optionally skip first step and specify reference directly
//$strReference = "bf766f27-d6ff-4706-846c-ba5dad32d15e";

if( !empty($strReference) ) {
  $ref = $strReference;
  $mode = "ref";
}

if( isset($_GET["mode"]) ) {
  $mode = $_GET["mode"];
}
if( isset($_GET["ref"]) ) {
  $ref = $_GET["ref"];
}

if( !isset($mode) ) {
  /* STEP 1: init giropay SALE transaction and parameters */
  try {
    $request = new GiroCheckout_SDK_Request( GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_GIROPAY_TRANSACTION );
    $request->setSecret($projectPassword);

  	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('merchantTxId',"1234567890123456789012")
	        ->addParam('amount',4200)
	        ->addParam('currency','EUR')
	        ->addParam('purpose','Test S-Public')
	        //->addParam('purpose','Best. 12345, Kd. 123')
//          ->addParam('shoppingCartType','MIXED')
          ->addParam('shoppingCartType','DIGITAL')
	        ->addParam('shippingAddresseFirstName','Max')
	        ->addParam('shippingAddresseLastName','Mustermann')
          ->addParam('shippingEmail','mustermann@muster.com')
//          ->addParam('shippingStreet','Musterstr. 39')
//	        ->addParam('shippingZipCode','12345')
//	        ->addParam('shippingCity','Musterstadt')
//	        ->addParam('shippingCountry','DE')
          ->addParam('merchantOrderReferenceNumber','123-123-123')
//	        ->addParam('deliveryType','PACKSTATION')
	        ->addParam('urlRedirect','https://www.my-domain.de/girocheckout/redirect.php')
	        ->addParam('urlNotify','https://www.my-domain.de/girocheckout/notify.php')
//	        ->addParam('kassenzeichen','GA-43898-Z')

            //the hash field is auto generated by the SDK
            ->submit();

    //echo "<pre>"; print_r($request->getResponseRaw()); echo "</pre><br/>";

    // if transaction succeeded update your local system and redirect the customer
    if($request->requestHasSucceeded()) {
      $request->getResponseParam('rc');
      $request->getResponseParam('msg');
      $strReference = $request->getResponseParam('reference');
      $request->getResponseParam('redirect');

      $request->redirectCustomerToPaymentProvider();
    }

    // if the transaction did not succeed update your local system, get the responsecode and notify the customer
    else {
      $request->getResponseParam('rc');
      $request->getResponseParam('msg');
      $request->getResponseMessage($request->getResponseParam('rc'),'DE');
    }
  }
  catch (Exception $e) { echo $e->getMessage(); }
}
elseif( $mode == "ref" ) {

  // STEP 2: REFUND
  if( !isset($ref) ) {
    echo "Reference must be given as ref parameter.<br/>";
    exit;
  }
  
  $strReference = $ref;

  if( !empty($strReference) ) {
    //echo "\nOrig Trx Ref: $strReference\n";

    /* init giropay transaction and parameters */
    try {  
      $request = new GiroCheckout_SDK_Request( GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_GIROPAY_REFUND );
      $request->setSecret($projectPassword);

      $request->addParam('merchantId',$merchantID)
              ->addParam('projectId',$projectID)
              ->addParam('merchantTxId',"123456")
              ->addParam('amount',4200)  // Anzahlung
              ->addParam('currency','EUR')
              ->addParam('purpose','Refund des vorangeg. Sale')
              ->addParam('merchantReconciliationReferenceNumber','7892-3873428')
              ->addParam('reference', $strReference)

              //the hash field is auto generated by the SDK
              ->submit();

      echo "<pre>"; print_r($request->getResponseRaw()); echo "</pre><br/>";

      /* if transaction succeeded update your local system an redirect the customer */
      if($request->requestHasSucceeded()) {
        $request->getResponseParam('rc');
        $request->getResponseParam('msg');
        $request->getResponseParam('reference');
        $request->getResponseParam('resultPayment');

        $request->redirectCustomerToPaymentProvider();
      }

      /* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
      else {
        $request->getResponseParam('rc');
        $request->getResponseParam('msg');
        $request->getResponseMessage($request->getResponseParam('rc'),'DE');
      }
    }
    catch (Exception $e) { echo $e->getMessage(); }
  }
}