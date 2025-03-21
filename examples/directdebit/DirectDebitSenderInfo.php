<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * Sample code for GiroCheckout integration of a direct debit senderinfo call.
 *
 * @filesource
 * @package Samples
 * @version $Revision: 274 $ / $Date: 2019-09-06 14:04:44 -0400 (Fri, 06 Sep 2019) $
 */
require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

// Specify reference number to use in call
$reference = '91984284-b4b3-47eb-aed7-bb257e2acbb8';

/**
 * configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 0;        // Your merchant ID (Verkaufer-ID)
$projectID = 0;         // Your project ID (Projekt-ID)
$projectPassword = "";  // Your project password

/* directdebit senderinfo transaction and parameters */
try {
	$request = new GiroCheckout_SDK_Request( GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_DIRECTDEBIT_SENDERINFO );
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('reference',$reference)
	    //the hash field is auto generated by the SDK
	        ->submit();

  echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";
  
	/* if request was successful, inform customer */
  if($request->requestHasSucceeded()) {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseParam('accountholder');
    $request->getResponseParam('bic');
    $request->getResponseParam('iban');
	}
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseMessage($request->getResponseParam('rc'),'DE');
	}
}
catch (Exception $e) { echo $e->getMessage(); }