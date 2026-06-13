<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\Invoice;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ListResponse;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class InvoicesResource implements ResourceInterface
{
    private const string PATH = 'invoice';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateListResponse;
    use CanCreateResource;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @param array{
     *     invoiceDate: string,
     *     invoiceNumber?: int,
     *     customer?: int,
     *     invoiceDueDate?: string,
     *     kid?: string,
     *     comment?: string,
     *     orders?: array,
     *     orderLines?: array,
     *     travelReports?: array,
     *     projectInvoiceDetails?: array,
     *     voucher?: int,
     *     currency?: int,
     *     postings?: array,
     *     reminders?: array,
     *     invoiceRemark?: int,
     *     paymentTypeId?: int,
     *     paidAmount?: float,
     * } $data
     * @throws TripletexException
     */
    public function create(array $data): Invoice|ErrorResponse
    {
        $invoice = Invoice::make($data);

        return $this->createResource(
            model: $invoice,
            path: self::PATH,
        );
    }

    /**
     * @param array{
     *     version?: int,
     *     invoiceDate?: string,
     *     invoiceNumber?: int,
     *     customer?: int,
     *     invoiceDueDate?: string,
     *     kid?: string,
     *     comment?: string,
     *     orders?: array,
     *     orderLines?: array,
     *     travelReports?: array,
     *     projectInvoiceDetails?: array,
     *     voucher?: int,
     *     currency?: int,
     *     postings?: array,
     *     reminders?: array,
     *     invoiceRemark?: int,
     *     paymentTypeId?: int,
     *     paidAmount?: float,
     * } $data
     * @throws TripletexException
     */
    public function update(int $id, array $data): Invoice|ErrorResponse
    {
        return $this->updateResource(
            model: Invoice::make($data),
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id): Invoice|ErrorResponse
    {
        return $this->findResource(
            modelClass: Invoice::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Invoice::class,
            path: self::PATH,
            filters: $filters,
        );
    }
}
