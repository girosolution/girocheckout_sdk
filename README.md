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

Find the instructions for the composer version below.

## Installation through composer

In order for this to work, you need to install composer.  Please follow the instructions on the [Composer website](https://getcomposer.org/doc/00-intro.md) for this, but in a nutshell it's this (in a Linux or iOS environment):

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

You should then make it available globally:

```bash
mv composer.phar /usr/local/bin/composer
```

Remember to give the file execution permissions.

Now, simply include GiroCheckout in your PHP project:

```bash
composer clear-cache
composer require girosolution/girocheckout-sdk
```

This will create a composer.json file in your project (if you don't already have one), add the lines necessary to include GiroCheckout and then download and install it in the vendor folder.

## Update through composer

If you already have a previous composer-based version of the SDK installed, you may update to the latest published version like this:

```bash
composer update
```



## __Important note regarding notify and redirect__

GiroCheckout uses two parallel channels for the communication between the GiroCheckout server and the Shop: The notification (or notify for short) and the redirect. The notify is a server to server call in the background, whereas the redirect runs over the customer's browser, showing him the transaction result at the end. Both paths must function separately and independently from each other, in case one of them doesn't reach its destination. This way, the transaction is also successful if the notification happens to not arrive at the shop for whatever reason (so only the redirect could be successful) or if the customer interrupts the redirection to the shop site (so only the notify gets through). But of course a check is required on both sides whether the order has already been processed in the shop, in order to avoid a duplicate processing.

Please also see [API Basics](http://api.girocheckout.de/en:girocheckout:general:start).

## Folders

The folder "examples" includes example scripts for all supported payment methods and API calls.  The folder "logos" contains the current logo images for all payment methods.

<img src="https://github.com/girosolution/girocheckout_sdk/blob/documentation/docfiles/SDK_git_folders.png" width="400">

## List of all request types (Request & Notify)

| API documentation                                                                                                             | Request type                          | Object name                                                |
|-------------------------------------------------------------------------------------------------------------------------------|---------------------------------------|------------------------------------------------------------|
| **eps**                                                                                                                       |
| [check eps bank status](en:girocheckout:eps:start#check_bankstatus "wikilink")                                                | epsBankstatus                         | GiroCheckout\_SDK\_EpsBankstatus()                         |
| [eps issuer list](en:girocheckout:eps:start#eps_issuer_bank_request "wikilink")                                               | epsIssuerList                         | GiroCheckout\_SDK\_EpsIssuerList()                         |
| [eps transaction](en:girocheckout:eps:start#initialise_eps_payment "wikilink")                                                | epsTransaction                        | GiroCheckout\_SDK\_EpsTransaction()                        |
| **iDEAL**                                                                                                                     |                                       |                                                            |
| [iDEAL get issuer list](en:girocheckout:ideal:start#ideal_issuer_bank_request "wikilink")                                     | idealIssuerList                       | GiroCheckout\_SDK\_IdealIssuerList()                       |
| [iDEAL transaction](en:girocheckout:ideal:start#initialise_ideal_payment "wikilink")                                          | idealPayment                          | GiroCheckout\_SDK\_IdealPayment()                          |
| **credit card**                                                                                                               |                                       |                                                            |
| [credit card payment](en:girocheckout:creditcard:start#initialise_credit_card_payment "wikilink")                             | creditCardTransaction                 | GiroCheckout\_SDK\_CreditCardTransaction()                 |
| [get PKN](en:girocheckout:creditcard:start#pseudo_card_number_pkn "wikilink")                                                 | creditCardGetPKN                      | GiroCheckout\_SDK\_CreditCardGetPKN()                      |
| [recurring credit card payment](en:girocheckout:creditcard:start#recurring_credit_card_payment "wikilink")                    | creditCardRecurringTransaction        | GiroCheckout\_SDK\_CreditCardRecurringTransaction()        |
| [credit card void](en:girocheckout:creditcard:start#void "wikilink")                                                          | creditCardVoid                        | GiroCheckout\_SDK\_CreditCardVoid()                        |
| **direct debit**                                                                                                              |                                       |                                                            |
| [direct debit without payment page](en:girocheckout:directdebit:start#direct_debit_without_payment_page "wikilink")           | directDebitTransaction                | GiroCheckout\_SDK\_DirectDebitTransaction()                |
| [direct debit payment page](en:girocheckout:directdebit:start#initialise_direct_debit_payment_with_payment_page "wikilink")   | directDebitTransactionWithPaymentPage | GiroCheckout\_SDK\_DirectDebitTransactionWithPaymentPage() |
| [direct debit void](en:girocheckout:directdebit:start#void "wikilink")                                                        | directDebitVoid                       | GiroCheckout\_SDK\_DirectDebitVoid()                       |
| **Maestro**                                                                                                                   |                                       |                                                            |
| [Maestro payment](en:girocheckout:maestro:start#initialize_maestro_payment "wikilink")                                        | maestroTransaction                    | GiroCheckout\_SDK\_MaestroTransaction()                    |
| [Maestro capture](en:girocheckout:maestro:start#capture "wikilink")                                                           | maestroCapture                        | GiroCheckout\_SDK\_MaestroCapture()                        |
| [Maestro refund](en:girocheckout:maestro:start#refund "wikilink")                                                             | maestroRefund                         | GiroCheckout\_SDK\_MaestroRefund()                         |
| **Payment Page Transaktion**                                                                                                  |                                       |                                                            |
| [Payment through Payment Page](en:girocheckout:paypage:start#payment_initialization_through_the_payment_page "wikilink")      | paypageTransaction                    | GiroCheckout\_SDK\_PaypageTransaction()                    |
| [Project request](en:girocheckout:paypage:start#project_request "wikilink")                                                   | paypageProjects                       | GiroCheckout\_SDK\_PaypageProjects()                       |
| **PayPal**                                                                                                                    |                                       |                                                            |
| [PayPal transaction](en:girocheckout:paypal:start#initialise_paypal_payment "wikilink")                                       | paypalTransaction                     | GiroCheckout\_SDK\_PaypalTransaction()                     |
| **Direktüberweisung**                                                                                                         |                                       |                                                            |
| [Direktüberweisung transaction](en:girocheckout:direktubw:start#initializing_a_payment "wikilink")                            | direktubwTransaction                  | GiroCheckout\_SDK\_DirektubwTransaction()                  |
| **Klarna**                                                                                                                    |                                       |                                                            |
| [Klarna payment or preauthorization](en:girocheckout:klarna:start#initialization_of_a_klarna_payment "wikilink")              | klarnaTransaction                     | GiroCheckout\_SDK\_KlarnaTransaction()                     |
| [Klarna capture](en:girocheckout:klarna:start#booking_capture "wikilink")                                                     | KlarnaCapture                         | GiroCheckout\_SDK\_KlarnaCapture()                         |
| [Klarna refund](en:girocheckout:klarna:start#refund_refund "wikilink")                                                        | KlarnaRefund                          | GiroCheckout\_SDK\_KlarnaRefund()                          |
| [Klarna reversal/void](en:girocheckout:klarna:start#cancellation_void "wikilink")                                             | KlarnaVoid                            | GiroCheckout\_SDK\_KlarnaVoid()                            |
| **Apple Pay**                                                                                                                 |                                       |                                                            |
| [Apple Pay Form payment or preauthorization](en:girocheckout:applepay:start#initialization_of_a_apple_pay_payment "wikilink") | applePayTransaction                   | GiroCheckout\_SDK\_ApplePayTransaction()                   |
| [Apple Pay capture](en:girocheckout:applepay:start#booking_capture "wikilink")                                                | applePayCapture                       | GiroCheckout\_SDK\_ApplePayCapture()                       |
| [Apple Pay refund](en:girocheckout:applepay:start#refund_refund "wikilink")                                                   | applePayRefund                        | GiroCheckout\_SDK\_ApplePayRefund()                        |
| [Apple Pay reversal/void](en:girocheckout:applepay:start#cancellation_void "wikilink")                                        | applePayVoid                          | GiroCheckout\_SDK\_ApplePayVoid()                          |
| **Google Pay**                                                                                                                |                                       |                                                            |
| [Google Pay payment or preauthorization](en:girocheckout:klarna:start#initialization_of_a_klarna_payment "wikilink")          | googlePayTransaction                  | GiroCheckout\_SDK\_GooglePayTransaction()                  |
| [Google Pay capture](en:girocheckout:klarna:start#booking_capture "wikilink")                                                 | googlePayCapture                      | GiroCheckout\_SDK\_GooglePayCapture()                      |
| [Google Pay refund](en:girocheckout:klarna:start#refund_refund "wikilink")                                                    | googlePayRefund                       | GiroCheckout\_SDK\_GooglePayRefund()                       |
| [Google Pay reversal/void](en:girocheckout:klarna:start#cancellation_void "wikilink")                                         | googlePayVoid                         | GiroCheckout\_SDK\_GooglePayVoid()                         |
| **WERO**                                                                                                                      |                                       |                                                            |
| [WERO transaction](en:girocheckout:wero:start#initializing_a_payment "wikilink")                                              | weroTransaction                       | GiroCheckout\_SDK\_WeroTransaction()                       |
| **Tools**                                                                                                                     |                                       |                                                            |
| [get transaction information](en:tools:transaction_status "wikilink")                                                         | getTransactionTool                    | GiroCheckout\_SDK\_Tools\_GetTransaction()                 |

## Implementation of an API call

This implementation example is based on the "examples/creditcard/creditcardTransaction.php" file.

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
$request = new GiroCheckout_SDK_Request('creditcardTransaction');
$request->setSecret($projectPassword);
$request->addParam('merchantId',$merchantID)
	->addParam('projectId',$projectID)
	->addParam('merchantTxId',1234567890)
	->addParam('amount',100)
	->addParam('currency','EUR')
	->addParam('purpose','Beispieltransaktion')
	->addParam('urlRedirect','https://www.my-domain.de/girocheckout/redirect')
	->addParam('urlNotify','https://www.my-domain.de/girocheckout/notify')
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

As stated above, the file "autload.php" has to be included in an appropriate place, to use API functionalities. It is located inside the vendor folder created by composer.  So make sure the path to it is correct.

You may also want to add a "use" statement for every GiroCheckout class you use.  GiroCheckout_SDK_Request will always be used at least. 

### Configure data for authentication

```php
$projectPassword = xxx;
```

The password is provided in the [GiroCockpit](https://www.girocockpit.de). It is used for the hash comparison, to ensure that the data is coming from GiroCheckout.

### Process notification

```php
$notify = new GiroCheckout_SDK_Notify('creditcardTransaction');
$notify->setSecret($projectPassword);
$notify->parseNotification($_GET);
```

The notification object works the same way as the request object. First it has to be instantiated with the transaction type ([list of all request types](http://api.girocheckout.de/en:phpsdk:phpsdk:request_types_list)) and configured with the password. 

Afterwards an array needs to be passed to the *parseNotification()* method that holds the request parameters .

### Handle notification

```php
if($notify->paymentSuccessful()) {
  $notify->getResponseParam('gcReference');
  $notify->getResponseParam('gcMerchantTxId');
  $notify->getResponseParam('gcBackendTxId');
  $notify->getResponseParam('gcAmount');
  $notify->getResponseParam('gcCurrency');
  $notify->getResponseParam('gcResultPayment');

  if($notify->avsSuccessful()) {
    $notify->getResponseParam('gcResultAVS');
  }
  
  $notify->sendOkStatus();
  exit;
}
else {
  $notify->getResponseParam('gcReference');
  $notify->getResponseParam('gcMerchantTxId');
  $notify->getResponseParam('gcBackendTxId');
  $notify->getResponseParam('gcResultPayment');

  $notify->sendOkStatus();
  exit;
}
```

The method *paymentSuccessful()* returns true, if the payment has succeeded. Any response parameter can be obtained via the *getResponseParam()* method. 

*sendOkStatus()*, *sendBadRequestStatus()* and *sendOtherStatus()* may be used to respond to the request by sending the appropriate header. 

| HTTP status code  | Method                   | Description                                                  |
| ----------------- | ------------------------ | ------------------------------------------------------------ |
| 200 (OK)          | *sendOkStatus()*         | The notification was processed correctly.                    |
| 400 (Bad Request) | *sendBadRequestStatus()* | The merchant did not process the notification and does not wish to be notified again. |
| all others        | *sendOtherStatus()*      | The notification is repeated no more than 10 times every 30 minutes until the merchant returns the status code 200 or 400. |

## Changing the Server Endpoint

In special cases it may be necessary to access a different server for development and tests than the default <https://payment.girosolution.de>. Should you have received another endpoint URL from Girosolution, there is a way of overriding the default server. 

You may do this in one of three ways:

1) In your PHP Code: 

```php
apache_setenv( "GIROCHECKOUT_SERVER", "https://other.endpoint.de" );
```

2) On the Linux command line (e.g. for executing the SDK examples without a browser): 

```bash
export GIROCHECKOUT_SERVER=https://other.endpoint.de
```

3) In the Apache configuration (within the VirtualHost section): 

```
SetEnv GIROCHECKOUT_SERVER "https://other.endpoint.de"
```

## Operation via a proxy server

It is possible to operate the server communication via a proxy, if your environment requires to do so. To implement this, include the following code and modify the parameters accordingly, before the GiroCheckout_SDK_Request::submit() function is  called: 

```php
$Config = GiroCheckout_SDK_Config::getInstance();
$Config->setConfig('CURLOPT_PROXY', 'http://myproxy.com'):
$Config->setConfig('CURLOPT_PROXYPORT', 9090);
$Config->setConfig('CURLOPT_PROXYUSERPWD', 'myuser:mypasswd');
```

## Debugging

The SDK offers the possibility of debugging an API call. In order to use this, you need to define a constant which has to be set to “true”: 

```php
define('__GIROCHECKOUT_SDK_DEBUG__',true);
```

Now the SDK will write a log file which is located in  “GiroCheckout_PHP_SDK/log” by default. The webserver needs to have write permissions to this folder. The debug mode should only be used while debugging issues and should be deactivated again afterwards for security and performance reasons. 

### Accessing the logfile

The logfile is organized into different sections: 

| Section      | Description                                                | Common issues                |
| ------------ | ---------------------------------------------------------- | ---------------------------- |
| start        | Gives the timestamp when the script was loaded             |                              |
| PHP ini      | Provides information about PHP, cURL and SSL               | cURL or SSL is not activated |
| transaction  | Shows the used API call                                    |                              |
| params set   | Shows any parameters that were given to the request object | parameters are missing       |
| cURL request | Includes any parameters that are sent to GiroCheckout      |                              |
| cURL reply   | cURL information about the server reply                    |                              |
| reply params | Any parameters in the server's reply                       |                              |
| notify input | Information about the notify call (parameters, timestamp)  |                              |
| reply params | Information about the used reply method                    |                              |
| exception    | Includes the error description                             |                              |

### Set certificate file

In a Windows server environment, it might happen that cURL is not able to validate the SSL certificate. In such a case, it is necessary to pass cURL a specific certificate file. The SDK provides the possibility of setting a local certificate file. For this, the following code is needed **before the $request→submit() method** is called: 

```php
$request->setSslCertFile('path/to/certificate');
```

For testing purposes, the certificate validation can be disabled. Please do not use this in your live environment.  

```php
$request->setSslVerifyDisabled();
```



## 

