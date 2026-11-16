<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\ListResponse;
use Tripletex\Model\Posting;
use Tripletex\Model\Voucher;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanDeleteResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

final class VouchersResource implements ResourceInterface
{
    private const string PATH = 'ledger/voucher';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateListResponse;
    use CanDeleteResource;
    use CanFindResource;
    use CanListResource;

    /**
     * With $sendToLedger false the voucher is saved as a draft for someone to review and book in Tripletex.
     *
     * @param Voucher|array{
     *     date: string,
     *     description: string,
     *     postings: list<Posting|array>,
     *     externalVoucherNumber?: string,
     *     voucherType?: int|array{id: int},
     * } $voucher
     *
     * @throws TripletexException
     */
    public function create(Voucher|array $voucher, bool $sendToLedger = true): Voucher|ErrorResponse
    {
        if (is_array($voucher)) {
            $voucher = Voucher::make($voucher);
        }

        if (!$this->isBalanced($voucher)) {
            throw new \InvalidArgumentException('The voucher postings do not balance to zero.');
        }

        $request = $this->request(
            method: Method::POST,
            url: self::PATH,
            filters: ['sendToLedger' => $sendToLedger ? 'true' : 'false'],
            body: $voucher->toJson(),
            headers: ['Content-Type' => 'application/json; charset=utf-8'],
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (201 === $response->getStatusCode()) {
            return Voucher::make($data);
        }

        return ErrorResponse::make($data);
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id, array $filters = []): Voucher|ErrorResponse
    {
        return $this->findResource(
            modelClass: Voucher::class,
            path: [self::PATH, $id],
            filters: $filters,
        );
    }

    /**
     * Tripletex requires the date range; dateTo is exclusive.
     *
     * @param array{number?: string, numberFrom?: int, numberTo?: int, typeId?: int, from?: int, count?: int, fields?: string} $filters
     *
     * @throws TripletexException
     */
    public function list(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Voucher::class,
            path: self::PATH,
            filters: [
                'dateFrom' => $dateFrom->format('Y-m-d'),
                'dateTo' => $dateTo->format('Y-m-d'),
            ] + $filters,
        );
    }

    /**
     * There is no filter on the external number, so this searches the vouchers in the date range.
     * Lets a caller check that a voucher wasn't already booked before creating it again.
     *
     * @throws TripletexException
     */
    public function findByExternalVoucherNumber(string $externalVoucherNumber, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo): Voucher|ErrorResponse|null
    {
        $response = $this->list($dateFrom, $dateTo, [
            'fields' => 'id,number,date,description,externalVoucherNumber',
            'count' => 10000,
        ]);

        if ($response instanceof ErrorResponse) {
            return $response;
        }

        foreach ($response->values ?? [] as $voucher) {
            if ($voucher->externalVoucherNumber === $externalVoucherNumber) {
                return $voucher;
            }
        }

        return null;
    }

    /**
     * @throws TripletexException
     */
    public function delete(int $id): true|ErrorResponse
    {
        return $this->deleteResource([self::PATH, $id]);
    }

    /** Tripletex rejects an unbalanced voucher; checking first gives a clearer error than its validation message. */
    private function isBalanced(Voucher $voucher): bool
    {
        $sumInOre = 0;
        foreach ($voucher->postings ?? [] as $posting) {
            $amount = $posting instanceof Posting ? $posting->amountGross : ($posting['amountGross'] ?? 0);
            $sumInOre += (int) round(((float) $amount) * 100);
        }

        return 0 === $sumInOre;
    }
}
