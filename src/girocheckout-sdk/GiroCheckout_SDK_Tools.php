<?php
namespace girosolution\GiroCheckout_SDK;

/**
 * Tools for non specific functionalities
 *
 * @package GiroCheckout
 * @version $Revision: 94 $ / $Date: 2015-01-08 10:06:53 +0100 (Do, 08 Jan 2015) $
 */

class GiroCheckout_SDK_Tools {

  const HORIZONTAL = 1;
  const VERTICAL = 2;

  /** returns logname by given credit card types and size
   *
   * @param bool $visa_msc
   * @param bool $amex
   * @param bool $jcb
   * @param bool $diners
   * @param integer $size
   * @param string $layout
   * @return string
   *
   */
  public static function getCreditCardLogoName($visa_msc = false, $amex = false, $jcb = false) {

    if( !$visa_msc && !$amex  && !$jcb ) {
      return null;
    }

    $logoName = '';

    if( $visa_msc ) {
      $logoName .= 'visa_msc_';
    }
    if( $amex ) {
      $logoName .= 'amex_';
    }
    if( $jcb ) {
      $logoName .= 'jcb_';
    }

    $logoName .= '40px.png';

    return $logoName;
  }

  /**
   * Build filename for logo for the specified payment method.
   *
   * @param integer $p_iPaymentMethod Payment method ID (see constants in GiroCheckout_SDK_Config)
   * @param integer $p_iSize Image size (height in pixels, may be 40, 50 or 60)
   * @return string Filename of logo file, prepend its folder path before use.
   */
  public static function getPaymentLogoFilename( $p_iPaymentMethod, $p_iSize ) {
    if( !in_array( $p_iSize, array(40, 50, 60) ) ) {
      return "";
    }

    switch( $p_iPaymentMethod ) {
      case GiroCheckout_SDK_Config::FTG_SERVICES_PAYMENT_METHOD_GIROPAY:
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
   * Validates the passed API credentials against the host.
   *
   * @param string $p_strTransactionType Type of transaction to test (is match project)
   * @param string $p_strMerchantId Merchant ID to test
   * @param string $p_strProjectId Project ID to test
   * @param string $p_strProjectPassword Project password to test
   * @param string $p_strErrorInfo [OUT] Optionally pass variable here that is filled with the readon in case of return FALSE.
   * @return bool TRUE on successful validation, FALSE on failed validation (=wrong credentials)
   */
  public static function testApiCredentials( $p_strTransactionType, $p_strMerchantId, $p_strProjectId, $p_strProjectPassword, &$p_strErrorInfo = NULL ) {
    try {
      $testRequest = new GiroCheckout_SDK_Request( $p_strTransactionType );
    }
    catch( Exception $e ) {
      if( !is_null($p_strErrorInfo) ) {
        $p_strErrorInfo = "Exception on creating Request object, msg=" . $e->getMessage();
      }
      return FALSE;
    }

    return $testRequest->testCredentials( $p_strMerchantId, $p_strProjectId, $p_strProjectPassword, $p_strErrorInfo );
  }
}