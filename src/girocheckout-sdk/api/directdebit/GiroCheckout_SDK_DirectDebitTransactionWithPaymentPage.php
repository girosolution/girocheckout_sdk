<?php
namespace girosolution\GiroCheckout_SDK\api\directdebit;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for an direct debit API call.
 *
 * @package GiroCheckout
 * @version $Revision: 227 $ / $Date: 2017-10-19 18:29:16 -0300 (Thu, 19 Oct 2017) $
 */

class GiroCheckout_SDK_DirectDebitTransactionWithPaymentPage extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_DIRECTDEBIT_WO_PMTPGE;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(
        'merchantId'=> TRUE,
        'projectId' => TRUE,
        'merchantTxId' => TRUE,
        'amount' => TRUE,
        'currency' => TRUE,
        'purpose' => TRUE,
        'type' => FALSE,
        'locale' => FALSE,
        'mobile' => FALSE,
        'mandateReference' => FALSE,
        'mandateSignedOn' => FALSE,
        'mandateReceiverName' => FALSE,
        'mandateSequence' => FALSE,
        'pkn' => FALSE,
        'urlRedirect' => TRUE,
        'urlNotify' => TRUE,
        'kassenzeichen' => FALSE,
        'pptoken' => FALSE,
    );


    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array(
        'rc'=> TRUE,
        'msg' => TRUE,
        'reference' => FALSE,
        'mandateReference' => FALSE,
        'redirect' => FALSE,
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