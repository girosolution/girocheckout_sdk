<?php
namespace girosolution\GiroCheckout_SDK\api\giropay;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for an giropay API call.
 *
 * @package GiroCheckout
 * @version $Revision: 239 $ / $Date: 2018-07-04 10:58:55 -0400 (Wed, 04 Jul 2018) $
 */

class GiroCheckout_SDK_GiropayTransaction extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_GIROPAY_TRANSACTION;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(
        'merchantId'=> TRUE,
        'projectId' => TRUE,
        'giropayMerchantId' => FALSE,
        'merchantTxId' => TRUE,
        'amount' => TRUE,
        'currency' => TRUE,
        'purpose' => TRUE,
        'shoppingCartType'                     => FALSE,
        'shippingAddresseFirstName'            => FALSE, // nur bei PHYSICAL, MIXED und DIGITAL Pflicht
        'shippingAddresseLastName'             => FALSE, // nur bei PHYSICAL, MIXED und DIGITAL Pflicht
        'shippingCompany'                      => FALSE,
        'shippingAdditionalAddressInformation' => FALSE,
        'shippingStreet'                       => FALSE,
        'shippingStreetNumber'                 => FALSE,
        'shippingZipCode'                      => FALSE,  // nur bei PHYSICAL und MIXED Pflicht
        'shippingCity'                         => FALSE,  // nur bei PHYSICAL und MIXED Pflicht
        'shippingCountry'                      => FALSE,  // nur bei PHYSICAL und MIXED Pflicht
        'shippingEmail'                        => FALSE,  // nur bei DIGITAL Pflicht
        'merchantOrderReferenceNumber'         => FALSE,
        'cart'                                 => FALSE,
        'deliveryType'                         => FALSE,
        'bic' => FALSE,
        'iban' => FALSE,
        'info1Label' => FALSE,
        'info1Text' => FALSE,
        'info2Label' => FALSE,
        'info2Text' => FALSE,
        'info3Label' => FALSE,
        'info3Text' => FALSE,
        'info4Label' => FALSE,
        'info4Text' => FALSE,
        'info5Label' => FALSE,
        'info5Text' => FALSE,
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
        'gcResultAVS' => FALSE,
        'gcObvName' => FALSE,
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