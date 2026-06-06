<?php

namespace App\GraphQL;

use Illuminate\Support\Str;
use Nuwave\Lighthouse\Schema\ResolverProvider;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Utils;

class CustomResolverProvider extends ResolverProvider
{
    protected function findResolverClass(FieldValue $fieldValue, string $methodName): ?string
    {
        $withSuffix = Str::studly($fieldValue->getFieldName()).Str::studly($fieldValue->getParentName());

        $resolved = Utils::namespaceClassname(
            $withSuffix,
            $fieldValue->parentNamespaces(),
            static fn (string $class): bool => method_exists($class, $methodName),
        );

        if ($resolved !== null) {
            return $resolved;
        }

        return parent::findResolverClass($fieldValue, $methodName);
    }
}
