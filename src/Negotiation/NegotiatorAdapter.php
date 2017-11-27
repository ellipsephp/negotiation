<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Negotiation\Negotiator;

use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

class NegotiatorAdapter
{
    /**
     * The instance of willdurand/negotiation negotiator.
     *
     * @var \Negotiation\Negotiator
     */
    private $negotiator;

    /**
     * Set up a negotiator adapter.
     */
    public function __construct()
    {
        $this->negotiator = new Negotiator;
    }

    /**
     * Return the best matching mimetypes between the given accept header and
     * priorities.
     *
     * @param string    $accept
     * @param array     $priorities
     * @return string
     */
    public function negotiatedMimetype(string $accept, array $priorities): string
    {
        $mediatype = $this->negotiator->getBest($accept, $priorities);

        if (! is_null($mediatype)) {

            return $mediatype->getValue();

        }

        throw new NegotiationFailedException($accept, $priorities);
    }
}
