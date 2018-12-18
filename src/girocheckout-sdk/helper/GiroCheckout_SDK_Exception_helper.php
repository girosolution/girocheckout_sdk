<?php
namespace girosolution\GiroCheckout_SDK\helper;

use girosolution\girocheckout_SDK\GiroCheckout_SDK_Config;

/**
 * Class GiroCheckout_SDK_Exception_helper
 * @package girosolution\GiroCheckout_SDK\helper
 */
class GiroCheckout_SDK_Exception_helper extends \Exception {

  /**
   * GiroCheckout_SDK_Exception_helper constructor.
   * @param string $message Error message
   * @param int $code Error code
   */
	public function __construct($message = null, $code = 0) {
    $Config = GiroCheckout_SDK_Config::getInstance();

    if ($Config->getConfig('DEBUG_MODE')) {
      GiroCheckout_SDK_Debug_helper::getInstance()->LogException($message);
    }

		parent::__construct($message, $code);
	}
}