<?php declare(strict_types=1);

namespace Ellipse;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\AvailableMappings;
use Ellipse\Negotiation\Agreement;

class Negotiation
{
    /**
     * The request for which a response factory should be negotiated.
     *
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $request;

    /**
     * The negotiator.
     *
     * @var \Ellipse\Negotiation\NegotiatorAdapter
     */
    private $negotiator;

    /**
     * The available mappings.
     *
     * @var \Ellipse\Negotiation\AvailableMappings
     */
    private $mappings;

    /**
     * Set up a negotiation witht he given request, negotiator and available
     * mappings.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Ellipse\Negotiation\NegotiatorAdapter    $negotiator
     * @param \Ellipse\Negotiation\AvailableMappings    $mappings
     */
    public function __construct(
        ServerRequestInterface $request,
        NegotiatorAdapter $negotiator,
        AvailableMappings $mappings
    ) {
        $this->request = $request;
        $this->negotiator = $negotiator;
        $this->mappings = $mappings;
    }

    /**
     * Return a new agreement from the given keys and fallback.
     *
     * @param array     $keys
     * @param string    $fallback
     * @return \Ellipse\Negotiation\Agreement
     */
    public function agreement(array $keys = [], string $fallback = ''): Agreement
    {
        $accept = $this->request->getHeaderLine('Accept');
        $outcomes = $this->mappings->outcomes($keys);

        if ($fallback != '') {

            $outcomes = $outcomes->fallback($fallback);

        }

        return $outcomes->agreement($this->negotiator, $accept);
    }
}
