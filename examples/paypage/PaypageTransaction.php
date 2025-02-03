<?php
define('__GIROCHECKOUT_SDK_DEBUG__', true);

/**
 * Sample code for GiroCheckout integration of a transaction through the GS Paypage
 *
 * @filesource
 * @package Samples
 * @version $Revision: 109 $ / $Date: 2015-06-01 13:37:30 +0200 (Mo, 01 Jun 2015) $
 */
require '../vendor/autoload.php';

use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
use girosolution\GiroCheckout_SDK\helper\GiroCheckout_SDK_TransactionType_helper;

/**
 * configuration of the merchants identifier, project and password
 * this information can be found in the GiroCockpit's project settings
 */
$merchantID = 0;        // Your merchant ID (Verkaufer-ID)
$projectID = 0;         // Your project ID (Projekt-ID)
$projectPassword = "";  // Your project password

$aTdsOptionalInfo = new stdClass();
$aTdsOptionalInfo->email = "myemail@example.com"; // Optional email address
$aTdsOptionalInfo->addressesMatch = "false"; // Shipping address matches billing address, array( "true", "false" );

$aTdsOptionalInfo->billingAddress = new stdClass();
$aTdsOptionalInfo->billingAddress->line2 = "Beim Nachbarn klingeln";
$aTdsOptionalInfo->billingAddress->line3 = "zw. 22-24 Uhr";
$aTdsOptionalInfo->billingAddress->state = "BW";

$aTdsOptionalInfo->shippingAddress = new stdClass();
$aTdsOptionalInfo->shippingAddress->city = "Berlin";
$aTdsOptionalInfo->shippingAddress->postcode = "11113";
$aTdsOptionalInfo->shippingAddress->country = "DE";
$aTdsOptionalInfo->shippingAddress->line1 = "Unter den Linden 1";
$aTdsOptionalInfo->shippingAddress->line2 = "Brandenburger Tor";
$aTdsOptionalInfo->shippingAddress->line3 = "(linker Bogen)";
$aTdsOptionalInfo->shippingAddress->state = "BER";

$aTdsOptionalInfo->homePhoneNumber = new stdClass();
$aTdsOptionalInfo->homePhoneNumber->country = "49";  // phone number country code
$aTdsOptionalInfo->homePhoneNumber->regional = "75519209309";  // phone number rest

$aTdsOptionalInfo->mobilePhoneNumber = new stdClass();
$aTdsOptionalInfo->mobilePhoneNumber->country = "49";  // phone number country code
$aTdsOptionalInfo->mobilePhoneNumber->regional = "17093902978";  // phone number rest

$aTdsOptionalInfo->workPhoneNumber = new stdClass();
$aTdsOptionalInfo->workPhoneNumber->country = "49";  // phone number country code
$aTdsOptionalInfo->workPhoneNumber->regional = "8938928938";  // phone number rest

$aTdsOptionalInfo->cardholderAccountInfo = new stdClass();
$aTdsOptionalInfo->cardholderAccountInfo->accountAgeIndicator = "more30less60";  // array( "less30", "more30less60", "more60", "never", "now" );
$aTdsOptionalInfo->cardholderAccountInfo->passwordChangeIndicator = "never";    // array( "less30", "more30less60", "more60", "never", "now" );
$aTdsOptionalInfo->cardholderAccountInfo->paymentAccountAgeIndicator = "less30";  // array( "less30", "more30less60", "more60", "never", "now" );
$aTdsOptionalInfo->cardholderAccountInfo->accountChange = "now";  // array( "less30", "more30less60", "more60", "now" );
$aTdsOptionalInfo->cardholderAccountInfo->shippingAddressAgeIndicator = "more60";  // array( "less30", "more30less60", "more60", "now" );
$aTdsOptionalInfo->cardholderAccountInfo->shippingNameIndicator = "different";  // array( "different", "identical" );
$aTdsOptionalInfo->cardholderAccountInfo->suspiciousAccountActivity = "false";  // array( "true", "false" );
$aTdsOptionalInfo->cardholderAccountInfo->provisioningDayCount = 10;

$aTdsOptionalInfo->tdsMerchantRiskIndicators = new stdClass();
$aTdsOptionalInfo->tdsMerchantRiskIndicators->deliveryTimeframe = "overnight";  // array( "electronic", "moreThanOneDay", "overnight", "sameDay" );
$aTdsOptionalInfo->tdsMerchantRiskIndicators->deliveryEmailAddress = "hans-mueller@example.com";
$aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardAmount = 0;
$aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardCount = 2;
$aTdsOptionalInfo->tdsMerchantRiskIndicators->giftCardCurrency = "EUR";
$aTdsOptionalInfo->tdsMerchantRiskIndicators->preOrderDate = "2020-12-20";
$aTdsOptionalInfo->tdsMerchantRiskIndicators->preOrderPurchaseIndicator = "available";  // array( "available", "future" );
$aTdsOptionalInfo->tdsMerchantRiskIndicators->reorderItemsIndicator = "first";  // array( "first", "reordered" );
$aTdsOptionalInfo->tdsMerchantRiskIndicators->shippingIndicator = "store";  // array( "digital", "other", "billingAddress", "differentAddress", "store", "verifiedAddress" );

$aTdsOptionalInfo->tdsRequestorAuthenticationInformation = new stdClass();
$aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationData = "123Hdajkd/dasjdkk";
$aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationTimestamp = "2020-11-09T12:09:09";
$aTdsOptionalInfo->tdsRequestorAuthenticationInformation->authenticationMethod = "ownCredentials";  // array( "federatedId", "fido", "fidoSigned", "issuerCredentials", "none", "ownCredentials", "srcAssurance", "thirdParty" );

$aTdsOptionalInfo->tdsTransactionAttributes = new stdClass();
$aTdsOptionalInfo->tdsTransactionAttributes->purchaseInstalmentData = 2;
$aTdsOptionalInfo->tdsTransactionAttributes->recurringExpiry = "2020-11-30";
$aTdsOptionalInfo->tdsTransactionAttributes->recurringFrequency = 1234;
$aTdsOptionalInfo->tdsTransactionAttributes->type = "quasiCash";  // array( "purchase", "checkAcceptance", "accountFunding", "quasiCash", "prepaidActivation" );

$basket = [
  "basket_id" => "basket" . random_int(10000, 999999), // Unique identifier for the basket
  "basket_type" => "PHYSICAL", // Type of basket: DIGITAL, PHYSICAL, or MIXED
  "basket_items" => [ // List of items in the basket
    [
      "name" => "Item 1", // Name of the item
      "quantity" => [
        "quantity_amount" => 3, // Amount of units
        "quantity_unit" => "pcs" // Unit of measurement
      ],
      "unit_price" => [
        "net" => 500, // Amount excluding tax (minor unit)
        "gross" => 600, // Amount including tax (minor unit)
        "currency" => "EUR", // ISO 4217 currency code
        "tax" => 2000 // Tax percentage (with two implied decimals, e.g., 20.00%)
      ]
    ]
  ]
];

$billingAddress = [
  "title" => "Herr",
  "first_name" => "Max",
  "last_name" => "Mustermann",
  "company_name" => "Acme GmbH",
  "email" => "maxi.muster@example.com",
  "phone_contact" => [
    "phone_type" => "MOBILE",
    "phone_number" => "+491701234567"
  ],
  "address_line_1" => "Mustergasse 123",
  "address_line_2" => "Haus A",
  "address_line_3" => "Wohnung 12",
  "postal_code" => "88888",
  "city" => "Berlin",
  "state" => "Berlin",
  "country" => "DE"
];

$shippingAddress = [
  "title" => "Herr",
  "first_name" => "Max",
  "last_name" => "Mustermann",
  "company_name" => "Acme GmbH",
  "email" => "maxi.muster@example.com",
  "phone_contact" => [
    "phone_type" => "HOME",
    "phone_number" => "+49755283492987"
  ],
  "address_line_1" => "Musterstr. 1a",
  "postal_code" => "88888",
  "city" => "Berlin",
  "state" => "Berlin",
  "country" => "DE"
];

$customerInformation = [
  "customer_id" => "CUST123456",
  "date_of_birth" => "1985-06-15",
  "gender" => "MALE",
  "title" => "Herr",
  "personal_identifications" => [
    [
      "type" => "PASSPORT",
      "id" => "A1234567",
      "issued_by" => "DE" // Must be an ISO country code
    ],
    [
      "type" => "DRIVERS_LICENSE",
      "id" => "DL78901234",
      "issued_by" => "Bayrisches Verkehrsministerium für alle Leute, die gerne Auto fahren und auch die die nicht" // Free text for driver's license
    ]
  ],
  "contacts" => [
    "phone_contacts" => [
      [
        "phone_type" => "HOME",
        "phone_number" => "+442071838750"
      ]
    ]
  ]
];

/* init transaction and parameters */
try {

  $request = new GiroCheckout_SDK_Request(GiroCheckout_SDK_TransactionType_helper::TRANS_TYPE_PAYPAGE_TRANSACTION);
  $request->setSecret($projectPassword);
  $request->addParam('merchantId', $merchantID)
    ->addParam('projectId', $projectID)
    ->addParam('merchantTxId', 123456)
    ->addParam('amount', 800)
    ->addParam('currency', 'EUR')
    ->addParam('purpose', 'Spenden')
    ->addParam('pagetype', 2)  // 0=def, 1=pay, 2=donate
    //->addParam('timeout', 40)
    //->addParam('single', 1) //0 = beliebig oft wiederholbar (default), 1 = nur ein einzigerr Bezahlversuch, 2 = nur für eine erfolgreiche Bezahlung nutzbar
    //->addParam('expirydate','once')
    //->addParam('expirydate','2020-08-04')
    //->addParam('paymethods', '1,2,6,23,12,11')
    //->addParam('paymethods', '6')
    //->addParam('payprojects', '100,101,102,103')
    //->addParam('freeamount', '1')
    ->addParam('minamount', '100')
    ->addParam('maxamount', '1000000')
    ->addParam('fixedvalues', '["500","1000","1500","2000","5000"]')
    //->addParam('type', 'AUTH')
    //->addParam('description','API-Aufruf von Lokal')
    //->addParam('organization','Meine Organisation')
    //->addParam('projectlist', json_encode(array("Projekt 1", "Projekt 2", "Projekt 3")))
    //->addParam('otherpayments', json_encode(array( array("id"=>14, "url" => "https://www.paypal.de", "position" => 10), array("id"=>11, "url" => "https://www.visa.com", "position" => 2) )))
    ->addParam('locale', 'de')  // English: en
    ->addParam('test', 1)
    ->addParam('certdata', 1)  // Optional to request certificate data
    //->addParam('paydirektShippingFirstName', 'Max')
    //->addParam('paydirektShippingLastName', 'Mustermann')
    //->addParam('paydirektShippingZipCode', '10000')
    //->addParam('paydirektShippingCity', 'Musterstadt')
    //->addParam('paydirektShippingCountry', 'DE')
    //->addParam('pkn','create')
    //->addParam('pkn','5754467832f5ed65f93b2734c189140d')  // LS
    //->addParam('successUrl','https://dev.girosolution.de/notify.php')

//    ->addParam('tds2Address','Hintere Bergstrasse 89')
//    ->addParam('tds2Postcode','66899')
//    ->addParam('tds2City','Traupheim')
//    ->addParam('tds2Country','DE')
//    ->addParam('tds2Optional',json_encode($aTdsOptionalInfo))
//    ->addParam('klarnaBillingAddress', json_encode($billingAddress))
//    ->addParam('klarnaShippingAddress', json_encode($shippingAddress))
//    ->addParam('klarnaCustomerInfo', json_encode($customerInformation))
//    ->addParam('klarnaBasket', json_encode($basket))

    ->addParam('successUrl', 'https://dev.girosolution.de/redirect.php?success=1')
    //->addParam('backUrl','https://dev.girosolution.de/redirect.php?back=1')
    ->addParam('failUrl', 'https://dev.girosolution.de/redirect.php?fail=1')
    ->addParam('notifyUrl', 'https://dev.girosolution.de/notify.php')

    //the hash field is auto generated by the SDK
    ->submit();

  //echo "<pre>";print_r($request->getResponseRaw());echo "</pre>";

  /* if transaction succeeded update your local system and redirect the customer */
  if ($request->requestHasSucceeded()) {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseParam('reference');
    $request->getResponseParam('url');

    $request->redirectCustomerToPaymentProvider();
  }

  /* if the transaction did not succeed update your local system, get the responsecode and notify the customer */
  else {
    $request->getResponseParam('rc');
    $request->getResponseParam('msg');
    $request->getResponseMessage($request->getResponseParam('rc'), 'DE');

    echo "<pre>";
    print_r($request->getResponseRaw());
    echo "</pre>";
  }
}
catch (Exception $e) {
  echo $e->getMessage();
}