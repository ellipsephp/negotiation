<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Negotiation\Negotiator;

class NegotiatorAdapter
{
    private $negotiator;

    public function __construct()
    {
        $this->negotiator = new Negotiator;
    }

    public function negoriatedMimetype(string $accept, array $priorities): string
    {
        $mediatype = $this->negotiator->getBest($accept, $priorities);

        if (! is_null($mediatype)) {

            return $mediatype->getValue();

        }

        throw new NegotiationFailedException($accept, $priorities);
    }
}
