<?php

namespace Tripletex\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class IdNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): object
    {
        return new $type(id: $data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!is_int($data) || !class_exists($type)) {
            return false;
        }
        $params = (new \ReflectionClass($type))->getConstructor()?->getParameters() ?? [];
        return isset($params[0]) && $params[0]->getName() === 'id';
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }
}
