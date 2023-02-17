<?php
/**
 * sample code for GiroCheckout integration of an apple pay transaction
 *
 * @filesource
 * @package Samples
 * @version $Revision$ / $Date$
 */

define('__GIROCHECKOUT_SDK_DEBUG__',true);

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

//Example for an apple payment token
$applePaymentToken = '
{
    "paymentData": {
        "data": "vnQNbf7eW1FwLE4HqEAfjb2NZDnByHn8gaV\/OTdRdPZqS6qTk1Z03JEeHTTyah\/WQ5ZPdW4glcp8iae0ZIfaPBThWuGYN5jkSLn+OPQKdVnSpLqP7DH6UzoAqmK3PW22GQpBTBXa0\/HEhZvxVSsgPM\/m8e16Wy8dU66mk7bwndI\/jrgvSCfuwbExCQxD2w7OJLRgR6snBDeoeWHNngzf4ezvxujsS0vioxujtTEUEN2DfkjCrGNMXNrOsleYRfftjloqRTlkVg7N4OPuJEHmUIBQvQlBFULisuEj3hGXFL1CmOIfrIkrKOshlj0leZn4MO0EGK5wSugu6Q1q1gaED2yuUfw0VpZm3E9tq76eI9OlSi9aJgauANW2ulhiazJ335W1yVoPi4dhtao=",
        "signature": "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\/JJxE+T5O8n5sT2KGw\/orv9LkswDwYDVR0TAQH\/BAUwAwEB\/zAfBgNVHSMEGDAWgBS7sN6hWDOImqSKmd6+veuv2sskqzA3BgNVHR8EMDAuMCygKqAohiZodHRwOi8vY3JsLmFwcGxlLmNvbS9hcHBsZXJvb3RjYWczLmNybDAOBgNVHQ8BAf8EBAMCAQYwEAYKKoZIhvdjZAYCDgQCBQAwCgYIKoZIzj0EAwIDZwAwZAIwOs9yg1EWmbGG+zXDVspiv\/QX7dkPdU2ijr7xnIFeQreJ+Jj3m1mfmNVBDY+d6cL+AjAyLdVEIbCjBXdsXfM4O5Bn\/Rd8LCFtlk\/GcmmCEm9U+Hp9G5nLmwmJIWEGmQ8Jkh0AADGCAYgwggGEAgEBMIGGMHoxLjAsBgNVBAMMJUFwcGxlIEFwcGxpY2F0aW9uIEludGVncmF0aW9uIENBIC0gRzMxJjAkBgNVBAsMHUFwcGxlIENlcnRpZmljYXRpb24gQXV0aG9yaXR5MRMwEQYDVQQKDApBcHBsZSBJbmMuMQswCQYDVQQGEwJVUwIITDBBSVGdVDYwCwYJYIZIAWUDBAIBoIGTMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTIyMTEzMDA4MzY0OFowKAYJKoZIhvcNAQk0MRswGTALBglghkgBZQMEAgGhCgYIKoZIzj0EAwIwLwYJKoZIhvcNAQkEMSIEICfv50Aeug4ao6vIVVnhR8M22djEVaXOJOSxg+09UjdXMAoGCCqGSM49BAMCBEcwRQIhAJPygzIkEHDcUzrFE8E5W4QN\/Iic4AnuqudL9BHQAhc0AiAXO47Z1wCPCIz2diJsrsEXr6G7sD4DcL5IG3Zi8qnVKQAAAAAAAA==",
        "header": {
            "publicKeyHash": "TNLwqrqldCvofQTxWGmOCecN5AT\/yRjUv1IRX0\/D3DQ=",
            "ephemeralPublicKey": "MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEQZ9MdPM9QVF0BFVV84\/cFl0AKZX5ixn6gonvwvPY902Q6YTVXLg\/Wv4DoCyuf8DKAp\/imSrzKEASAto5b7pFeQ==",
            "transactionId": "708ef3d74785200a95ac7a45538be41dbb90d221d90a0500b8d1ede77300da68"
        },
        "version": "EC_v1"
    },
    "paymentMethod": {
        "displayName": "MasterCard 4222",
        "network": "MasterCard",
        "type": "debit"
    },
    "transactionIdentifier": "708EF3D74785200A95AC7A45538BE41DBB90D221D90A0500B8D1EDE77300DA68"
}
';

$applePaymentToken = base64_encode($applePaymentToken);

try {
	$request = new GiroCheckout_SDK_Request( GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_APPLE_PAY_TRANSACTION);
	$request->setSecret($projectPassword);
	$request->addParam('merchantId',$merchantID)
	        ->addParam('projectId',$projectID)
	        ->addParam('merchantTxId',1234567890)
	        ->addParam('amount',100)
	        ->addParam('currency','EUR')
	        ->addParam('type','SALE')
	        ->addParam('purpose','Beispieltransaktion')
	        ->addParam('urlRedirect','https://www.my-domain.de/girocheckout/redirect-creditcard')
	        ->addParam('urlNotify','https://www.my-domain.de/girocheckout/redirect-creditcard')
	        ->addParam('applePaymentToken',$applePaymentToken)
	        ->submit();

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
	   $request->getResponseMessage($request->getResponseParam('rc'),'DE');
	}
}
catch (Exception $e) { echo $e->getMessage(); }