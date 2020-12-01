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
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Tools;

/**
 * configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 1;        // Your merchant ID (Verkaufer-ID)
$projectID = 2;         // Your project ID (Projekt-ID)
$projectPassword = "3";  // Your project password

$paymentMethodToTest = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_CREDITCARD_TRANSACTION;

$strErrInfo = '';
$bIsValid = GiroCheckout_SDK_Tools::testApiCredentials( $paymentMethodToTest, $merchantID, $projectID, $projectPassword, $strErrInfo );

echo "Credentials are <br>" . ($bIsValid ? "VALID" : "NOT VALID") . "<br>";

if( !$bIsValid ) {
  echo "Error Info: $strErrInfo<br>";
}
