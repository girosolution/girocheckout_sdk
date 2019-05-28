<?php
namespace girosolution\GiroCheckout_SDK\helper;

use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardTransaction;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardCapture;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardRefund;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardGetPKN;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardRecurringTransaction;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardVoid;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitTransaction;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitGetPKN;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitTransactionWithPaymentPage;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitCapture;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitRefund;
use girosolution\GiroCheckout_SDK\api\directdebit\GiroCheckout_SDK_DirectDebitVoid;
use girosolution\GiroCheckout_SDK\api\giropay\GiroCheckout_SDK_GiropayBankstatus;
use girosolution\GiroCheckout_SDK\api\giropay\GiroCheckout_SDK_GiropayIDCheck;
use girosolution\GiroCheckout_SDK\api\giropay\GiroCheckout_SDK_GiropayTransaction;
use girosolution\GiroCheckout_SDK\api\giropay\GiroCheckout_SDK_GiropayIssuerList;
use girosolution\GiroCheckout_SDK\api\ideal\GiroCheckout_SDK_IdealIssuerList;
use girosolution\GiroCheckout_SDK\api\ideal\GiroCheckout_SDK_IdealPayment;
use girosolution\GiroCheckout_SDK\api\ideal\GiroCheckout_SDK_IdealPaymentRefund;
use girosolution\GiroCheckout_SDK\api\paypal\GiroCheckout_SDK_PaypalTransaction;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsBankstatus;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsTransaction;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsIssuerList;
use girosolution\GiroCheckout_SDK\api\GiroCheckout_SDK_Tools_GetTransaction;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeCreatePayment;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeCreateEpc;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeGetEpc;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektTransaction;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektCapture;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektRefund;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektVoid;
use girosolution\GiroCheckout_SDK\api\sofortuw\GiroCheckout_SDK_SofortUwTransaction;
use girosolution\GiroCheckout_SDK\api\bluecode\GiroCheckout_SDK_BlueCodeTransaction;
use girosolution\GiroCheckout_SDK\api\paypage\GiroCheckout_SDK_PaypageTransaction;
use girosolution\GiroCheckout_SDK\api\paypage\GiroCheckout_SDK_PaypageProjects;
use girosolution\GiroCheckout_SDK\api\maestro\GiroCheckout_SDK_MaestroTransaction;
use girosolution\GiroCheckout_SDK\api\maestro\GiroCheckout_SDK_MaestroCapture;
use girosolution\GiroCheckout_SDK\api\maestro\GiroCheckout_SDK_MaestroRefund;

/**
 * Helper class which manages api call instances
 *
 * @package GiroCheckout
 * @version $Revision: 225 $ / $Date: 2017-09-04 16:11:20 -0300 (Mon, 04 Sep 2017) $
 */
class GiroCheckout_SDK_TransactionType_helper {

  /**
   * Returns api call instance
   *
   * @param String api call name
   * @return object
   */
  public static function getTransactionTypeByName($transType) {
    switch ($transType) {
      //credit card apis
      case 'creditCardTransaction':
        return new GiroCheckout_SDK_CreditCardTransaction();
      case 'creditCardCapture':
        return new GiroCheckout_SDK_CreditCardCapture();
      case 'creditCardRefund':
        return new GiroCheckout_SDK_CreditCardRefund();
      case 'creditCardGetPKN':
        return new GiroCheckout_SDK_CreditCardGetPKN();
      case 'creditCardRecurringTransaction':
        return new GiroCheckout_SDK_CreditCardRecurringTransaction();
      case 'creditCardVoid':
        return new GiroCheckout_SDK_CreditCardVoid();

      //direct debit apis
      case 'directDebitTransaction':
        return new GiroCheckout_SDK_DirectDebitTransaction();
      case 'directDebitGetPKN':
        return new GiroCheckout_SDK_DirectDebitGetPKN();
      case 'directDebitTransactionWithPaymentPage':
        return new GiroCheckout_SDK_DirectDebitTransactionWithPaymentPage();
      case 'directDebitCapture':
        return new GiroCheckout_SDK_DirectDebitCapture();
      case 'directDebitRefund':
        return new GiroCheckout_SDK_DirectDebitRefund();
      case 'directDebitVoid':
        return new GiroCheckout_SDK_DirectDebitVoid();

      //giropay apis
      case 'giropayBankstatus':
        return new GiroCheckout_SDK_GiropayBankstatus();
      case 'giropayIDCheck':
        return new GiroCheckout_SDK_GiropayIDCheck();
      case 'giropayTransaction':
        return new GiroCheckout_SDK_GiropayTransaction();
      case 'giropayIssuerList':
        return new GiroCheckout_SDK_GiropayIssuerList();

      //iDEAL apis
      case 'idealIssuerList':
        return new GiroCheckout_SDK_IdealIssuerList();
      case 'idealPayment':
        return new GiroCheckout_SDK_IdealPayment();
      case 'idealRefund':
        return new GiroCheckout_SDK_IdealPaymentRefund();

      //PayPal apis
      case 'paypalTransaction':
        return new GiroCheckout_SDK_PaypalTransaction();

      //eps apis
      case 'epsBankstatus':
        return new GiroCheckout_SDK_EpsBankstatus();
      case 'epsTransaction':
        return new GiroCheckout_SDK_EpsTransaction();
      case 'epsIssuerList':
        return new GiroCheckout_SDK_EpsIssuerList();

      //tools apis
      case 'getTransactionTool':
        return new GiroCheckout_SDK_Tools_GetTransaction();

      //GiroCode apis
      case 'giroCodeCreatePayment':
        return new GiroCheckout_SDK_GiroCodeCreatePayment();
      case 'giroCodeCreateEpc':
        return new GiroCheckout_SDK_GiroCodeCreateEpc();
      case 'giroCodeGetEpc':
        return new GiroCheckout_SDK_GiroCodeGetEpc();

      //Paydirekt apis
      case 'paydirektTransaction':
        return new GiroCheckout_SDK_PaydirektTransaction();
      case 'paydirektCapture':
        return new GiroCheckout_SDK_PaydirektCapture();
      case 'paydirektRefund':
        return new GiroCheckout_SDK_PaydirektRefund();
      case 'paydirektVoid':
        return new GiroCheckout_SDK_PaydirektVoid();

      //Sofort apis
      case 'sofortuwTransaction':
        return new GiroCheckout_SDK_SofortUwTransaction();

      //BlueCode apis
      case 'blueCodeTransaction':
        return new GiroCheckout_SDK_BlueCodeTransaction();
      case 'blueCodeRefund':
        return new GiroCheckout_SDK_BlueCodeRefund();

      //Payment page apis
      case 'paypageTransaction':
        return new GiroCheckout_SDK_PaypageTransaction();
      case 'paypageProjects':
        return new GiroCheckout_SDK_PaypageProjects();

      //Maestro apis
      case 'maestroTransaction':
        return new GiroCheckout_SDK_MaestroTransaction();
      case 'maestroCapture':
        return new GiroCheckout_SDK_MaestroCapture();
      case 'maestroRefund':
        return new GiroCheckout_SDK_MaestroRefund();
    }

    return null;
  }
}