<?php
namespace girosolution\GiroCheckout_SDK\api\paypage;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for a Paypage API call.
 *
 * @package GiroCheckout
 * @version $Revision: 24 $ / $Date: 2014-05-22 14:30:12 +0200 (Do, 22 Mai 2014) $
 */

class GiroCheckout_SDK_PaypageTransaction extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_PAYPAGE;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_PAYPAGE_TRANSACTION;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(
        'merchantId'=> TRUE,
        'projectId' => TRUE,
        'merchantTxId' => TRUE,
        'amount' => FALSE,
        'currency' => TRUE,
        'purpose' => TRUE,
        'description' => FALSE,
        'pagetype' => FALSE,
        'expirydate' => FALSE,
        'single' => FALSE,
        'timeout' => FALSE,
        'type' => FALSE,
        'locale' => 'de',
        'paymethods' => FALSE,
        'payprojects' => FALSE,
        'organization' => FALSE,
        'freeamount' => FALSE,
        'fixedvalues' => FALSE,
        'minamount' => FALSE,
        'maxamount' => FALSE,
        'orderid' => FALSE,
        'projectlist' => FALSE,
        'pkn' => FALSE,
        'test' => TRUE,
        'certdata' => FALSE,
        'otherpayments' => FALSE,
        'paydirektShoppingCartType' => FALSE,
        'paydirektShippingFirstName' => FALSE,
        'paydirektShippingLastName' => FALSE,
        'paydirektShippingCompany' => FALSE,
        'paydirektShippingAdditionalAddressInformation' => FALSE,
        'paydirektShippingStreet' => FALSE,
        'paydirektShippingStreetNumber' => FALSE,
        'paydirektShippingZipCode' => FALSE,
        'paydirektShippingCity' => FALSE,
        'paydirektShippingCountry' => FALSE,
        'paydirektShippingEmail' => FALSE,
        'paydirektMerchantOrderReferenceNumber'=> FALSE,
        'paydirektCart' => FALSE,
        'paydirektDeliveryType' => FALSE,
        'successUrl' => FALSE,
        'backUrl' => FALSE,
        'failUrl' => FALSE,
        'notifyUrl' => FALSE,
        'tds2Address'     => FALSE,
        'tds2Postcode'    => FALSE,
        'tds2City'        => FALSE,
        'tds2Country'     => FALSE,
        'tds2Optional'    => FALSE,
        'mandateReference' => FALSE,
        'mandateSignedOn' => FALSE,
        'mandateReceiverName' => FALSE,
        'mandateSequence' => FALSE,
        'informationText' => FALSE,
        'kassenzeichen'   => FALSE,
        'paydirektAllowMissingFields' => FALSE,
        'qrcodeReturn' => FALSE,
        'billingAddress' => FALSE, // JSON: email, postalCode, anrede, firstName, lastName, companyName, street, street2, city, state, country, phone
        'shippingAddress' => FALSE, // Same as billing
        'customerInfo' => FALSE, // JSON: customerId, anrede, dateOfBirth, gender, personalId (type, id, issuedby), contacts
        'basket' => FALSE,
    );

    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array(
        'rc'=> TRUE,
        'msg' => TRUE,
        'reference' => FALSE,
        'url' => FALSE,
        'qrcode' => FALSE,
    );

    /*
     * Includes any notify parameter of the API.
     */
    protected $notifyFields = array(
        'gcPaymethod'=> TRUE,
        'gcType'=> TRUE,
        'gcProjectId'=> TRUE,
        'gcReference'=> TRUE,
        'gcMerchantTxId' => TRUE,
        'gcBackendTxId' => TRUE,
        'gcAmount' => TRUE,
        'gcCurrency' => TRUE,
        'gcResultPayment' => TRUE,
        'gcPkn' => FALSE,
        'gcCardnumber' => FALSE,
        'gcCardExpDate' => FALSE,
        'gcAccountHolder' => FALSE,
        'gcIban' => FALSE,
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
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/paypage/init";

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