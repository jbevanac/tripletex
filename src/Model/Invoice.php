<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class Invoice implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?int $invoiceNumber = null,
        public ?string $invoiceDate = null,
        public ?Customer $customer = null,
        public ?int $creditedInvoice = null,
        public ?bool $isCredited = null,
        public ?string $invoiceDueDate = null,
        public ?string $kid = null,
        public ?string $invoiceComment = null,
        public ?string $comment = null,
        public ?array $orders = null,
        public ?array $orderLines = null,
        public ?array $travelReports = null,
        public ?array $projectInvoiceDetails = null,
        public ?Reference $voucher = null,
        public ?string $deliveryDate = null,
        public ?float $amount = null,
        public ?float $amountCurrency = null,
        public ?float $amountExcludingVat = null,
        public ?float $amountExcludingVatCurrency = null,
        public ?float $amountRoundoff = null,
        public ?float $amountRoundoffCurrency = null,
        public ?float $amountOutstanding = null,
        public ?float $amountCurrencyOutstanding = null,
        public ?float $amountOutstandingTotal = null,
        public ?float $amountCurrencyOutstandingTotal = null,
        public ?float $sumRemits = null,
        public ?Reference $currency = null,
        public ?bool $isCreditNote = null,
        public ?bool $isCharged = null,
        public ?bool $isApproved = null,
        public ?array $postings = null,
        public ?array $reminders = null,
        public ?string $invoiceRemarks = null,
        public ?Reference $invoiceRemark = null,
        public ?int $paymentTypeId = null,
        public ?float $paidAmount = null,
        public ?bool $isPeriodizationPossible = null,
        public ?int $documentId = null,
        public ?string $ehfSendStatus = null,
    ) {
    }
}
