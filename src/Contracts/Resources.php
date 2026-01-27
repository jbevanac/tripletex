<?php

namespace Tripletex\Contracts;

use Tripletex\Resources\ContactResource;
use Tripletex\Resources\CountriesResource;
use Tripletex\Resources\CustomersResource;
use Tripletex\Resources\DebugResource;
use Tripletex\Resources\InvoicesResource;
use Tripletex\Resources\OrdersResource;

interface Resources
{
    public function contacts(): ContactResource;

    public function countries(): CountriesResource;

    public function customers(): CustomersResource;

    public function debug(): DebugResource;

    public function invoices(): InvoicesResource;

    public function orders(): OrdersResource;
}
