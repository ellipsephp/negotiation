<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\Exceptions\FallbackNotAcceptedException;

class Outcomes implements OutcomesInterface
{
    private $factories;

    public function __construct(array $factories = [], array $mimetypes = [])
    {
        $this->factories = $factories;
        $this->mimetypes = $mimetypes;
    }

    public function withFactory($key, array $mimetypes, callable $factory)
    {
        $mimetypes = array_fill_keys($mimetypes, $key);

        $factories = array_merge($this->factories, [$key => $factory]);
        $mimetypes = array_merge($this->mimetypes, $mimetypes);

        return new Outcomes($factories, $mimetypes);
    }

    public function fallback(string $key): OutcomesWithFallback
    {
        if (array_key_exists($key, $this->factories)) {

            return new OutcomesWithFallback($key, $this->factories[$key], $this);

        }

        throw new FallbackNotAcceptedException($key, $this->factories);
    }

    public function agreement(NegotiatorAdapter $negotiator, string $accept): Agreement
    {
        $priorities = array_keys($this->mimetypes);

        $mimetype = $negotiator->negotiatedMimetype($accept, $priorities);

        $key = $this->mimetypes[$mimetype];

        return new Agreement($key, $this->factories[$key]);
    }
}
