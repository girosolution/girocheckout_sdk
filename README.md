# GiroCheckout SDK

PHP development SDK for connections to GiroCheckout Payment Gateway

The GiroCockpit SDK allows a simple implementation of the GiroCheckout API. The SDK includes all API calls provided by GiroCheckout. 
For every API there is an example script in the examples section.

__Requirements__

- The SDK uses the cURL extension for server communication.
- All data must be given in UTF-8. The SDK does not take care of the conversion.
- PHP >= 5.2

__Download__

GiroCheckout SDK is available both in composer compatible form and as a standalone library.

Download the current standalone GiroCheckout PHP SDK [here](http://api.girocheckout.de/en:phpsdk:start).

Find the instructions for the composer version further down in this document.

__Important note regarding notify and redirect__

GiroCheckout uses two parallel channels for the communication between the GiroCheckout server and the Shop: The notification (or notify for short) and the redirect. The notify is a server to server call in the background, whereas the redirect runs over the customer's browser, showing him the transaction result at the end. Both paths must function separately and independently from each other, in case one of them doesn't reach its destination. This way, the transaction is also successful if the notification happens to not arrive at the shop for whatever reason (so only the redirect could be successful) or if the customer interrupts the redirection to the shop site (so only the notify gets through). But of course a check is required on both sides whether the order has already been processed in the shop, in order to avoid a duplicate processing.

Please also see [API Basics](http://api.girocheckout.de/en:girocheckout:general:start).

##### Folders

The folder "examples" includes any example script. Among them there is
an example for every API call as well as a notification and a redirect
script. The folder "GiroCheckout\_SDK" contains the
GiroCheckout\_SDK.php, which needs to be included in order to use the
SDK functionalities.

![SDK Folders](/../documentation/docfiles/SDK_git_folders.png?raw=true)

##### List of all request types (Request & Notify)

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
| [recurring credit card
payment](en:girocheckout:creditcard:start#recurring_credit_card_payment "wikilink") | creditCardRecurringTransaction        | GiroCheckout\_SDK\_CreditCardRecurringTransaction()        |
| [credit card void](en:girocheckout:creditcard:start#void "wikilink") | creditCardVoid                        | GiroCheckout\_SDK\_CreditCardVoid()                        |
| **direct debit**                                             |                                       |                                                            |
| [direct debit without payment
page](en:girocheckout:directdebit:start#direct_debit_without_payment_page "wikilink") | directDebitTransaction                | GiroCheckout\_SDK\_DirectDebitTransaction()                |
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

##### Implementation of an API call

This implementation example is based on the
"examples/giropay/giropayTransction.php" file.

#### Load SDK

`8: require_once '../../GiroCheckout_SDK/GiroCheckout_SDK.php';`

The file "GiroCheckout\_SDK.php" has to be included in an appropriate
place, to use API functionalities.

#### Configure data for authentication

`14: $merchantID = xxx;` `15: $projectID = xxx;` `16: $projectPassword =
xxx;`

These data are provided in the
[GiroCockpit](https://www.girocockpit.de "wikilink"). Ensure that the
used project ID is correct and belongs to an API call. For example you
can only use a giropay project ID for an "giropayTransaction" request.

#### API call

`20: $request = new GiroCheckout_SDK_Request('giropayTransaction');`
`21: $request->setSecret($projectPassword);` `22:
$request->addParam('merchantId',$merchantID)` `23:
->addParam('projectId',$projectID)` `24:
->addParam('merchantTxId',1234567890)` `25: ->addParam('amount',100)`
`26: ->addParam('currency','EUR')` `27:
->addParam('purpose','Beispieltransaktion')` `28:
->addParam('bic','TESTDETT421')` `29: ->addParam('info1Label','Ihre
Kundennummer')` `30: ->addParam('info1Text','0815')` `21:
->addParam('urlRedirect','`<https://www.my-domain.de/girocheckout/redirect-giropay>`')`
`22:
->addParam('urlNotify','`<https://www.my-domain.de/girocheckout/notify-giropay>`')`
`23: //the hash field is auto generated by the SDK` `24: ->submit();`

To perform a request there has to be instantiated and configurated a
request object ([list of all request
types](en:phpsdk:phpsdk:request_types_list "wikilink")). The project
password has to be given to the request object by calling the
//setSecret()// method. It is used for the hash generation. Any API
parameters, exept for the hash param, have to be set to the request
object by calling //addParam()//.

The method //submit()// performs the API call to GiroCheckout.

#### API response

<code php> 38: if($request-\>requestHasSucceeded()) 39: { 40:
$request-\>getResponseParam('rc'); 41:
$request-\>getResponseParam('msg'); 42:
$request-\>getResponseParam('reference'); 43:
$request-\>getResponseParam('redirect'); 44: 45:
$request-\>redirectCustomerToPaymentProvider(); 46: } 47: 48: /\* if the
transaction did not succeed update your local system, get the
responsecode and notify the customer \*/ 49: else { 50:
$request-\>getResponseParam('rc'); 51: $request-\>getResponsePa