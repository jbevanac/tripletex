<?php

namespace Tripletex\DTO;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait Model
{
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
     * @param array $data
     * @return static
     */
    public static function make(array $data): self
    {
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        try {
            return $serializer->denormalize(
                data: $data,
                type: static::class,
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Deserialization failed: ' . $e->getMessage(), 0, $e);
        }
    }
}