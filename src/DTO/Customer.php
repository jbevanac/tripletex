<?php

namespace Tripletex\DTO;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class Customer
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?int $customerNumber,
        public ?string $organizationNumber,
        public ?string $invoiceEmail,
    ) {
    }

    public function toJson(): string
    {
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        return $serializer->serialize(
            $this,
            'json',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );
    }
    /**
     * @param array $data {id:int, name:string, email:string, customerNumber:int, organizationNumber:string, invoiceEmail:string} $data
     * @return Customer
     */
    public static function make(array $data): self
    {
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());

        $serializer = new Serializer(
            normalizers: [$normalizer],
            encoders: [new JsonEncoder()]
        );

        try {
            return $serializer->denormalize(
                data: $data,
                type: self::class,
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Deserialization failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
