<?php
namespace girosolution\GiroCheckout_SDK\api;

use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Config;

/**
 * Abstract API class for all GiroCheckout API calls.
 * Provides most of the interfaces functions. A new payment method should use this class.
 *
 * @package GiroCheckout
 * @version $Revision: 174 $ / $Date: 2016-11-09 16:44:31 -0300 (Wed, 09 Nov 2016) $
 */
class GiroCheckout_SDK_AbstractApi implements GiroCheckout_SDK_InterfaceApi {

  protected $requestURL;
  protected $paramFields;
  protected $responseFields;
  protected $notifyFields;
  protected $needsHash;
  protected $hasNotifyURL;
  protected $hasRedirectURL;
  protected $paymentSuccessfulCode;
  protected $avsSuccessfulCode;
  protected $notifyHashName;

  protected $m_iPayMethod;  // ID that identifies payment method (only used to select correct logo)
  protected $m_strTransType;  // String that identifies the specific transaction type

  /**
   * For development use only
   */
  function __construct() {
    try {
      if ((function_exists('apache_getenv') && strlen(apache_getenv('GIROCHECKOUT_SERVER'))) ||
        (getenv('GIROCHECKOUT_SERVER'))
      ) {
        $url = parse_url($this->requestURL);

        if (function_exists('apache_getenv') && strlen(apache_getenv('GIROCHECKOUT_SERVER'))) {
          $this->requestURL = apache_getenv('GIROCHECKOUT_SERVER') . $url['path'];
        }
        else {
          $this->requestURL = getenv('GIROCHECKOUT_SERVER') . $url['path'];
        }
      }
    }
    catch (\Exception $e) {
    }
  }

  /**
   * Checks if the param exists. Check is case sensitive.
   *
   * @param String $param
   * @return boolean true if param exists
   */
  public function hasParam($paramName) {
    if (isset($this->paramFields[$paramName])) {
      return true;
    }
    elseif ('sourceId' === $paramName) {
      return true;
    } //default field due to support issues
    elseif ('userAgent' === $paramName) {
      return true;
    } //default field due to support issues
    elseif ('orderId' === $paramName) {
      return true;
    } //default field due to support issues
    elseif ('customerId' === $paramName) {
      return true;
    } //default field due to support issues
    return false;
  }

  /**
   * Returns all API call param fields in the correct order.
   * Complains if a mandatory field is not present or empty.
   *
   * @param mixed[] $params
   * @return mixed[] $submitParams
   * @throws \Exception if one of the mandatory fields is not set
   */
  public function getSubmitParams($params) {

    $submitParams = array();
    foreach ($this->paramFields as $k => $mandatory) {
      if (isset($params[$k]) && strlen($params[$k]) > 0) {
        $submitParams[$k] = $params[$k];
      }
      elseif ((!isset($params[$k]) || strlen($params[$k]) == 0) && $mandatory === TRUE) {
        throw new \Exception('mandatory field ' . $k . ' is unset or empty');
      }
    }

    return $submitParams;
  }

  /**
   * Returns all response param fields in the correct order.
   *
   * @param mixed $response
   * @return mixed|boolean $responseParams
   * @throws \Exception if one of the mandatory fields is not set
   */
  public function checkResponse($response) {
    if (!is_array($response)) {
      return FALSE;
    }

    $responseParams = array();
    foreach ($this->responseFields as $k => $mandatory) {
      if (isset($response[$k])) {
        $responseParams[$k] = $response[$k];
      }
      elseif (!isset($response[$k]) && $mandatory) {
        throw new \Exception('expected response field ' . $k . ' is missing');
      }
    }

    return $responseParams;
  }

  /**
   * Returns all notify param fields in the correct order.
   *
   * @param mixed $notify
   * @return mixed|boolean $notifyParams
   * @throws \Exception if one of the mandatory fields is not set
   */
  public function checkNotification($notify) {
    if (!is_array($notify)) {
      return FALSE;
    }

    $notifyParams = array();
    foreach ($this->notifyFields as $k => $mandatory) {
      if (isset($notify[$k])) {
        $notifyParams[$k] = $notify[$k];
      }
      elseif (!isset($notify[$k]) && $mandatory) {
        throw new \Exception('expected notification field ' . $k . ' is missing');
      }
    }

    return $notifyParams;
  }

  /**
   * Returns true if a hash has to be added to the API call.
   *
   * @return boolean
   */
  public function needsHash() {
    return $this->needsHash;
  }

  /**
   * Returns the API request URL where the call has to be sent to.
   *
   * @return String requestURL
   */
  public function getRequestURL() {
    return $this->requestURL;
  }

  /**
   * Set URL to post requests to dev.girosolution.de.
   * This can be used when the method of changing the apache environment variable
   * GIROCHECKOUT_SERVER isn't applicable.
   * Call before submit.
   * @param integer $p_iServer Server to use, 0=default, 1=Prod, 2=Dev, 3=custom URL for local use (specified in 2nd parameter)
   * @param string $p_strCustServer Optional custom server to use, mostly for local testing (only if $p_iServer is 3).
   */
  public function setServer($p_iServer, $p_strCustServer = '') {
    $url = parse_url($this->requestURL);
    if ($p_iServer == 1) {
      $strSrvUrl = "https://payment.girosolution.de/";
    }
    elseif ($p_iServer == 3) {
      $strSrvUrl = $p_strCustServer;
    }
    else {
      $strSrvUrl = "https://dev.girosolution.de/";
    }

    $this->requestURL = rtrim($strSrvUrl, "/") . $url['path'];
  }

  /**
   * Returns the API needs a notify URL, where the transaction result has to be sent to.
   *
   * @return String notifyURL
   */
  public function hasNotifyURL() {
    return $this->hasNotifyURL;
  }

  /**
   * Returns if the API needs a redirect URL, where the customer has to be sent to after payment.
   *
   * @return String redirectURL
   */
  public function hasRedirectURL() {
    return $this->hasRedirectURL;
  }

  /**
   * Returns the ResultCode of an successful transaction.
   *
   * @return int/null notifyURL
   */
  public function getTransactionSuccessfulCode() {
    if (isset($this->paymentSuccessfulCode)) {
      return $this->paymentSuccessfulCode;
    }
    return NULL;
  }

  /**
   * Returns the ResultCode of an successful AVS check (age verification system).
   *
   * @return int/null notifyURL
   */
  public function getAVSSuccessfulCode() {
    if (isset($this->avsSuccessfulCode)) {
      return $this->avsSuccessfulCode;
    }
    return NULL;
  }

  /**
   * Returns the parameter name of the hash in the notify or redirect API call from GiroConnect.
   *
   * @return int/null notifyURL
   */
  public function getNotifyHashName() {
    if (isset($this->notifyHashName)) {
      return $this->notifyHashName;
    }

    return NULL;
  }

  /**
   * Returns true if the api is direct payment (without init and payment page)
   *
   * @return bool
   */
  public function isDirectPayment() {
    return isset($this->responseFields['resultPayment']);
  }

  /**
   * Do some special validations for this payment method.
   * Used only in a few, simply returns true for most.
   *
   * @param array $p_aParams Array of parameters from shop
   * @param string $p_strError [OUT] Field name in case of error
   * @return bool TRUE if ok, FALSE if validation error.
   */
  public function validateParams($p_aParams, &$p_strError) {
    $p_strError = "";
    return TRUE;
  }

  /**
   * Return the filename of the logo for this payment method.
   *
   * @param integer $p_iSize Logo size (40, 50 or 60)
   * @return string Filename or empty string if no logo available.
   */
  public function getLogoFilename( $p_iSize ) {
    if( !in_array( $p_iSize, array(40, 50, 60) ) ) {
      return "";
    }

    switch( $this->m_iPayMethod ) {
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY_AVS_PAYMENT:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY_AVS:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY_KVS:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY_INVOICE:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY_DONATE:
        return "Logo_giropay_{$p_iSize}_px.jpg";

      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_EPS:
        return "Logo_eps_{$p_iSize}_px.jpg";

      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT_CHECKED:
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT_GUARANTEE:
        return "Logo_EC_{$p_iSize}_px.png";

      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROCREDITCARD:
        return "visa_msc_amex_{$p_iSize}px.png";  // Usually better obtained through GiroCheckout_SDK_Tools::getCreditCardLogoName()

      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_IDEAL:
        return "Logo_iDeal_{$p_iSize}_px.jpg";
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_PAYPAL:
        return "Logo_paypal_{$p_iSize}_px.png";
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_PAYDIREKT:
        return "Logo_paydirekt_{$p_iSize}_px.png";
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_BLUECODE:
        return "Logo_bluecode_{$p_iSize}_px.png";
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_SOFORTUW:
        return "Logo_sofort_{$p_iSize}_px.png";
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_MAESTRO:
        return "Logo_maestro_{$p_iSize}_px.png";
      default:
        return "";
    }
  }

  /**
   * Return current payment method.
   * @return mixed
   */
  public function getPayMethod() {
    return $this->m_iPayMethod;
  }
}