<?php

/**
 * sample code for GiroConnect integration of a response page
 *
 * @filesource
 * @package Samples
 * @version $Revision: 156 $ / $Date: 2016-06-29 14:17:03 -0300 (Mi, 29 Jun 2016) $
 */
require_once '../GiroCheckout_SDK/GiroCheckout_SDK.php';

//set the secret for hash validation of the received data
$projectPassword = "secret";

//init notification and pass transaction type, set password and parse the received data
try {
  $notify = new GiroCheckout_SDK_Notify( 'giropayTransaction' );
  $notify->setSecret( $projectPassword );

  //the array containing the parameters
  $notify->parseNotification( $_GET );

  //show the result of the transaction to the customer
  if( $notify->paymentSuccessful() ) {
    echo $notify->getResponseParam( 'gcReference' );
    echo $notify->getResponseParam( 'gcMerchantTxId' );
    echo $notify->getResponseParam( 'gcBackendTxId' );
    echo $notify->getResponseParam( 'gcAmount' );
    echo $notify->getResponseParam( 'gcCurrency' );
    echo $notify->getResponseParam( 'gcResultPayment' );
  }

  if( $notify->avsSuccessful() ) {
    echo $notify->getResponseParam( 'gcResultAVS' );
  }
}
catch (Exception $e) {
  echo $e->getMessage();
}