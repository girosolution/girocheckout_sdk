<?php
/**
 * Sample code for GiroCheckout integration of getting a reference for a
 * GiroCode Payment transaction
 *
 * @filesource
 * @package Samples
 * @version $Revision: 73 $ / $Date: 2014-10-01 17:40:24 +0200 (Mi, 01 Okt 2014) $
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

/* get a reference for a GiroCode Payment transaction */
try {
	$request = new GiroCheckout_SDK_Request('giroCodeGetEpc');
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('girocodereference', 'G5UHC64819')
	        ->addParam('format', 'epc-qr-optimizied')
	        ->addParam('resolution', 300)
	    //the hash field is auto generated by the SDK
	        ->submit();

	/* if transaction succeeded  */
	if($request->requestHasSucceeded()) {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseParam('girocodereference');
    $img = imagecreatefromstring(base64_decode($request->getResponseParam('image')));
    // Header("Content-type: image/png");
    // ImagePng($img);
    // ImageDestroy($img);
    // $request->getResponseParam('url');
	}
	/* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
	else {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseMessage($request->getResponseParam('rc'),'DE');
	}
}
catch (Exception $e) { echo $e->getMessage(); }