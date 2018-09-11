<?php
use girosolution\girocheckout_SDK\GiroCheckout_SDK_Config;

/**
 * GiroCheckout SDK.
 *
 * Include just this file. It will load any required files to use the SDK.
 * View examples for API calls.
 *
 * @package GiroCheckout
 * @version $Revision: 246 $ / $Date: 2018-08-16 17:13:06 -0300 (Thu, 16 Aug 2018) $
 */
define('__GIROCHECKOUT_SDK_VERSION__', '2.1.22');

require __DIR__ . '/../vendor/autoload.php';

if( defined('__GIROCHECKOUT_SDK_DEBUG__') && __GIROCHECKOUT_SDK_DEBUG__ === TRUE ) {
  GiroCheckout_SDK_Config::getInstance()->setConfig('DEBUG_MODE',TRUE);
}
