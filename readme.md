# Integrate M-Pesa Effortlessly with Mpesa Artisan
[![Latest Stable Version](https://img.shields.io/packagist/v/atendwa/mpesa-artisan.svg)](https://packagist.org/packages/atendwa/mpesa-artisan)
[![Total Downloads](https://img.shields.io/packagist/dt/atendwa/mpesa-artisan.svg)](https://packagist.org/packages/atendwa/mpesa-artisan)
[![PHP Version](https://img.shields.io/packagist/php-v/atendwa/mpesa-artisan)](https://packagist.org/packages/atendwa/mpesa-artisan)
[![License](https://img.shields.io/packagist/l/atendwa/mpesa-artisan.svg)](https://packagist.org/packages/atendwa/mpesa-artisan)
[![Quality Score](https://img.shields.io/github/actions/workflow/status/atendwa/mpesa-artisan/php-cs-fixer.yml?label=Code%20Quality)](https://github.com/atendwa/mpesa-artisan/actions/workflows/php-cs-fixer.yml)
[![Code Style Status](https://img.shields.io/github/actions/workflow/status/atendwa/mpesa-artisan/php-cs-fixer.yml?label=Code%20Style)](https://github.com/atendwa/mpesa-artisan/actions/workflows/php-cs-fixer.yml)

 This Laravel package seamlessly integrates M-Pesa payment services, allowing you to effortlessly handle M-Pesa transactions within your Laravel applications. It's the perfect solution for businesses and individuals seeking a reliable mobile money integration.

-----

## Shipped with a little magic 🥳🤯
This package has a lot to offer, but I think you'll love these features the most: 

- Secure Callbacks with **IP Whitelisting**: Our `AllowWhitelistedMpesaIps` **middleware** adds an extra layer of security by verifying that the IP address sending the callback is whitelisted and valid.


- I've implemented `12/13` of M-Pesa's APIs for your convenience. The 13th API is on its way! Stay tuned for even more functionality. 🎉🚀


- Yes, you guessed it `drivers!` With this package, you can set up multiple drivers to handle different M-Pesa credentials for your app. Just add them to the mpesa.php config file, and you're good to go! 🚗💨

   ``` php
       stk()->driver('web-store')->amount(5); //... chain more methods
   
       stk()->driver('donation')->amount(80); //... chain more methods
    ```

- Our package includes useful helper classes and functions like a phone number sanitizer, a callback request class and more. Plus, most classes have corresponding global helper functions for added convenience! 🛠️🌟

   ``` php
      $sanitise = new SanitisePhoneNumber(); 
      $number = SanitisePhoneNumber::index('0712345678'); // returns 254712345678 
      
      //or
   
      $number = sanitise_phone_number('0712345678');
    ```

- And finally, why not try the `Route::callback()` **macro**? It lets you set up callback routes in a snap, right in your route file. It handles `IP whitelisting` and `removes CSRF token verification`, making integration a breeze! 🚀✨

   ``` php
    Route::callback('/some-url', [SomeClass, 'do-something'])->name('name');
    ```

-----

## Installation via Composer

1. **Run the following command in your terminal to install the package:**

   ```bash
   composer require atendwa/mpesa-artisan
   ```

2. **Publish the Configuration File**

   After installing the package, publish the configuration file using the following Artisan command:

   ```bash
   php artisan mpesa-artisan:install
   ```

   **Published Configuration File**

   The configuration file `config/mpesa.php` should look like this:

   ```bash
   <?php
   
   return [
       // This determines if the application is in 'sandbox' or 'live' mode
       'environment' => env('MPESA_ENVIRONMENT', 'sandbox'),
   
       // These are the base URLs for sandbox and live environments
       'urls' => [
           'sandbox' => env('MPESA_SANDBOX_URL', 'https://sandbox.safaricom.co.ke'),
           'live' => env('MPESA_LIVE_URL', 'https://api.safaricom.co.ke'),
       ],
   
       // These are the various API endpoints used in the application
       'endpoints' => [
           'access_token' => env('MPESA_ACCESS_TOKEN', 'oauth/v1/generate?grant_type=client_credentials'),
           'account_balance' => env('MPESA_ACCOUNT_BALANCE_ENDPOINT', 'mpesa/accountbalance/v1/query'),
           'transaction_status' => env('MPESA_TRANSACTION_STATUS', 'mpesa/transactionstatus/v1/query'),
           'c2b_register_url' => env('MPESA_C2B_REGISTER_URL_ENDPOINT', 'mpesa/c2b/v2/registerurl'),
           'business_buy_goods' => env('MPESA_BUSINESS_BUY_GOODS', 'mpesa/b2b/v1/paymentrequest'),
           'b2b_express_checkout' => env('MPESA_B2B_EXPRESS_ENDPOINT', 'v1/ussdpush/get-msisdn'),
           'business_pay_bill' => env('MPESA_BUSINESS_PAY_BILL', 'mpesa/b2b/v1/paymentrequest'),
           'mpesa_express' => env('MPESA_EXPRESS_ENDPOINT', 'mpesa/stkpush/v1/processrequest'),
           'stk_query' => env('MPESA_EXPRESS_QUERY_ENDPOINT', 'mpesa/stkpushquery/v1/query'),
           'dynamic_qr' => env('MPESA_DYNAMIC_QR_ENDPOINT', 'mpesa/qrcode/v1/generate'),
           'tax_remittance' => env('MPESA_TAX_REMITTANCE', 'mpesa/b2b/v1/remittax'),
           'reversal' => env('MPESA_REVERSAL_ENDPOINT', 'mpesa/reversal/v1/request'),
           'b2c' => env('MPESA_B2C_ENDPOINT', 'mpesa/b2c/v1/paymentrequest'),
       ],
   
       // Contains settings for different MPESA drivers
       'drivers' => [
           'default' => [
               'initiator_name' => env('MPESA_INITIATOR_NAME', ''),
               'passkey' => env('MPESA_PASSKEY', ''),
   
               'security_credential' => env('MPESA_SECURITY_CREDENTIAL', ''),
   
               'shortcodes' => [
                   'business' => env('MPESA_BUSINESS_SHORTCODE', ''),
                   'payment' => env('MPESA_PAYMENT_SHORTCODE', ''),
               ],
   
               'key_pairs' => [
                   'consumer' => [
                       'key' => env('MPESA_CONSUMER_KEY', ''),
                       'secret' => env('MPESA_CONSUMER_SECRET', ''),
                   ],
                   'payment' => [
                       'key' => env('MPESA_PAYMENT_CONSUMER_KEY', ''),
                       'secret' => env('MPESA_PAYMENT_CONSUMER_SECRET', ''),
                   ],
               ],
   
               'callbacks' => [
                   'default' => env('MPESA_DEFAULT_CALLBACK', ''),
                   'default_timeout_url' => env('MPESA_DEFAULT_TIMEOUT_URL', ''),
               ],
           ],
       ],
   
       // Additional configuration settings
       'configuration' => [
           'default_driver' => env('MPESA_DRIVER', 'default'),
           'sanitise_phone_number' => env('SANITISE_PHONE_NUMBER', true),
           'use_whitelist' => env('USE_IP_WHITELIST', true),
       ],
   
       // Cache settings for MPESA responses
       'cache' => [
           'enabled' => env('MPESA_CACHE_ENABLED', true),
           'prefix' => env('MPESA_CACHE_PREFIX', 'mpesa_artisan_cache'),
       ],
   
       // List of IPs allowed to access the application
       'whitelisted_ips' => [
           '196.201.214.200',
           '196.201.214.206',
           '196.201.213.114',
           '196.201.214.207',
           '196.201.214.208',
           '196. 201.213.44',
           '196.201.212.127',
           '196.201.212.138',
           '196.201.212.129',
           '196.201.212.136',
           '196.201.212.74',
           '196.201.212.69',
       ],
   ];
   ```

3. **Configure your .env File**

   Update your `.env` file with the necessary M-Pesa credentials:

   ```bash
   MPESA_ENVIRONMENT="live"
   MPESA_INITIATOR_NAME=""
   MPESA_PASSKEY=""
   MPESA_SECURITY_CREDENTIAL=""
   MPESA_BUSINESS_SHORTCODE=""
   MPESA_PAYMENT_SHORTCODE=""
   MPESA_CONSUMER_KEY=""
   MPESA_CONSUMER_SECRET=""
   MPESA_PAYMENT_CONSUMER_KEY=""
   MPESA_PAYMENT_CONSUMER_SECRET=""
   MPESA_DEFAULT_CALLBACK=""
   MPESA_DEFAULT_TIMEOUT_URL=""
   ```

---

## Usage
Before diving into the array of available API endpoints, let's cover how you can easily call any of the service classes.:

```php
// instantiate the class
$stk = new STK();
$response = $stk->amount(34)->post();

// use the global helper
stk()->amount(34)->post();

// use the Daraja Facade
\Atendwa\MpesaArtisan\Facades\Daraja::stk()->amount(56)->post();

// use the daraja global helper
daraja()->stk()->buyGoods()->amount(78)->post();
```

---

### Here are a few pointers to keep in mind:

- All API services provide a `driver('default')` method to change the `driver` dynamically. However, your custom driver must match the default driver's configuration keys. Exceptions will be thrown if the driver is misconfigured (e.g., the `initiator_name` key must always be present).


- All API services also offer a `useConsumerKeyPair(true)` method to toggle between key pairs. By default, `consumer key pairs` are used. Pass `false` to use **payment** keys, ensuring they match the provided shortcode. **Incorrect pairs can lock your security credentials.**


- All API services return instances of `Illuminate\Support\Collection` with keys in **camel case**. For example, `ResponseCode` in the response body will be transformed to `responseCode`.


- The `amount()` method accepts only `integers`, while other methods accept `strings`.


- **Type safety** is enforced in the package. Passing an invalid type to a method will throw an exception or use a fallback value. Empty strings may be used if an invalid string type is encountered.
 

- Different API services assume default values for the driver, key pairs, remarks, occasion, shortcode, and more, so you don't need to call every single method.
    ```php
        $response = stk_query()->checkoutRequestID($id)->post();
    ```


- Each API service specifies its **required attributes** for the payload. If any required attribute is blank, **an exception will be thrown**.


- To use a different `API version`, simply override the `endpoint URL` for the desired endpoint in your `.env` file.


- Phone numbers should be in the format `254#########`. While the package doesn't validate the values you pass, you can use the `Atendwa\MpesaArtisan\Support\SanitisePhoneNumber` class or its global helper function to help sanitize and transform phone numbers to the correct format.
    ```php
        $number = sanitise_phone_number('0712345678'); // returns 25471234578
        $number = sanitise_phone_number('+254712345678'); // returns 25471234578
        $number = sanitise_phone_number('254712345678'); // returns 25471234578
    ```
---

### 1. Dynamic QR
Use this API to generate a Dynamic QR code, enabling Safaricom M-PESA customers with the My Safaricom App or M-PESA app to scan the QR code. They can then capture the till number and amount and authorize payment for goods and services at select LIPA NA M-PESA (LNM) merchant outlets.

https://developer.safaricom.co.ke/APIs/DynamicQRCode

```php
$response = dynamic_qr()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->amount(100) // Required: sets the 'Amount' attribute
                ->buyGoods() // Optional: defaults the TrxCode attribute to 'BG'
                // ->paybill() sets TrxCode to 'PB'
                // ->sendMoney() sets TrxCode to 'SM'
                // ->sendToBusiness() sets TrxCode to 'SB'
                // ->withdrawFromAgent() sets TrxCode to 'WA'
                ->size(400) // Optional: default is 300
                ->merchantName('atendwa') // Required: sets the 'MerchantName' attribute
                ->reference('buy me a coffee') // Required: sets the 'RefNo' attribute
                ->creditPartyIdentifier('123456') // Required: sets the 'CreditPartyIdentifier (CPI)' attribute
                ->post();
```

---

### 2. M-Pesa Express Simulate (STK Push)
The Lipa na M-PESA online API, also known as M-PESA Express (STK Push/NI push), facilitates Merchant/Business-initiated C2B (Customer to Business) payments.

https://developer.safaricom.co.ke/APIs/MpesaExpressSimulate

```php
$response = stk()
        ->driver('default') // Optional: Specify a custom driver
        ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
        ->partyB('1234567') // Optional: Specify a shortcode, defaults to the business shortcode
        ->buyGoods() // Optional: Choose between 'buyGoods' or 'payBill', defaults to 'buyGoods'
        // ->payBill() // Optional: Choose between 'buyGoods' or 'payBill', defaults to 'buyGoods'
        ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
        ->phoneNumber('254712345678') // Required: Specify the customer's phone number
        ->amount(1) // Required: Specify the amount to be transacted
        ->reference('test') // Required: Specify an account reference
        ->description('test') // Required: Specify a transaction description
        ->post();
```

---

### 3. M-Pesa Express Query (STK Query)
Use this API to check the status of a Lipa Na M-Pesa Online Payment.

https://developer.safaricom.co.ke/APIs/MpesaExpressQuery

```php
$response = stk_query()
        ->driver('default')  // Optional: defaults to 'default'
        ->useConsumerKeyPair(true) // Optional: defaults to true
        ->shortCode('1234567') // Optional: the package will attempt to use the business shortcode if not set
        ->checkoutRequestID($someID) // Required: The CheckoutRequestID from the STK push response
        ->post();
```

---

### 4. Customer To Business Register URL
The Register URL API complements the Customer to Business (C2B) APIs by enabling the receipt of payment notifications to your paybill. This API allows you to register callback URLs through which you will receive notifications for payments made to your pay bill/till number.

https://developer.safaricom.co.ke/APIs/CustomerToBusinessRegisterURL

```php
$response = register_c2b_urls()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret                
                ->shortCode('123456') // Required: Specify the short code
                ->completed() // Optional: the ResponseType is 'Completed' by default
                // ->cancelled() // Optional: sets the ResponseType attribute to 'Cancelled'
                ->confirmationUrl('https://tendwa.dev/package-sale/confirm') // Required: Specify the confirmation URL
                ->validationUrl('https://tendwa.dev/package-sale/validate') // Required: Specify the validation URL
                ->post();
```

---

### 5. Business To Customer (B2C)
The B2C API allows businesses to make payments directly to customers, such as salary payments, cashback, promotional payments, winnings, withdrawals, and loan disbursements.

https://developer.safaricom.co.ke/APIs/BusinessToCustomer

```php
$response = b2c()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(false) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->partyA('123456')
                ->partyB('254712345678')
                ->initiator('123456') // Optional: defaults to the initiator name in the config file
                ->amount(100) // Required: Specify the amount. Must be > 50 for safaricom to process the request
                ->remarks('test') // Required: Specify the transaction remarks
                ->occasion('test') // Required: Specify the transaction occasion
                ->post()
```

---

### 6. Transaction Status
Check the status of a transaction.

https://developer.safaricom.co.ke/APIs/TransactionStatus

```php
$response = transaction_status()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(false) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->initiator('initiator') // Optional: defaults to the initiator name in the config file
                ->partyA('1234567')
                ->transactionID('NEF61H8J60') // Optional: use this if you have a transaction ID
                // ->originatorConversationID('AG_20190826_0000777ab7d848b9e721') // Optional: use this if you don't have a transaction ID
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->remarks('Transaction status request.') // Optional: defaults to 'Transaction status request.'
                ->occasion('Transaction status request.') // Optional: defaults to 'Transaction status request.'
                ->post();
```

---

### 7. Account Balance
The Account Balance API is used to request the balance of a short code, applicable to B2C, buy goods, and pay bill accounts.

https://developer.safaricom.co.ke/APIs/AccountBalance

```php
$response = account_balance()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->partyA('123456')
                ->remarks('Get account balance.') // Optional: defaults to 'Get account balance.'
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->post();
```

---

### 8. Reversals
https://developer.safaricom.co.ke/APIs/Reversal

```php
$response = reversal()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->occasion('Transaction reversal request.') // Required: Specify the occasion transaction or defaults to 'Transaction reversal request.'.
                ->remarks('Transaction reversal request.') // Required: Specify the occasion transaction or defaults to 'Transaction reversal request.'. 
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->initiator('initiator') // Optional: defaults to the initiator name in the config file
                ->receiverParty('1234567')
                ->amount(100) // Required: Specify the amount
                ->transactionID('NEF61H8J60') // Optional: use this if you have a transaction ID
                ->post();
```

---

### 9. Tax Remittance
https://developer.safaricom.co.ke/APIs/TaxRemittance

```php
$response = tax_remittance()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->initiator('initiator') // Optional: defaults to the initiator name in the config file
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->partyA('1234567') // Required: Specify the shortcode
                ->partyB('572572') // Required: Specify the shortcode
                ->amount(100) // Required: Specify the amount
                ->remarks('Tax Remittance') // Optional: defaults to 'Tax Remittance'
                ->reference('Tax Remittance') // Optional: defaults to 'Tax Remittance'
                ->post();
```

---

### 10. Business Pay Bill
https://developer.safaricom.co.ke/APIs/BusinessPayBill

```php
$response = business_pay_bill()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->initiator('initiator') // Optional: defaults to the initiator name in the config file
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->partyA('1234567') // Required: Specify the shortcode
                ->partyB('572572') // Required: Specify the shortcode
                ->amount(100) // Required: Specify the amount
                ->remarks('Business Payment') // Optional: defaults to 'Business Payment'
                ->reference('Business Payment') // Optional: defaults to 'Business Payment'
                ->post();
```

---

### 11. Business Buy Goods
https://developer.safaricom.co.ke/APIs/BusinessBuyGoods

```php
$response = business_buy_goods()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->initiator('initiator') // Optional: defaults to the initiator name in the config file
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->timeoutUrl('https://tendwa.dev') // Required: Specify the timeout URL
                ->partyA('1234567') // Required: Specify the shortcode
                ->partyB('572572') // Required: Specify the shortcode
                ->amount(100) // Required: Specify the amount
                ->remarks('Business Payment') // Optional: defaults to 'Business Payment'
                ->reference('Business Payment') // Optional: defaults to 'Business Payment'
                ->post();
```

---

### 12. B2B Express CheckOut
https://developer.safaricom.co.ke/APIs/B2BExpressCheckout

```php
$response = b2b_express_checkout()
                ->driver('default') // Optional: Specify a custom driver
                ->useConsumerKeyPair(true) // Optional: Toggle key pairs, defaults to true for consumer key and secret
                ->primaryShortCode('1234567') // Required: Specify the primary short code
                ->receiverShortCode('572572') // Required: Specify the receiver short code
                ->amount(100) // Required: Specify the amount
                ->reference('Business Payment') // Required: Specify the reference
                ->callbackUrl('https://tendwa.dev') // Required: Specify the callback URL
                ->requestRefID($someUniqueID) // Required
                ->partnerName($yourStoreName) // Required
                ->post();
```
----

## Helpers
Check out some of the handy helper classes included in the package:


### **Mpesa Callback Request (MpesaCallbackRequest::class)**

This class extends Laravel's Http Request class with additional features for parsing M-Pesa callback results and checking transaction success status.

- All methods from the `Illuminate\Http\Request` class are available.


- The `fetchResponse()` method automatically parses the response body, allowing you to directly access the result code without needing to navigate through nested arrays for different callback types (e.g., STK, B2C).
 
```php
use Atendwa\MpesaArtisan\Http\Requests\MpesaCallbackRequest;

public function handleStkCallback(MpesaCallbackRequest $request)
{
    $response = $request->fetchResponse(); // returns the response body as a collection
    $response->get('resultCode'); // returns the result code from the response body
    
    // for stk push
    $response->get('merchantRequestID');

    // for b2c
    $response->get('TransactionID'); // returns the result code from the response body
    
    $request->log(); // logs the response to your logging system with the info level

    $success = $request->successful(); // returns a boolean indicating if the transaction was successful by checking the result code
}
```

----

### **Sanitise Phone Number (SanitisePhoneNumber::class)**

This class sanitizes phone numbers, transforming them to the desired format. It has a single method, `index`, which accepts a phone number and returns the sanitized version.
        
```php
$number = sanitise_phone_number('0712345678'); // returns 254712345678
```

----

### **Parse Response (ParseResponse::class)**

This class parses API responses from Safaricom. It has a single method, `index`, which accepts a `response` and returns a **parsed version**. The parsed response will have **camel case keys**, `successfulResponse` and `successfulResult` indicators for success, and a `hasErrors` key for errors. This class is used internally to ensure consistent response parsing.
    
  ```php
  $response = parse_response(stk()->post());

  $response->get('successfulResponse');  // returns true if the response was successful

  $response->get('responseCode');
  ```
