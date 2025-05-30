<?php

namespace Tripletex\DTO;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Invoice
{
    public function __construct(
        public int $id,
    ) {

    }

    public static function make(array $data): self
    {
        $serializer = new Serializer(
            normalizers: [new ObjectNormalizer()],
            encoders: [new JsonEncoder()]
        );
        return $serializer->denormalize(
            data: $data,
            type: self::class
        );
    }
}