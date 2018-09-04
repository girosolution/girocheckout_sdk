# girocheckout_SDK
PHP development SDK for connections to GiroCheckout Payment Gateway

The GiroCockpit SDK allows a simple implementation of the GiroCheckout API. The SDK includes all API calls provided by GiroCheckout. 
For every API there is an example script in the examples section.

__Requirements__

- The SDK uses the cURL extension for server communication.
- All data must be given in UTF-8. The SDK does not take care of the conversion.
- PHP >= 5.2

__Download__

Download the current GiroCheckout PHP SDK here: http://api.girocheckout.de/en:phpsdk:start

__Important note regarding notify and redirect__

GiroCheckout uses two parallel channels for the communication between the GiroCheckout server and the Shop: The notification (or notify for short) and the redirect. The notify is a server to server call in the background, whereas the redirect runs over the customer's browser, showing him the transaction result at the end. Both paths must function separately and independently from each other, in case one of them doesn't reach its destination. This way, the transaction is also successful if the notification happens to not arrive at the shop for whatever reason (so only the redirect could be successful) or if the customer interrupts the redirection to the shop site (so only the notify gets through). But of course a check is required on both sides whether the order has already been processed in the shop, in order to avoid a duplicate processing.

Please also see API Basics (http://api.girocheckout.de/en:girocheckout:general:start).
