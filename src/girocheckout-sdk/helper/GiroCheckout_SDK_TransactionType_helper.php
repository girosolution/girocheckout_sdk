<?php
namespace girosolution\GiroCheckout_SDK\helper;

use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardTransaction;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardCapture;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardRefund;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardGetPKN;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardRecurringTransaction;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardVoid;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardInitform;
use girosolution\GiroCheckout_SDK\api\creditcard\GiroCheckout_SDK_CreditCardFinalizeform;
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
use girosolution\GiroCheckout_SDK\api\paypage\GiroCheckout_SDK_PaypageDonationcert;
use girosolution\GiroCheckout_SDK\api\paypal\GiroCheckout_SDK_PaypalTransaction;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsBankstatus;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsTransaction;
use girosolution\GiroCheckout_SDK\api\eps\GiroCheckout_SDK_EpsIssuerList;
use girosolution\GiroCheckout_SDK\api\tools\GiroCheckout_SDK_Tools_GetTransaction;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeCreatePayment;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeCreateEpc;
use girosolution\GiroCheckout_SDK\api\girocode\GiroCheckout_SDK_GiroCodeGetEpc;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektTransaction;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektCapture;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektRefund;
use girosolution\GiroCheckout_SDK\api\paydirekt\GiroCheckout_SDK_PaydirektVoid;
use girosolution\GiroCheckout_SDK\api\sofortuw\GiroCheckout_SDK_SofortUwTransaction;
use girosolution\GiroCheckout_SDK\api\bluecode\GiroCheckout_SDK_BlueCodeTransaction;
use girosolution\GiroCheckout_SDK\api\bluecode\GiroCheckout_SDK_BlueCodeRefund;
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

  const TRANS_TYPE_CREDITCARD_TRANSACTION  = "creditCardTransaction";
  const TRANS_TYPE_CREDITCARD_CAPTURE      = "creditCardCapture";
  const TRANS_TYPE_CREDITCARD_REFUND       = "creditCardRefund";
  const TRANS_TYPE_CREDITCARD_GETPKN       = "creditCardGetPKN";
  const TRANS_TYPE_CREDITCARD_RECURRING    = "creditCardRecurringTransaction";
  const TRANS_TYPE_CREDITCARD_VOID         = "creditCardVoid";
  const TRANS_TYPE_CREDITCARD_INITFORM     = "creditCardInitform";
  const TRANS_TYPE_CREDITCARD_FINALIZEFORM = "creditCardFinalizeform";
  const TRANS_TYPE_CREDITCARD_SENDERINFO   = "creditCardSenderInfo";

  const TRANS_TYPE_DIRECTDEBIT_TRANSACTION = "directDebitTransaction";
  const TRANS_TYPE_DIRECTDEBIT_GETPKN      = "directDebitGetPKN";
  const TRANS_TYPE_DIRECTDEBIT_WO_PMTPGE   = "directDebitTransactionWithPaymentPage";
  const TRANS_TYPE_DIRECTDEBIT_CAPTURE     = "directDebitCapture";
  const TRANS_TYPE_DIRECTDEBIT_REFUND      = "directDebitRefund";
  const TRANS_TYPE_DIRECTDEBIT_VOID        = "directDebitVoid";
  const TRANS_TYPE_DIRECTDEBIT_SENDERINFO  = "directDebitSenderInfo";

  const TRANS_TYPE_GIROPAY_BANKSTATUS      = "giropayBankstatus";
  const TRANS_TYPE_GIROPAY_IDCHECK         = "giropayIDCheck";
  const TRANS_TYPE_GIROPAY_TRANSACTION     = "giropayTransaction";
  const TRANS_TYPE_GIROPAY_ISSUERLIST      = "giropayIssuerList";
  const TRANS_TYPE_GIROPAY_SENDERINFO      = "giropaySenderInfo";

  const TRANS_TYPE_IDEAL_ISSUERLIST        = "idealIssuerList";
  const TRANS_TYPE_IDEAL_PAYMENT           = "idealPayment";
  const TRANS_TYPE_IDEAL_REFUND            = "idealRefund";
  const TRANS_TYPE_IDEAL_SENDERINFO        = "idealSenderInfo";

  const TRANS_TYPE_PAYPAL_TRANSACTION      = "paypalTransaction";

  const TRANS_TYPE_EPS_BANKSTATUS          = "epsBankstatus";
  const TRANS_TYPE_EPS_TRANSACTION         = "epsTransaction";
  const TRANS_TYPE_EPS_ISSUERLIST          = "epsIssuerList";
  const TRANS_TYPE_EPS_SENDERINFO          = "epsSenderInfo";

  const TRANS_TYPE_GET_TRANSACTIONTOOL     = "getTransactionTool";

  const TRANS_TYPE_GIROCODE_CREATE_PMT     = "giroCodeCreatePayment";
  const TRANS_TYPE_GIROCODE_CREATE_EPC     = "giroCodeCreateEpc";
  const TRANS_TYPE_GIROCODE_GET_EPC        = "giroCodeGetEpc";

  const TRANS_TYPE_PAYDIREKT_TRANSACTION   = "paydirektTransaction";
  const TRANS_TYPE_PAYDIREKT_CAPTURE       = "paydirektCapture";
  const TRANS_TYPE_PAYDIREKT_REFUND        = "paydirektRefund";
  const TRANS_TYPE_PAYDIREKT_VOID          = "paydirektVoid";

  const TRANS_TYPE_SOFORT_TRANSACTION      = "sofortuwTransaction";

  const TRANS_TYPE_BLUECODE_TRANSACTION    = "blueCodeTransaction";
  const TRANS_TYPE_BLUECODE_REFUND         = "blueCodeRefund";

  const TRANS_TYPE_PAYPAGE_TRANSACTION     = "paypageTransaction";
  const TRANS_TYPE_PAYPAGE_PROJECTS        = "paypageProjects";
  const TRANS_TYPE_PAYPAGE_DONATIONCERT    = "paypageDonationCert";
  const TRANS_TYPE_PAYPAGE_REFUND          = "paypageRefund";
  const TRANS_TYPE_PAYPAGE_CAPTURE         = "paypageCapture";

  const TRANS_TYPE_MAESTRO_TRANSACTION     = "maestroTransaction";
  const TRANS_TYPE_MAESTRO_CAPTURE         = "maestroCapture";
  const TRANS_TYPE_MAESTRO_REFUND          = "maestroRefund";

  /**
   * Returns api call instance
   *
   * @param String api call name
   * @return object
   */
  public static function getTransactionTypeByName($transType) {
    switch ($transType) {
      //credit card apis
      case self::TRANS_TYPE_CREDITCARD_TRANSACTION:
        return new GiroCheckout_SDK_CreditCardTransaction();
      case self::TRANS_TYPE_CREDITCARD_CAPTURE:
        return new GiroCheckout_SDK_CreditCardCapture();
      case self::TRANS_TYPE_CREDITCARD_REFUND:
        return new GiroCheckout_SDK_CreditCardRefund();
      case self::TRANS_TYPE_CREDITCARD_GETPKN:
        return new GiroCheckout_SDK_CreditCardGetPKN();
      case self::TRANS_TYPE_CREDITCARD_RECURRING:
        return new GiroCheckout_SDK_CreditCardRecurringTransaction();
      case self::TRANS_TYPE_CREDITCARD_VOID:
        return new GiroCheckout_SDK_CreditCardVoid();
      case self::TRANS_TYPE_CREDITCARD_INITFORM:
        return new GiroCheckout_SDK_CreditCardInitform();
      case self::TRANS_TYPE_CREDITCARD_FINALIZEFORM:
        return new GiroCheckout_SDK_CreditCardFinalizeform();

      //direct debit apis
      case self::TRANS_TYPE_DIRECTDEBIT_TRANSACTION:
        return new GiroCheckout_SDK_DirectDebitTransaction();
      case self::TRANS_TYPE_DIRECTDEBIT_GETPKN:
        return new GiroCheckout_SDK_DirectDebitGetPKN();
      case self::TRANS_TYPE_DIRECTDEBIT_WO_PMTPGE:
        return new GiroCheckout_SDK_DirectDebitTransactionWithPaymentPage();
      case self::TRANS_TYPE_DIRECTDEBIT_CAPTURE:
        return new GiroCheckout_SDK_DirectDebitCapture();
      case self::TRANS_TYPE_DIRECTDEBIT_REFUND:
        return new GiroCheckout_SDK_DirectDebitRefund();
      case self::TRANS_TYPE_DIRECTDEBIT_VOID:
        return new GiroCheckout_SDK_DirectDebitVoid();

      //giropay apis
      case self::TRANS_TYPE_GIROPAY_BANKSTATUS:
        return new GiroCheckout_SDK_GiropayBankstatus();
      case self::TRANS_TYPE_GIROPAY_IDCHECK:
        return new GiroCheckout_SDK_GiropayIDCheck();
      case self::TRANS_TYPE_GIROPAY_TRANSACTION:
        return new GiroCheckout_SDK_GiropayTransaction();
      case self::TRANS_TYPE_GIROPAY_ISSUERLIST:
        return new GiroCheckout_SDK_GiropayIssuerList();

      //iDEAL apis
      case self::TRANS_TYPE_IDEAL_ISSUERLIST:
        return new GiroCheckout_SDK_IdealIssuerList();
      case self::TRANS_TYPE_IDEAL_PAYMENT:
        return new GiroCheckout_SDK_IdealPayment();
      case self::TRANS_TYPE_IDEAL_REFUND:
        return new GiroCheckout_SDK_IdealPaymentRefund();

      //PayPal apis
      case self::TRANS_TYPE_PAYPAL_TRANSACTION:
        return new GiroCheckout_SDK_PaypalTransaction();

      //eps apis
      case self::TRANS_TYPE_EPS_BANKSTATUS:
        return new GiroCheckout_SDK_EpsBankstatus();
      case self::TRANS_TYPE_EPS_TRANSACTION:
        return new GiroCheckout_SDK_EpsTransaction();
      case self::TRANS_TYPE_EPS_ISSUERLIST:
        return new GiroCheckout_SDK_EpsIssuerList();

      //tools apis
      case self::TRANS_TYPE_GET_TRANSACTIONTOOL:
        return new GiroCheckout_SDK_Tools_GetTransaction();

      //GiroCode apis
      case self::TRANS_TYPE_GIROCODE_CREATE_PMT:
        return new GiroCheckout_SDK_GiroCodeCreatePayment();
      case self::TRANS_TYPE_GIROCODE_CREATE_EPC:
        return new GiroCheckout_SDK_GiroCodeCreateEpc();
      case self::TRANS_TYPE_GIROCODE_GET_EPC:
        return new GiroCheckout_SDK_GiroCodeGetEpc();

      //Paydirekt apis
      case self::TRANS_TYPE_PAYDIREKT_TRANSACTION:
        return new GiroCheckout_SDK_PaydirektTransaction();
      case self::TRANS_TYPE_PAYDIREKT_CAPTURE:
        return new GiroCheckout_SDK_PaydirektCapture();
      case self::TRANS_TYPE_PAYDIREKT_REFUND:
        return new GiroCheckout_SDK_PaydirektRefund();
      case self::TRANS_TYPE_PAYDIREKT_VOID:
        return new GiroCheckout_SDK_PaydirektVoid();

      //Sofort apis
      case self::TRANS_TYPE_SOFORT_TRANSACTION:
        return new GiroCheckout_SDK_SofortUwTransaction();

      //BlueCode apis
      case self::TRANS_TYPE_BLUECODE_TRANSACTION:
        return new GiroCheckout_SDK_BlueCodeTransaction();
      case self::TRANS_TYPE_BLUECODE_REFUND:
        return new GiroCheckout_SDK_BlueCodeRefund();

      //Payment page apis
      case self::TRANS_TYPE_PAYPAGE_TRANSACTION:
        return new GiroCheckout_SDK_PaypageTransaction();
      case self::TRANS_TYPE_PAYPAGE_PROJECTS:
        return new GiroCheckout_SDK_PaypageProjects();
      case self::TRANS_TYPE_PAYPAGE_DONATIONCERT:
        return new GiroCheckout_SDK_PaypageDonationcert();
      case self::TRANS_TYPE_PAYPAGE_REFUND:
        return new GiroCheckout_SDK_PaypageRefund();
      case self::TRANS_TYPE_PAYPAGE_CAPTURE:
        return new GiroCheckout_SDK_PaypageCapture();

      //Maestro apis
      case self::TRANS_TYPE_MAESTRO_TRANSACTION:
        return new GiroCheckout_SDK_MaestroTransaction();
      case self::TRANS_TYPE_MAESTRO_CAPTURE:
        return new GiroCheckout_SDK_MaestroCapture();
      case self::TRANS_TYPE_MAESTRO_REFUND:
        return new GiroCheckout_SDK_MaestroRefund();
    }

    return null;
  }
}