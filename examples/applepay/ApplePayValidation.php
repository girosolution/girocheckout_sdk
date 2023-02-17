<?php
/**
 * @filesource
 * @package Samples
 * @version $Revision: 176 $ / $Date: 2017-01-09 13:29:27 -0300 (Mon, 09 Jan 2017) $
 */
define('__GIROCHECKOUT_SDK_DEBUG__',true);

require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 0;        // Your merchant ID (Verkaufer-ID)
$projectID = 0;         // Your project ID (Projekt-ID)
$projectPassword = "";  // Your project password


try {
    $request = new GiroCheckout_SDK_Request(GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_APPLE_PAY_VALIDATION);
    $request->setSecret($projectPassword);
    $request->addParam('merchantId', $merchantID)
        ->addParam('projectId', $projectID)
        ->addParam('merchantTxId', 1234567890)
        ->addParam('merchantIdentifier', 'merchant.de.girocockpit')
        ->addParam('domainName', 'payment.girosolution.de')
        ->addParam('displayName', 'Beispieltransaktion')
        ->submit();

    /* if request is succeeded you get an apple session object */
    if ($request->requestHasSucceeded()) {
        $request->getResponseParam('sessionObject');
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
