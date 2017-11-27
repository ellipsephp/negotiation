<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\Exceptions\FallbackNotPresentException;

class Outcomes implements OutcomesInterface
{
    /**
     * The associative array of key => factory pairs.
     *
     * @var array
     */
    private $factories;

    /**
     * The associative array of mimetype => key pairs.
     *
     * @var array
     */
    private $mimetypes;

    /**
     * Set up an outcomes with the given associative array of factories and
     * mimetypes.
     *
     * @param array $factories
     * @param array $mimetypes
     */
    public function __construct(array $factories = [], array $mimetypes = [])
    {
        $this->factories = $factories;
        $this->mimetypes = $mimetypes;
    }

    /**
     * Return a new Outcomes with the given factory mapping.
     *
     * @param string    $key
     * @param array     $mimetypes
     * @param callable  $factory
     * @return \Ellipse\Negotiation\Outcomes
     */
    public function withFactory($key, array $mimetypes, callable $factory): Outcomes
    {
        $mimetypes = array_fill_keys($mimetypes, $key);

        $factories = array_merge($this->factories, [$key => $factory]);
        $mimetypes = array_merge($this->mimetypes, $mimetypes);

        return new Outcomes($factories, $mimetypes);
    }

    /**
     * Return a new OutcomesWithFallback with the given key.
     *
     * @param string $key
     * @return \Ellipse\Negotiation\OutcomesWithFallback
     * @throws \Ellipse\Negotiation\Exceptions\FallbackNotPresentException
     */
    public function fallback(string $key): OutcomesWithFallback
    {
        if (array_key_exists($key, $this->factories)) {

            return new OutcomesWithFallback($key, $this->factories[$key], $this);

        }

        throw new FallbackNotPresentException($key, $this->factories);
    }

    /**
     * Return a new Agreement from by negotiating a factory using the given
     * negotiator and accept header.
     *
     * @param \Ellipse\Negotiation\NegotiatorAdapter    $negotiator
     * @param string                                    $accept
     * @return \Ellipse\Negotiation\Agreement
     */
    public function agreement(NegotiatorAdapter $negotiator, string $accept): Agreement
    {
        $priorities = array_keys($this->mimetypes);

        $mimetype = $negotiator->negotiatedMimetype($accept, $priorities);

        $key = $this->mimetypes[$mimetype];

        return new Agreement($key, $this->factories[$key]);
    }
}
