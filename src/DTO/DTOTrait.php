<?php

namespace Tripletex\DTO;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tripletex\Contracts\ModelInterface;

trait DTOTrait
{
    private static function getSerializer(): Serializer
    {
        $normalizers = [
            new BackedEnumNormalizer(),
            new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        return new Serializer($normalizers, $encoders);
    }

    public function toJson(): string
    {
        return self::getSerializer()->serialize(
            $this,
            'json',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );
    }

    /**
     * @param array $data
     * @return ModelInterface
     */
    public static function make(array $data): ModelInterface
    {
        try {
            return self::getSerializer()->denormalize(
                data: $data,
                type: static::class,
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Deserialization failed: ' . $e->getMessage(), 0, $e);
        }
    }
}