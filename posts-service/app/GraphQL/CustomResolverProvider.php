<?php

namespace App\GraphQL;

use Nuwave\Lighthouse\Schema\ResolverProvider;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Utils;

class CustomResolverProvider extends ResolverProvider
{
    protected function findResolverClass(FieldValue $fieldValue, string $methodName): ?string
    {
        // Try with suffix first (RegisterMutation, MeQuery)
        $withSuffix = Utils::namespaceClassname(
            Str::studly($fieldValue->getFieldName()) . Str::studly($fieldValue->getParentName()),
            $fieldValue->parentNamespaces(),
            static fn (string $class): bool => method_exists($class, $methodName),
        );

        if ($withSuffix !== null) {
            return $withSuffix;
        }

        // Fall back to default (Register, Me)
        return parent::findResolverClass($fieldValue, $methodName);
    }
}