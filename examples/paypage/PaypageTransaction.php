<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * Sample code for GiroCheckout integration of a transaction through the GS Paypage
 *
 * @filesource
 * @package Samples
 * @version $Revision: 109 $ / $Date: 2015-06-01 13:37:30 +0200 (Mo, 01 Jun 2015) $
 */
require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;

/**
 * configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 0;        // Your merchant ID (Verkaufer-ID)
$projectID = 0;         // Your project ID (Projekt-ID)
$projectPassword = "";  // Your project password

/* init giropay transaction and parameters */
try {
  
	$request = new GiroCheckout_SDK_Request('paypageTransaction');
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('merchantTxId',"123456")
	        ->addParam('amount',500)
	        ->addParam('currency','EUR')
	        ->addParam('purpose','Zweck')
          ->addParam('type', 'SALE')
	        ->addParam('description','Unser Produkt')
	        ->addParam('locale','de')
	        ->addParam('test',1)
          ->addParam('successUrl','https://www.my-domain.de/girocheckout/success.php')
          ->addParam('backUrl',   'https://www.my-domain.de/girocheckout/back.php')
          ->addParam('failUrl',   'https://www.my-domain.de/girocheckout/fail.php')
          ->addParam('notifyUrl','')

	        //the hash field is auto generated by the SDK
	        ->submit();
  
  //echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";

  
	/* if transaction succeeded update your local system and redirect the customer */
	if($request->requestHasSucceeded()) {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseParam('reference');
    $request->getResponseParam('url');

    $request->redirectCustomerToPaymentProvider();
	}
	
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseMessage($request->getResponseParam('rc'),'DE');
    
    echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";
	}
}
catch (Exception $e) { echo $e->getMessage(); }