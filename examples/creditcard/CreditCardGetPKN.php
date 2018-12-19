<?php
/**
 * sample code for GiroCheckout integration of a credit card transaction
 *
 * @filesource
 * @package Samples
 * @version $Revision: 156 $ / $Date: 2016-06-29 14:17:03 -0300 (Mi, 29 Jun 2016) $
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

/* get pkn number from GiroConnect */
try {
	$request = new GiroCheckout_SDK_Request('creditCardGetPKN');
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('reference','22912e6e-2e50-4d8f-a0ae-25a71a0a64df')
	    //the hash field is auto generated by the SDK
	        ->submit();
	
	/* if transaction succeeded update your local system an redirect the customer */
	if($request->requestHasSucceeded())	{
    $request->getResponseParam('reference');
    $request->getResponseParam('pkn');
    $request->getResponseParam('cardnumber');
    $request->getResponseParam('expiremonth');
    $request->getResponseParam('expireyear');
	}	
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
	  $request->getResponseParam('rc');
	  $request->getResponseParam('msg');
	  $request->getResponseMessage($request->getResponseParam('rc'),'DE');
	}
}
catch (Exception $e) { echo $e->getMessage(); }