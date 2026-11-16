<?php

namespace Tripletex\Contracts;

use Tripletex\Resources\ContactResource;
use Tripletex\Resources\CountriesResource;
use Tripletex\Resources\CustomersResource;
use Tripletex\Resources\EmployeeResource;
use Tripletex\Resources\InvoicesResource;
use Tripletex\Resources\LedgerAccountsResource;
use Tripletex\Resources\OrdersResource;
use Tripletex\Resources\VatTypesResource;
use Tripletex\Resources\VouchersResource;
use Tripletex\Resources\WebhookResource;

interface Resources
{
    public function contacts(): ContactResource;

    public function countries(): CountriesResource;

    public function customers(): CustomersResource;

    public function employee(): EmployeeResource;

    public function invoices(): InvoicesResource;

    public function ledgerAccounts(): LedgerAccountsResource;

    public function orders(): OrdersResource;

    public function vatTypes(): VatTypesResource;

    public function vouchers(): VouchersResource;

    public function webhook(): WebhookResource;
}
