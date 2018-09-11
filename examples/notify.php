<?php

/**
 * sample code for GiroConnect integration of a notification page
 *
 * @filesource
 * @package Samples
 * @version $Revision: 161 $ / $Date: 2016-08-03 18:26:40 -0400 (Wed, 03 Aug 2016) $
 */
require_once '../GiroCheckout_SDK/GiroCheckout_SDK.php';

//set the secret for hash validation of the received data
$projectPassword = "secret";

//init notification and pass transaction type, set password and parse the received data
try {
  $notify = new GiroCheckout_SDK_Notify( 'giropayTransaction' );
  $notify->setSecret( $projectPassword );
  $notify->parseNotification( $_GET );

  //check response and update transaction
  if( $notify->paymentSuccessful() ) {
    $notify->getResponseParam( 'gcReference' );
    $notify->getResponseParam( 'gcMerchantTxId' );
    $notify->getResponseParam( 'gcBackendTxId' );
    $notify->getResponseParam( 'gcAmount' );
    $notify->getResponseParam( 'gcCurrency' );
    $notify->getResponseParam( 'gcResultPayment' );

    if( $notify->avsSuccessful() ) {
      $notify->getResponseParam( 'gcResultAVS' );
    }

    $notify->sendOkStatus();
    $notify->setNotifyResponseParam( 'Result', 'OK' );
    $notify->setNotifyResponseParam( 'ErrorMessage', '' );
    $notify->setNotifyResponseParam( 'MailSent', '0' );
    $notify->setNotifyResponseParam( 'OrderId', '1111' );
    $notify->setNotifyResponseParam( 'CustomerId', '2222' );
    echo $notify->getNotifyResponseStringJson();
    exit;
  }
  else {
    $notify->getResponseParam( 'gcReference' );
    $notify->getResponseParam( 'gcMerchantTxId' );
    $notify->getResponseParam( 'gcBackendTxId' );
    $notify->getResponseParam( 'gcResultPayment' );
    $notify->getResponseMessage( $notify->getResponseParam( 'gcResultPayment' ), 'DE' );

    $notify->sendOkStatus();
    $notify->setNotifyResponseParam( 'Result', 'OK' );
    $notify->setNotifyResponseParam( 'ErrorMessage', '' );
    $notify->setNotifyResponseParam( 'MailSent', '0' );
    $notify->setNotifyResponseParam( 'OrderId', '1111' );
    $notify->setNotifyResponseParam( 'CustomerId', '2222' );
    echo $notify->getNotifyResponseStringJson();
    exit;
  }
}
catch (Exception $e) {

  $notify->sendBadRequestStatus();
  $notify->setNotifyResponseParam( 'Result', 'ERROR' );
  $notify->setNotifyResponseParam( 'ErrorMessage', $e->getMessage() );
  $notify->setNotifyResponseParam( 'MailSent', '0' );
  $notify->setNotifyResponseParam( 'OrderId', '1111' );
  $notify->setNotifyResponseParam( 'CustomerId', '2222' );
  echo $notify->getNotifyResponseStringJson();
  exit;
}