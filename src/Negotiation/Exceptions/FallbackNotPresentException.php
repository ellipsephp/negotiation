<?php declare(strict_types=1);

namespace Ellipse\Negotiation\Exceptions;

use RuntimeException;

class FallbackNotPresentException extends RuntimeException implements NegotiationExceptionInterface
{
    public function __construct(string $fallback, array $factories)
    {
        $keys = array_keys($factories);

        $msg = "The given fallback factory '%s' is not an accepted factory [%s].";

        parent::__construct(sprintf($msg, $fallback, implode(', ', $keys)));
    }
}
