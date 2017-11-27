<?php declare(strict_types=1);

namespace Ellipse\Negotiation\Exceptions;

use RuntimeException;

class MappingNotAvailableException extends RuntimeException implements NegotiationExceptionInterface
{
    public function __construct(string $key, array $mappings)
    {
        $keys = array_keys($mappings);

        $msg = "The formatter '%s' is not available [%s].";

        parent::__construct(sprintf($msg, $key, implode(', ', $keys)));
    }
}
