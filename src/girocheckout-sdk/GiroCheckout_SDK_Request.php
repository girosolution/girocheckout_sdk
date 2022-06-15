<?php
namespace girosolution\GiroCheckout_SDK;

use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_AbstractApi;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_Debug_helper;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_Curl_helper;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_Exception_helper;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_ResponseCode_helper;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_Hash_helper;
use Exception;

/**
 * Request class which manages API calls to GiroCheckout
 *
 * how to use (see example section):
 * 1. Instantiate a new Request class and pass an api method to the constructor.
 * 2. Pass the submit params (see api documentation) and call submit().
 * 3. Use the getResponseParam to retrieve the result.
 *
 * @package GiroCheckout
 * @version $Revision: 230 $ / $Date: 2017-11-04 00:03:16 -0300 (Sat, 04 Nov 2017) $
 */
class GiroCheckout_SDK_Request {
  /**
   * Stores any committed request parameter which should be sent to GiroCheckout
   */
  private $params = Array();

  /**
   * Stores any response parameter from GiroCheckout answer
   */
  private $response = Array();

  /**
   * Stores the raw response from GiroCheckout
   */
  private $responseRaw = '';

  /**
   * Stores given secret
   */
  private $secret = '';

  /**
   * Stores the api call request method object
   * @var GiroCheckout_SDK_AbstractApi $requestMethod
   */
  private $requestMethod;

  /**
   * instantiates request
   *
   * A request method instance has to be passed (see examples section)
   *
   * @param GiroCheckout_SDK_AbstractApi/String $apiCallMethod
   * @param integer $iUseServer Server to use, 0=default, 1=Prod, 2=Dev, 3=custom URL for local use (specified in 2nd parameter)
   * @param string $strCustServer Optional custom server to use, mostly for local testing (only if $p_iServer is 3).
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function __construct($apiCallMethod, $iUseServer = 0, $strCustServer = '') {
    $Config = GiroCheckout_SDK_Config::getInstance();

    if (is_object($apiCallMethod)) {
      $this->requestMethod = $apiCallMethod;

      if ($Config->getConfig('DEBUG_MODE')) {
        $callMethod = str_replace("GiroCheckout_SDK_", '', get_class($apiCallMethod));

        GiroCheckout_SDK_Debug_helper::getInstance()->init('request-' . $callMethod);
        GiroCheckout_SDK_Debug_helper::getInstance()->logTransaction($callMethod);
      }
    }
    elseif (is_string($apiCallMethod)) {
      if ($Config->getConfig('DEBUG_MODE')) {
        GiroCheckout_SDK_Debug_helper::getInstance()->init('request-' . $apiCallMethod);
        GiroCheckout_SDK_Debug_helper::getInstance()->logTransaction($apiCallMethod);
      }

      $this->requestMethod = GiroCheckout_SDK_TransactionType_helper::getTransactionTypeByName($apiCallMethod);

      if (is_null($this->requestMethod)) {
        throw new GiroCheckout_SDK_Exception_helper('Failure: API call method unknown');
      }

      if( $iUseServer > 0 ) {
        $this->requestMethod->setServer( $iUseServer, $strCustServer );
      }
    }

    if( !function_exists("curl_exec") ) {
      throw new GiroCheckout_SDK_Exception_helper('Failure: curl_exec not available or disabled in PHP, this function is required');
    }
  }

  /**
   * Return the logo filename for the current payment method.
   *
   * @param integer $p_iSize Desired size of logo in pixels (40, 50, 60)
   * @return string Filename
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function getPaymethodLogo( $p_iSize ) {
    if (is_null($this->requestMethod)) {
      throw new GiroCheckout_SDK_Exception_helper('Failure: API call method unknown');
    }
    return $this->requestMethod->getLogoFilename( $p_iSize );
  }

  /**
   * Adds a key value pair to the params variable. Used to fill the request with data.
   *
   * @param String $param key
   * @param String $value value
   * @return GiroCheckout_SDK_Request $this own instance
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function addParam($param, $value) {

    if (!$this->requestMethod->hasParam($param)) {
      throw new GiroCheckout_SDK_Exception_helper('Failure: param "' . $param . '" not valid or misspelled. Please check API Params List.');
    }

    if ($value instanceof GiroCheckout_SDK_Request_Cart) {
      $this->params[$param] = $value->getAllItems();
    }
    else {
      $this->params[$param] = $value;
    }

    return $this;
  }

  /**
   * Removes a key value pair from the params variable.
   *
   * @param String $param key
   * @return GiroCheckout_SDK_Request $this own instance
   */
  public function unsetParam($param) {
    unset($this->params[$param]);
    return $this;
  }

  /**
   * Returns the value from the params variable by the given key.
   *
   * @param String $param key
   * @return String $value value assigned to the given key
   */
  public function getParam($param) {
    if (isset($this->params[$param])) {
      return $this->params[$param];
    }
    return null;
  }

  /**
   * Returns the value from the response of the request.
   *
   * @param String $param key
   * @return null/String $value value assigned to the given key
   */
  public function getResponseParam($param) {
    if (isset($this->response[$param])) {
      return $this->response[$param];
    }
    return null;
  }

  /**
   * Returns an array of all values from the response of the request.
   *
   * @return array Response values
   */
  public function getResponseParams() {
    return $this->response;
  }

  /**
   * Returns the raw response of the request.
   *
   * @return string Response values
   */
  public function getResponseRaw() {
    return $this->responseRaw;
  }

  /**
   * Sets the secret which is used for hash generation or hash comparison.
   *
   * @param String $secret
   * @return String $this own instance
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function setSecret($secret) {
    if( empty($secret) ) {
      throw new GiroCheckout_SDK_Exception_helper('Passed secret may not be empty');
    }
    $this->secret = $secret;
    return $this;
  }

  /**
   * Set URL to post requests to dev.girosolution.de.
   * This can be used when the method of changing the apache environment variable
   * GIROCHECKOUT_SERVER isn't applicable.
   * Call before submit.
   * @param integer $p_iServer Server to use, 0=default, 1=Prod, 2=Dev, 3=custom URL for local use (specified in 2nd parameter)
   * @param string $p_strCustServer Optional custom server to use, mostly for local testing (only if $p_iServer is 3).
   */
  public function setServer( $p_iServer, $p_strCustServer = '' ) {
    $this->requestMethod->setServer($p_iServer, $p_strCustServer);
  }

  /**
   * Submits the request to the GiroCheckout API by using the given request method. Uses all given and needed
   * params in the correct order.
   *
   * @return boolean
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function submit() {
    $Config = GiroCheckout_SDK_Config::getInstance();

    if ($Config->getConfig('DEBUG_MODE')) {
      GiroCheckout_SDK_Debug_helper::getInstance()->logParamsSet($this->params);
    }

    if( empty($this->secret) ) {
      throw new GiroCheckout_SDK_Exception_helper('Secret may not be empty');
    }

    try {
      $submitParams = $this->requestMethod->getSubmitParams($this->params);

      // Some special validations
      $strError = "";
      if( !$this->requestMethod->validateParams( $submitParams, $strError ) ) {
        throw new GiroCheckout_SDK_Exception_helper('Paydirekt parameter error: '. $strError);
      }

      if ($this->requestMethod->needsHash()) {
        $submitParams['hash'] = GiroCheckout_SDK_Hash_helper::getHMACMD5Hash($this->secret, $submitParams);
      }

      $submitParams['sourceId'] = $this->getHostSourceId() . ';' . $this->getSDKSourceId() . ';';

      if (isset($this->params['sourceId'])) {
        $submitParams['sourceId'] .= $this->params['sourceId'];
      }
      else {
        $submitParams['sourceId'] .= ';';
      }

      // Send additional info fields for support reasons
      if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $submitParams['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
      }
      if (isset($this->params['orderId'])) {
        $submitParams['orderId'] = $this->params['orderId'];
      }
      if (isset($this->params['customerId'])) {
        $submitParams['customerId'] = $this->params['customerId'];
      }

      list($header, $body) = GiroCheckout_SDK_Curl_helper::submit($this->requestMethod->getRequestURL(), $submitParams);
      $this->responseRaw = print_r($header, TRUE) . "\n$body";

      $reqResponse = GiroCheckout_SDK_Curl_helper::getJSONResponseToArray($body);

      if ($reqResponse['rc'] == 5000 || $reqResponse['rc'] == 5001) {
        throw new GiroCheckout_SDK_Exception_helper('Authentication failure, please double-check your project settings', $reqResponse['rc'] );
      }
      elseif (!isset($header['hash'])) {
        throw new GiroCheckout_SDK_Exception_helper('Hash in response is missing', 5002);
      }
      elseif (isset($header['hash']) && $header['hash'] !== GiroCheckout_SDK_Hash_helper::getHMACMD5HashString($this->secret, $body)) {
        throw new GiroCheckout_SDK_Exception_helper('Hash mismatch in response', 5002);
      }
      else {
        $this->response = $this->requestMethod->checkResponse($reqResponse);
        if ($Config->getConfig('DEBUG_MODE')) {
          GiroCheckout_SDK_Debug_helper::getInstance()->logReplyParams($this->response);
        }
      }
    }
    catch (Exception $e) {
      if ($e instanceof GiroCheckout_SDK_Exception_helper) {
         throw $e;
      }
      else {
        throw new GiroCheckout_SDK_Exception_helper( 'Failure: ' . $e->getMessage() );
      }
    }

    return TRUE;
  }


  /**
   * Validates the passed API credentials against the host using the transaction type of the current object.
   *
   * @param string $p_strMerchantId Merchant ID to test
   * @param string $p_strProjectId Project ID to test
   * @param string $p_strProjectPass Project password to test
   * @param string $p_strErrorDetails [OUT] Optionally pass variable here that is filled with the readon in case of return FALSE.
   * @return bool TRUE on successful validation, FALSE on failed validation (=wrong credentials)
   */
  public function testCredentials( $p_strMerchantId, $p_strProjectId, $p_strProjectPass, &$p_strErrorDetails = NULL ) {
    if( !is_null($p_strErrorDetails) ) {
      $p_strErrorDetails = '';
    }

    $Config = GiroCheckout_SDK_Config::getInstance();

    try {
      $this->setSecret($p_strProjectPass);

      // Set some default parameters
      $this->addParam('merchantId', $p_strMerchantId)
           ->addParam('projectId', $p_strProjectId)
           ->addParam('merchantTxId',123456330)
           ->addParam('amount',-1)  // provoke validation error
           ->addParam('currency','EUR')
           ->addParam('purpose','Credential validation')
           ->addParam('urlRedirect','http://dummy')
           ->addParam('urlNotify','http://dummy');

      if( $this->requestMethod->getPayMethod() == GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_PAYDIREKT ) {
        $this->addParam( 'orderId', 12345 );
      }

      if ($Config->getConfig('DEBUG_MODE')) {
        GiroCheckout_SDK_Debug_helper::getInstance()->logParamsSet($this->params);
      }

      $submitParams = $this->requestMethod->getSubmitParams($this->params);

      if ($this->requestMethod->needsHash()) {
        $submitParams['hash'] = GiroCheckout_SDK_Hash_helper::getHMACMD5Hash($this->secret, $submitParams);
      }

      $submitParams['sourceId'] = $this->getHostSourceId() . ';' . $this->getSDKSourceId() . ';';

      if (isset($this->params['sourceId'])) {
        $submitParams['sourceId'] .= $this->params['sourceId'];
      }
      else {
        $submitParams['sourceId'] .= ';';
      }

      // Send additional info fields for support reasons
      if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $submitParams['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
      }

      list($header, $body) = GiroCheckout_SDK_Curl_helper::submit($this->requestMethod->getRequestURL(), $submitParams);
      $this->responseRaw = print_r($header, TRUE) . "\n$body";

      $reqResponse = GiroCheckout_SDK_Curl_helper::getJSONResponseToArray($body);

      if ($reqResponse['rc'] == 5000 || $reqResponse['rc'] == 5001) {
        if( !is_null($p_strErrorDetails) ) {
          $p_strErrorDetails = 'Authentication failure, please double-check your project settings, rc=' . $reqResponse['rc'];
        }
        return FALSE;
      }
      else {
        return TRUE;
      }
    }
    catch (Exception $e) {
      if( !is_null($p_strErrorDetails) ) {
        $p_strErrorDetails = 'Exception, Failure: ' . $e->getMessage();
      }
      return FALSE;
    }
  }

  /**
   * Returns true if the request has succeeded and the response had no ErrorCode. It doesn't check if the transaction
   * or payment has succeeded.
   *
   * @return bool
   */
  public function requestHasSucceeded() {
    if (isset($this->response['rc']) && $this->response['rc'] == 0 ) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * modifies header to sent redirect location by GiroCheckout
   */
  public function redirectCustomerToPaymentProvider() {
    if (isset($this->response['redirect'])) {
      header('location:' . $this->response['redirect']);
      exit;
    }
    elseif (isset($this->response['url'])) {
      header('location:' . $this->response['url']);
      exit;
    }
  }

  /**
   * Gives response message to given code number in the given language.
   *
   * @param integer code
   * @param String language
   * @return String thee codes description in given language
   */
  public function getResponseMessage($responseCode, $lang = 'DE') {
    return GiroCheckout_SDK_ResponseCode_helper::getMessage($responseCode, $lang);
  }

  /**
   * Sets a certificate file which is used for authorising ssl connection.
   * Required for Windows environments.
   *
   * @param String filename including path
   * @return $this own instance
   * @throws GiroCheckout_SDK_Exception_helper
   */
  public function setSslCertFile($certFile) {

    if( !file_exists( $certFile ) ) {
      throw new GiroCheckout_SDK_Exception_helper( 'Certificate file not found: '. $certFile );
    }

    define('__GIROSOLUTION_SDK_CERT__', $certFile);
    return $this;
  }

  /**
   * Disables a certificate verification for ssl connections.
   * Required for Windows environments.
   *
   * @return $this own instance
   */
  public function setSslVerifyDisabled() {
    define('__GIROSOLUTION_SDK_SSL_VERIFY_OFF__', true);
    return $this;
  }

  /**
   * returns true if the payment transaction was successful
   *
   * @return boolean result of payment
   */
  public function paymentSuccessful() {
    if ($this->requestHasSucceeded() && $this->requestMethod->isDirectPayment()) {
      return $this->requestMethod->getTransactionSuccessfulCode() == $this->response['resultPayment'];
    }

    return false;
  }

  /**
   * Returns sourceId of this SDK
   *
   * @return string Version information of this SDK
   */
  public function getSDKSourceId() {
    return 'PHP ' . GiroCheckout_SDK_Config::getVersion();
  }

  /**
   * returns sourceId of the host
   *
   * @return string SourceId of the host
   */
  public function getHostSourceId() {
    if (isset($_SERVER['SERVER_NAME'])) {
      return $_SERVER['SERVER_NAME'];
    }
    return '';
  }
}