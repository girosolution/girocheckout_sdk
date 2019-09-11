<?php
namespace girosolution\GiroCheckout_SDK\api\giropay;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * Provides configuration for an iDEAL API call.
 *
 * @package GiroCheckout
 * @version $Revision: 24 $ / $Date: 2014-05-22 14:30:12 +0200 (Do, 22 Mai 2014) $
 */
class GiroCheckout_SDK_GiropayIssuerList extends GiroCheckout_SDK_AbstractApi{

    protected $m_iPayMethod = GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY;
    protected $m_strTransType = GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_GIROPAY_ISSUERLIST;

    /*
     * Includes any parameter field of the API call. True parameter are mandatory, false parameter are optional.
     * For further information use the API documentation.
     */
    protected $paramFields = array(  'merchantId'=> TRUE,
                                'projectId' => TRUE,
                            );

    /*
     * Includes any response field parameter of the API.
     */
    protected $responseFields = array('rc'=> TRUE,
                                'msg' => TRUE,
                                'issuer' => TRUE,
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
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/giropay/issuer";

    /*
     * If true the request method needs a notify page to receive the transactions result.
     */
    protected $hasNotifyURL = FALSE;

    /*
     * If true the request method needs a redirect page where the customer is sent back to the merchant.
     */
    protected $hasRedirectURL = FALSE;
}