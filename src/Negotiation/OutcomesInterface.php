<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

interface OutcomesInterface
{
    public function agreement(NegotiatorAdapter $negotiator, string $accept): Agreement;
}
