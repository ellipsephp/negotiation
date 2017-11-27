<?php declare(strict_types=1);

namespace Ellipse\Negotiation\Exceptions;

use RuntimeException;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\AcceptedFormatters;

class NegotiationFailedException extends RuntimeException implements NegotiationExceptionInterface
{
    public function __construct(string $accept, array $priorities)
    {
        $msg = "Content negotiation failled. Accept header '%s' not matching the accepted mimetypes: [%s].";

        parent::__construct(sprintf($msg, $accept, implode(', ', $priorities)));
    }
}
