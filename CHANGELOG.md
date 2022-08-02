# GiroCheckout SDK Change Log

All notable changes to this project will be documented in this file.

#### 2.4.8 - 02.08.2022
- Support for the payment page parameter giropayAllowMissingFields for internal use.

#### 2.4.7 - 01.07.2022
- Added support for new optional Kassenzeichen parameter for all payment methods

#### 2.4.6 - 15.06.2022
- Bugfix regarding handling of mandatory fields

#### 2.4.5 - 20.04.2022
- Support for new giropay payments via Paydirekt

#### 2.4.4 - 25.02.2022
- Support for PayPal reservation (auth) and capture.

#### 2.4.3 - 16.02.2022
- Support for PayPal refund.

#### 2.4.2 - 31.01.2022
- Support for refund, capture and info for payment page transactions using the payment page reference.
- Fix in handling of error when capture, refund or void fails.

#### 2.4.1.11 - 11.11.2021
- Support for the API call senderInfo
- Purpose parameter in credit card capture

#### 2.4.1.9 - 21.07.2021
- Compatibility with PHP up to 7.4.x

#### 2.4.1.8 - 06.07.2021
- Introduced new paypage parameter informationText.

#### 2.4.1.7 - 04.06.2021
- Replaced old paydirekt logos with new giropay/paydirekt ones.

#### 2.4.1.6 - 27.04.2021
- Added the fields for direct debit mandates to payment page.

#### 2.4.1.5 - 22.01.2021
- Added the fields for donation certificate info to direct debit payment call.

#### 2.4.1.4 - 18.12.2020
- Removed email parameter for 3-D Secure 2.0.

#### 2.4.1.3 - 11.12.2020
- Added error codes for 3-D Secure 2.0 cases.

#### 2.4.1.2 - 04.12.2020
- Added support for 3-D Secure 2.0 to payment page calls.

#### 2.4.1.1 - 01.12.2020
- Fixed a bug in the new function testApiCredentials.

#### 2.4.1 - 24.11.2020
- Added new function for testing API credentials: GiroCheckout_SDK_Tools::testApiCredentials().
- Added optional fields for 3-D Secure 2.0 to creditcard API (available on backend from December 2020) 

#### 2.2.33 - 31.08.2020
- Added support for new API parameter timeout. 

#### 2.2.32.1 - 25.05.2020
- Improved  setServer method. 

#### 2.2.32 - 21.04.2020
- API parameter amount for payment page is not optional when pagetype=2 (donation) and freeamount=1 or fixedvalues not empty.

#### 2.2.31.8 - 02.04.2020
- Added Paypal logo
- Added optional donation certificate parameters to finalizeform call

#### 2.2.31.1 - 30.01.2020
- Spelling corrections in error messages

#### 2.2.31 - 17.01.2020
- Added support for parameter otherpayments. 

#### 2.2.30b - 07.12.2019
- Added parameter to Request class to allow for easier use of development server.
- Fixed Paydirekt cart class to make sure numeric values are not returned as strings in the JSON.

#### 2.2.29 - 18.10.2019
- Added support for the new credit card iframe form calls initform and finalizeform

#### 2.2.28 - 11.09.2019
- Provides a function to obtain the payment method logo name
- Introduces constants for the transaction types

#### 2.2.27 - 21.08.2019
- Added parameter certdata for donation certificate in paypage service.
- New call for paypage donation certificate implemented.

#### 2.2.26 - 09.07.2019
- Corrected Bluecode spelling
- Added check if function curl_exec is present and enabled

#### 2.2.25 - 28.05.2019
- Finalized support for Bluecode e-commerce payment method

#### 2.2.24 - 12.04.2019
- Return better error messages when authentication data is invalid.
- Improved error returns and better handling of empty return values.

