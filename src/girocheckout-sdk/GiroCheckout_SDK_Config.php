<?php

namespace girosolution\GiroCheckout_SDK;

if (defined('__GIROCHECKOUT_SDK_DEBUG__') && __GIROCHECKOUT_SDK_DEBUG__ === TRUE) {
  GiroCheckout_SDK_Config::getInstance()->setConfig('DEBUG_MODE', TRUE);
}

/**
 * Loads GiroCheckout SDK Config
 *
 * @package GiroCheckout
 * @version $Revision: 106 $ / $Date: 2015-05-05 11:57:59 +0200 (Di, 05 Mai 2015) $
 */
class GiroCheckout_SDK_Config
{
  static private $instance = null;
  private $config = null;

  const FTG_SERVICES_PAYMENT_METHOD_EPS = 2;
  const FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT = 6;
  const FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT_CHECKED = 7;
  const FTG_SERVICES_PAYMENT_METHOD_GIRODIRECTDEBIT_GUARANTEE = 8;

  const FTG_SERVICES_PAYMENT_METHOD_GIROCREDITCARD = 11;
  const FTG_SERVICES_PAYMENT_METHOD_IDEAL = 12;
  const FTG_SERVICES_PAYMENT_METHOD_PAYPAL = 14;
  const FTG_SERVICES_PAYMENT_METHOD_GIROCODEEPC_BASIC = 24;
  const FTG_SERVICES_PAYMENT_METHOD_BLUECODE = 26;
  const FTG_SERVICES_PAYMENT_METHOD_PAYPAGE = 32;
  const FTG_SERVICES_PAYMENT_METHOD_MAESTRO = 33;
  const FTG_SERVICES_PAYMENT_METHOD_APPLE_PAY = 36;
  const FTG_SERVICES_PAYMENT_METHOD_DIREKTUBW = 37;
  const FTG_SERVICES_PAYMENT_METHOD_KLARNA = 38;
  const FTG_SERVICES_PAYMENT_METHOD_GOOGLE_PAY = 39;
  const FTG_SERVICES_PAYMENT_METHOD_WERO = 40;
  const FTG_SERVICES_PAYMENT_METHOD_INTERNAL = 255;

  /**
   * This function stores and returns the current library version.
   * @return string Version number of GiroCheckout SDK
   */
  static public function getVersion() {
    return '2.6.8';
  }

  static public function getInstance() {
    if (null === self::$instance) {
      self::$instance = new self;

      // Set default values
      self::$instance->setConfig('CURLOPT_CAINFO', null);
      self::$instance->setConfig('CURLOPT_SSL_VERIFYPEER', TRUE);
      self::$instance->setConfig('CURLOPT_SSL_VERIFYHOST', 2);
      self::$instance->setConfig('CURLOPT_CONNECTTIMEOUT', 15);

      // Optional proxy parameters
      self::$instance->setConfig('CURLOPT_PROXY', null);
      self::$instance->setConfig('CURLOPT_PROXYPORT', null);
      self::$instance->setConfig('CURLOPT_PROXYUSERPWD', null);

      // Debug mode and log
      self::$instance->setConfig('DEBUG_MODE', FALSE);
      self::$instance->setConfig('DEBUG_LOG_PATH', dirname(__FILE__) . '/log');
    }
    return self::$instance;
  }

  private function __construct() {
  }

  private function __clone() {
  }

  /** Getter for config values
   *
   * @param $key
   * @return null
   */
  public function getConfig($key) {
    if (isset($this->config[$key])) {
      return $this->config[$key];
    }
    return null;
  }

  /** Setter for config values
   *
   * @param $key
   * @param $value
   * @return bool
   */
  public function setConfig($key, $value) {

    switch ($key) {
      //curl options
      case 'CURLOPT_CAINFO':
      case 'CURLOPT_SSL_VERIFYPEER':
      case 'CURLOPT_SSL_VERIFYHOST':
      case 'CURLOPT_CONNECTTIMEOUT':

        // Proxy
      case 'CURLOPT_PROXY':
      case 'CURLOPT_PROXYPORT':
      case 'CURLOPT_PROXYUSERPWD':

        // Debug
      case 'DEBUG_LOG_PATH':
      case 'DEBUG_MODE':
        $this->config[$key] = $value;
        return true;
        break;

      default:
        return false;
    }
  }

}