<?php
namespace girosolution\GiroCheckout_SDK\api\googlepay;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for a Google pay transaction API call.
 *
 * @package GiroCheckout
 */
class GiroCheckout_SDK_GooglePayFormTransaction extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GOOGLE_PAY;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_GOOGLE_PAY_FORM_TRANSACTION;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(
        'merchantId'        => TRUE,
        'projectId'         => TRUE,
        'merchantTxId'      => TRUE,
        'amount'            => FALSE,
        'currency'          => TRUE,
        'purpose'           => FALSE,
        'type'              => 'SALE',
        'urlRedirect'       => TRUE,
        'urlNotify'         => TRUE,
        'billingAddress'    => FALSE, // JSON: email, postalCode, anrede, firstName, lastName, companyName, street, street2, city, state, country, phone
        'shippingAddress'   => FALSE, // Same as billing
        'customerInfo'      => FALSE, // JSON: customerId, anrede, dateOfBirth, gender, personalId (type, id, issuedby), contacts
        'basket'            => TRUE,
        'kassenzeichen'     => FALSE,
        'pptoken'           => FALSE,
    );

    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array(
        'rc'=> TRUE,
        'msg' => TRUE,
        'reference' => FALSE,
        'merchantTxId' => FALSE,
        'backendTxId' => FALSE,
        'amount' => FALSE,
        'currency' => FALSE,
        'resultPayment' => FALSE,
        'ppredirect' => FALSE,
        'redirect' => FALSE,
        'paymethod' => FALSE,
    );

    /*
     * Includes any notify parameter of the API.
     */
    protected $notifyFields = array(
        'gcReference'=> TRUE,
        'gcMerchantTxId' => TRUE,
        'gcBackendTxId' => TRUE,
        'gcAmount' => TRUE,
        'gcCurrency' => TRUE,
        'gcResultPayment' => TRUE,
        'gcHash' => TRUE,
    );

    /*
     * True if a hash is needed. It will be automatically added to the post data.
     */
    protected $needsHash = TRUE;

    /*
     * The field name in which the hash is sent to the notify or redirect page.
     */
    protected $notifyHashName = 'gcHash';

    /*
     * The request url of the GiroCheckout API for this request.
     */
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/transaction/start";

    /*
     * If true the request method needs a notify page to receive the transactions result.
     */
    protected $hasNotifyURL = TRUE;

    /*
     * If true the request method needs a redirect page where the customer is sent back to the merchant.
     */
    protected $hasRedirectURL = TRUE;

    /*
     * The result code number of a successful transaction
     */
    protected $paymentSuccessfulCode = 4000;
}