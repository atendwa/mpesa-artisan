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
