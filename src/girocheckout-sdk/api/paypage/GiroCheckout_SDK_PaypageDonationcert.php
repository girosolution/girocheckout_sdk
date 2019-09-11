<?php
namespace girosolution\GiroCheckout_SDK\api\paypage;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_InterfaceApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Received the data for the donation certificate (Spendenbescheinigung) related to a recente donation.
 *
 * @package GiroCheckout
 * @version $Revision: 269 $ / $Date: 2019-08-21 13:19:42 -0400 (Wed, 21 Aug 2019) $
 */

class GiroCheckout_SDK_PaypageDonationcert extends GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_PAYPAGE;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_PAYPAGE_DONATIONCERT;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information see the API documentation.
     */
    protected $paramFields = array(
      'merchantId'      => TRUE,
      'projectId'       => TRUE,
      'reference'       => TRUE,  // Reference (UUID) to related transaction
      'company'         => FALSE,
      'lastname'        => TRUE,
      'firstname'       => TRUE,
      'address'         => TRUE,
      'zip'             => TRUE,
      'city'            => TRUE,
      'country'         => TRUE,
      'email'           => TRUE,
    );

    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array(
        'rc'=> TRUE,
        'msg' => TRUE,
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
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/paypage/setdonationcert";

    /*
     * If true the request method needs a notify page to receive the transactions result.
     */
    protected $hasNotifyURL = FALSE;

    /*
     * If true the request method needs a redirect page where the customer is sent back to the merchant.
     */
    protected $hasRedirectURL = FALSE;
}