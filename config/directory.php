<?php

return [
    '1037' => [
        'cause' => 'No response from the user',
        'solution' => 'Simply retry again after receiving the callback. Make sure to notify the user that the request failed.',
    ],

    '1025' => [
        'cause' => 'An error occurred while sending a push request',
        'solution' => 'Retry the request, and make sure your system is working as expected.',
    ],
    '1032' => [
        'cause' => 'The request was canceled by the user',
        'solution' => 'Depending on the scenario, either inform the user that they did not respond or just cancel the transaction, then try again.',
    ],

    '1' => [
        'cause' => 'The balance is insufficient for the transaction.',
        'solution' => 'Advise customer to deposit funds on their M-PESA or use Overdraft(Fuliza) when prompted',
    ],
    '2001' => [
        'cause' => 'The initiator information is invalid.',
        'solution' => 'Use correct user credentials Subscriber to key in the correct M-PESA pin',
    ],

    '1019' => [
        'cause' => 'Transaction has expired',
        'solution' => 'The transaction has taken a long before being processed within the allowable time',
    ],
    '1001' => [
        'cause' => 'Unable to lock subscriber, a transaction is already in process for the current subscriber',
        'solution' => 'The user has an ongoing USSD Session.',
    ],

    '500.001.1001' => [
        'cause' => 'Regenerate a new token and use it before expiry, if you are copy-pasting manually make sure you’ve pasted the correct access token.',
        'solution' => 'Retry again after sometime',
    ],
    '404.001.04' => [
        'cause' => 'The transaction is still being processed, please wait for the response.',
        'solution' => 'All M-PESA API requests on the Daraja platform are POST requests except Authorization API which is a GET request.',
    ],

    '400.002.05' => [
        'cause' => 'Invalid Authentication Header.',
        'solution' => 'Make sure you are submitting the correct request payload as shown in the sample request body for all the APIs, to avoid typo errors.',
    ],
    '400.003.01' => [
        'cause' => 'Your request body is not properly drafted.',
        'solution' => 'Regenerate a new token and use it before expiry, if you are copy-pasting manually make sure you’ve pasted the correct access token.',
    ],
];
