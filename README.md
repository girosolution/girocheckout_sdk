# GiroCheckout SDK

PHP development SDK for connections to GiroCheckout Payment Gateway

The GiroCockpit SDK allows a simple implementation of the GiroCheckout API. The SDK includes all API calls provided by GiroCheckout. 
For every API there is an example script in the examples section.

## __Requirements__

- The SDK uses the cURL extension for server communication.
- All data must be given in UTF-8. The SDK does not take care of the conversion.
- PHP >= 5.2

## __Download__

GiroCheckout SDK is available both in composer compatible form and as a standalone library.

Download the current standalone GiroCheckout PHP SDK [here](http://api.girocheckout.de/en:phpsdk:start).

Find the instructions for the composer version further down in this document.

## __Important note regarding notify and redirect__

GiroCheckout uses two parallel channels for the communication between the GiroCheckout server and the Shop: The notification (or notify for short) and the redirect. The notify is a server to server call in the background, whereas the redirect runs over the customer's browser, showing him the transaction result at the end. Both paths must function separately and independently from each other, in case one of them doesn't reach its destination. This way, the transaction is also successful if the notification happens to not arrive at the shop for whatever reason (so only the redirect could be successful) or if the customer interrupts the redirection to the shop site (so only the notify gets through). But of course a check is required on both sides whether the order has already been processed in the shop, in order to avoid a duplicate processing.

Please also see [API Basics](http://api.girocheckout.de/en:girocheckout:general:start).

## Folders

The folder "examples" includes any example script. Among them there is
an example for every API call as well as a notification and a redirect
script. The folder "GiroCheckout\_SDK" contains the
GiroCheckout\_SDK.php, which needs to be included in order to use the
SDK functionalities.

<img src="https://raw.githubusercontent.com/girosolution/girocheckout_sdk/blob/documentation/docfiles/SDK_git_folders.png" width="400">

## List of all request types (Request & Notify)

| API documentation                                            | Request type                          | Object name                                                |
| ------------------------------------------------------------ | ------------------------------------- | ---------------------------------------------------------- |
| **eps**                                                      |                                       |                                                            |
| [check eps bank status](en:girocheckout:eps:start#check_bankstatus "wikilink") | epsBankstatus                         | GiroCheckout\_SDK\_EpsBankstatus()                         |
| [eps issuer list](en:girocheckout:eps:start#eps_issuer_bank_request "wikilink") | epsIssuerList                         | GiroCheckout\_SDK\_EpsIssuerList()                         |
| [eps transaction](en:girocheckout:eps:start#initialise_eps_payment "wikilink") | epsTransaction                        | GiroCheckout\_SDK\_EpsTransaction()                        |
| **giropay**                                                  |                                       |                                                            |
| [check bank status](en:girocheckout:giropay:start#check_bankstatus "wikilink") | giropayBankstatus                     | GiroCheckout\_SDK\_GiropayBankstatus()                     |
| [giropay-ID](en:girocheckout:giropay:start#initialise_giropay_payment "wikilink") | giropayIDCheck                        | GiroCheckout\_SDK\_GiropayIDCheck()                        |
| [giropay transaction](en:girocheckout:giropay:start#initialise_giropay_payment "wikilink") | giropayTransaction                    | GiroCheckout\_SDK\_GiropayTransaction()                    |
| [giropay +giropay-ID](en:girocheckout:giropay:start#initialise_giropay_payment "wikilink") | giropayTransaction                    | GiroCheckout\_SDK\_GiropayTransaction()                    |
| **iDEAL**                                                    |                                       |                                                            |
| [iDEAL get issuer list](en:girocheckout:ideal:start#ideal_issuer_bank_request "wikilink") | idealIssuerList                       | GiroCheckout\_SDK\_IdealIssuerList()                       |
| [iDEAL transaction](en:girocheckout:ideal:start#initialise_ideal_payment "wikilink") | idealPayment                          | GiroCheckout\_SDK\_IdealPayment()                          |
| **credit card**                                              |                                       |                                                            |
| [credit card payment](en:girocheckout:creditcard:start#initialise_credit_card_payment "wikilink") | creditCardTransaction                 | GiroCheckout\_SDK\_CreditCardTransaction()                 |
| [get PKN](en:girocheckout:creditcard:start#pseudo_card_number_pkn "wikilink") | creditCardGetPKN                      | GiroCheckout\_SDK\_CreditCardGetPKN()                      |
| [recurring credit card payment](en:girocheckout:creditcard:start#recurring_credit_card_payment "wikilink") | creditCardRecurringTransaction        | GiroCheckout\_SDK\_CreditCardRecurringTransaction()        |
| [credit card void](en:girocheckout:creditcard:start#void "wikilink") | creditCardVoid                        | GiroCheckout\_SDK\_CreditCardVoid()                        |
| **direct debit**                                             |                                       |                                                            |
| [direct debit without payment page](en:girocheckout:directdebit:start#direct_debit_without_payment_page "wikilink") | directDebitTransaction                | GiroCheckout\_SDK\_DirectDebitTransaction()                |
| [direct debit payment page](en:girocheckout:directdebit:start#initialise_direct_debit_payment_with_payment_page "wikilink") | directDebitTransactionWithPaymentPage | GiroCheckout\_SDK\_DirectDebitTransactionWithPaymentPage() |
| [direct debit void](en:girocheckout:directdebit:start#void "wikilink") | directDebitVoid                       | GiroCheckout\_SDK\_DirectDebitVoid()                       |
| **Maestro**                                                  |                                       |                                                            |
| [Maestro payment](en:girocheckout:maestro:start#initialize_maestro_payment "wikilink") | maestroTransaction                    | GiroCheckout\_SDK\_MaestroTransaction()                    |
| [Maestro capture](en:girocheckout:maestro:start#capture "wikilink") | maestroCapture                        | GiroCheckout\_SDK\_MaestroCapture()                        |
| [Maestro refund](en:girocheckout:maestro:start#refund "wikilink") | maestroRefund                         | GiroCheckout\_SDK\_MaestroRefund()                         |
| **paydirekt**                                                |                                       |                                                            |
| [Paydirekt payment](en:girocheckout:paydirekt:start#initialization_of_a_paydirekt_payment "wikilink") | paydirektTransaction                  | GiroCheckout\_SDK\_PaydirektTransaction()                  |
| [Paydirekt capture](en:girocheckout:paydirekt:start#capture "wikilink") | paydirektCapture                      | GiroCheckout\_SDK\_PaydirektCapture()                      |
| [Paydirekt refund](en:girocheckout:paydirekt:start#refund "wikilink") | paydirektRefund                       | GiroCheckout\_SDK\_PaydirektRefund()                       |
| [Paydirekt void](en:girocheckout:paydirekt:start#void "wikilink") | paydirektVoid                         | GiroCheckout\_SDK\_PaydirektVoid()                         |
| **Payment Page Transaktion**                                 |                                       |                                                            |
| [Payment through Payment Page](en:girocheckout:paypage:start#payment_initialization_through_the_payment_page "wikilink") | paypageTransaction                    | GiroCheckout\_SDK\_PaypageTransaction()                    |
| [Project request](en:girocheckout:paypage:start#project_request "wikilink") | paypageProjects                       | GiroCheckout\_SDK\_PaypageProjects()                       |
| **Sofort**                                                   |                                       |                                                            |
| [Sofort payment](en:girocheckout:sofortuw:start#initialization_of_a_sofort_payment "wikilink") | sofortuwTransaction                   | GiroCheckout\_SDK\_SofortUwTransaction()                   |
| **PayPal**                                                   |                                       |                                                            |
| [PayPal transaction](en:girocheckout:paypal:start#initialise_paypal_payment "wikilink") | paypalTransaction                     | GiroCheckout\_SDK\_PaypalTransaction()                     |
| **Tools**                                                    |                                       |                                                            |
| [get transaction information](en:tools:transaction_status "wikilink") | getTransactionTool                    | GiroCheckout\_SDK\_Tools\_GetTransaction()                 |

## Implementation of an API call

This implementation example is based on the
"examples/giropay/giropayTransction.php" file.

### Load SDK

```php
require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
```

The file "autload.php" has to be included in an appropriate place, to use API functionalities. It is located inside the vendor folder created by composer.  So make sure the path to it is correct.

You may also want to add a "use" statement for every GiroCheckout class you use.  GiroCheckout_SDK_Request will always be used at least. 

### Configure data for authentication

```php
$merchantID = xxx;
$projectID = xxx;
$projectPassword = xxx;
```

This data is provided in the [GiroCockpit](https://www.girocockpit.de "wikilink"). Ensure that the used project ID is correct and belongs to an API call. For example you can only use a giropay project ID for a "giropayTransaction" request.

### API call

```php
$request = new GiroCheckout_SDK_Request('giropayTransaction');
$request->setSecret($projectPassword);
$request->addParam('merchantId',$merchantID)
	->addParam('projectId',$projectID)
	->addParam('merchantTxId',1234567890)
	->addParam('amount',100)
	->addParam('currency','EUR')
	->addParam('purpose','Beispieltransaktion')
	->addParam('bic','TESTDETT421')
	->addParam('info1Label','Ihre Kundennummer')
	->addParam('info1Text','0815')
	->addParam('urlRedirect','https://www.my-domain.de/girocheckout/redirect-giropay')
	->addParam('urlNotify','https://www.my-domain.de/girocheckout/notify-giropay')
	//the hash field is auto generated by the SDK
	->submit();
```

To perform a request there has to be instantiated and configurated a request object ([list of all request
types](en:phpsdk:phpsdk:request_types_list "wikilink")). The project password has to be given to the request object by calling the *setSecret()* method. It is used for the hash generation. Any API parameters, exept for the hash param, have to be set to the request
object by calling *addParam()*.

The method *submit()* performs the API call to GiroCheckout.

### API response

```php
if($request->requestHasSucceeded()) {
  $request->getResponseParam('rc');
  $request->getResponseParam('msg');
  $request->getResponseParam('reference');
  $request->getResponseParam('redirect');
  $request->redirectCustomerToPaymentProvider();
}
/* if the transaction did not succeed, update your local system, get the responsecode and notify the customer */
else {
  $request->getResponseParam('rc');
  $request->getResponseParam('msg');
  $request->getResponseMessage($request->getResponseParam('rc'),'DE');
}
```

The method *requestHasSucceeded()* returns true, if the request was successfully performed. Any API response parameters are provided by the *getResponseParam()* method. The customer redirection can be performet by calling the *redirectCustomerToPaymentProvider()* method. The buyer will be redirected to the URL given in the *redirect* parameter. 

If an eror occured there is the error code stored in the rc param. The method *getResponseMessage()* delivers a translated error message in a supporded language. 

## Notification und Redirect scripts

 This implementation example is based on the “examples/notification.php” file. 

### Load SDK

```php
require '../vendor/autoload.php';
use girosolution\GiroCheckout_SDK\GiroCheckout_SDK_Request;
```

The file "autload.php" has to be included in an appropriate place, to use API functionalities. It is located inside the vendor folder created by composer.  So make sure the path to it is correct.

You may also want to add a "use" statement for every GiroCheckout class you use.  GiroCheckout_SDK_Request will always be used at least. 

### Configure data for authentication

```php
$projectPassword = xxx;
```

The password is provided in the [GiroCockpit](https://www.girocockpit.de). It is for the hash comparison, to ensure that GiroCheckout sends you Data. 

### Process notification

```php
$notify = new GiroCheckout_SDK_Notify('giropayTransaction');
$notify->setSecret($projectPassword);
$notify->parseNotification($_GET);
```

The notification Object will work the same way as the Request Object. At  first it has to be instantiated with the transaction type ([list of all request types](http://api.girocheckout.de/en:phpsdk:phpsdk:request_types_list)) and configured with the password. 

Afterwards there has to be passed an array including the request params to the *parseNotification()* method.

