<?php

declare(strict_types=1);

use Atendwa\MpesaArtisan\Core\Daraja;
use Atendwa\MpesaArtisan\Services\AccountBalance;
use Atendwa\MpesaArtisan\Services\B2BExpressCheckOut;
use Atendwa\MpesaArtisan\Services\B2C;
use Atendwa\MpesaArtisan\Services\BusinessBuyGoods;
use Atendwa\MpesaArtisan\Services\BusinessPayBill;
use Atendwa\MpesaArtisan\Services\DynamicQR;
use Atendwa\MpesaArtisan\Services\RegisterC2BUrls;
use Atendwa\MpesaArtisan\Services\Reversal;
use Atendwa\MpesaArtisan\Services\STK;
use Atendwa\MpesaArtisan\Services\STKQuery;
use Atendwa\MpesaArtisan\Services\TaxRemittance;
use Atendwa\MpesaArtisan\Services\TransactionStatus;

if (! function_exists('daraja')) {
    function daraja(): Daraja
    {
        return new Daraja();
    }
}

if (! function_exists('dynamic_qr')) {
    function dynamic_qr(): DynamicQR
    {
        return new DynamicQR();
    }
}

if (! function_exists('stk')) {
    function stk(): STK
    {
        return new STK();
    }
}

if (! function_exists('stk_query')) {
    function stk_query(): STKQuery
    {
        return new STKQuery();
    }
}

if (! function_exists('register_c2b_urls')) {
    function register_c2b_urls(): RegisterC2BUrls
    {
        return new RegisterC2BUrls();
    }
}

if (! function_exists('b2c')) {
    function b2c(): B2C
    {
        return new B2C();
    }
}

if (! function_exists('account_balance')) {
    function account_balance(): AccountBalance
    {
        return new AccountBalance();
    }
}

if (! function_exists('reversal')) {
    function reversal(): Reversal
    {
        return new Reversal();
    }
}

if (! function_exists('transaction_status')) {
    function transaction_status(): TransactionStatus
    {
        return new TransactionStatus();
    }
}

if (! function_exists('b2b_express_checkout')) {
    function b2b_express_checkout(): B2BExpressCheckOut
    {
        return new B2BExpressCheckOut();
    }
}

if (! function_exists('business_pay_bill')) {
    function business_pay_bill(): BusinessPayBill
    {
        return new BusinessPayBill();
    }
}

if (! function_exists('business_buy_goods')) {
    function business_buy_goods(): BusinessBuyGoods
    {
        return new BusinessBuyGoods();
    }
}

if (! function_exists('tax_remittance')) {
    function tax_remittance(): TaxRemittance
    {
        return new TaxRemittance();
    }
}
