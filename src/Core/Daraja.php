<?php

namespace Atendwa\MpesaArtisan\Core;

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

class Daraja
{
    public function dynamicQr(): DynamicQR
    {
        return dynamic_qr();
    }

    public function stk(): STK
    {
        return stk();
    }

    public function stkQuery(): STKQuery
    {
        return stk_query();
    }

    public function registerC2BUrls(): RegisterC2BUrls
    {
        return register_c2b_urls();
    }

    public function b2c(): B2C
    {
        return b2c();
    }

    public function accountBalance(): AccountBalance
    {
        return account_balance();
    }

    public function reversal(): Reversal
    {
        return reversal();
    }

    public function transactionStatus(): TransactionStatus
    {
        return transaction_status();
    }

    public function b2BExpressCheckout(): B2BExpressCheckOut
    {
        return b2b_express_checkout();
    }

    public function businessPayBill(): BusinessPayBill
    {
        return business_pay_bill();
    }

    public function businessBuyGoods(): BusinessBuyGoods
    {
        return business_buy_goods();
    }

    public function taxRemittance(): TaxRemittance
    {
        return tax_remittance();
    }
}
