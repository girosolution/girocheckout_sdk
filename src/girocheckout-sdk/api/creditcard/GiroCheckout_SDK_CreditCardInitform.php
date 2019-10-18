<?php
namespace girosolution\GiroCheckout_SDK\api\creditcard;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for a credit card initform API call.
 *
 * @package GiroCheckout
 */

class GiroCheckout_SDK_CreditCardInitform extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROCREDITCARD;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_CREDITCARD_INITFORM;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(
      'merchantId'      => TRUE,
      'projectId'       => TRUE,
      'merchantTxId'    => TRUE,
      'amount'          => TRUE,
      'currency'        => FALSE,
      'purpose'         => TRUE,
      'type'            => FALSE,
      'locale'          => FALSE,
      'mobile'          => FALSE,
      'indicator'       => FALSE,
      'urlRedirect'     => TRUE,
      'urlNotify'       => TRUE,
      'pptoken'         => FALSE,
    );

    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array(
        'rc'=> TRUE,
        'msg' => TRUE,
        'reference' => FALSE,
        'clientSession' => FALSE,
        'clientConfiguration' => FALSE,
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
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/creditcard/initform";

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