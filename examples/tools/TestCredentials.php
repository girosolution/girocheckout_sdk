<?php
define('__GIROCHECKOUT_SDK_DEBUG__',true);

/**
 * Sample code for GiroCheckout integration of a tools test credentials api call
 *
 * @filesource
 * @package Samples
 * @version $Revision: 274 $ / $Date: 2019-09-06 14:04:44 -0400 (Fri, 06 Sep 2019) $
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

$paymentMethodToTest = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_CREDITCARD_TRANSACTION;

$strErrInfo = '';
$bIsValid = GiroCheckout_SDK_Tools::testApiCredentials( $paymentMethodToTest, $merchantID, $projectID, $projectPassword, $strErrInfo );

echo "Credentials are <br>" . ($bIsValid ? "VALID" : "NOT VALID") . "<br>";

if( !$bIsValid ) {
  echo "Error Info: $strErrInfo<br>";
}
