<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

class OutcomesWithFallback implements OutcomesInterface
{
    private $key;

    private $factory;

    private $delegate;

    public function __construct(string $key, Agreement $factory, OutcomesInterface $delegate)
    {
        $this->key = $key;
        $this->factory = $factory;
        $this->delegate = $delegate;
    }

    public function agreement(NegotiatorAdapter $negotiator, string $accept): Agreement
    {
        try {

            return $this->delegate->agreement($negotiator, $accept);

        }

        catch (NegotiationFailedException $e) {

            return new Agreement($key, $this->factory);

        }
    }
}
