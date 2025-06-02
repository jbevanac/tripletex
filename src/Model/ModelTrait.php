<?php

namespace Tripletex\Model;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\SerializerException;
use Tripletex\TripletexSDK;

trait ModelTrait
{

    /**
     * @throws ApiException
     */
    public function toJson(): string
    {
        try {
            return TripletexSDK::getSerializer()->serialize(
                $this,
                'json',
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
            );
        } catch (\Throwable $e) {
            throw new SerializerException('Serialization failed: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array $data
     * @return ModelInterface
     * @throws ApiException
     */
    public static function make(array $data): ModelInterface
    {
        $data = $data['value'] ?? $data;

        try {
            return TripletexSDK::getSerializer()->denormalize(
                data: $data,
                type: static::class,
            );
        } catch (\Exception $e) {
            throw new SerializerException('Deserialization failed: ' . $e->getMessage(), 0, $e);
        }
    }
}