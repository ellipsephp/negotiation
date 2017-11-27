<?php declare(strict_types=1);

namespace Ellipse;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\AvailableMappings;

class NegotiationFactory
{
    /**
     * The available mappings.
     *
     * @var \Ellipse\Negotiation\NegotiatorAdapter
     */
    private $mappings;

    /**
     * Set up a negotiation factory with the given available mappings.
     *
     * @param \Ellipse\Negotiation\NegotiatorAdapter $mappings
     */
    public function __construct(AvailableMappings $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * Return a new negotiation with the given request.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Ellipse\Negotiation
     */
    public function __invoke(ServerRequestInterface $request): Negotiation
    {
        $negotiator = new NegotiatorAdapter;

        return new Negotiation($request, $negotiator, $this->mappings);
    }
}
