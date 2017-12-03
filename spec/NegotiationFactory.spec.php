<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\NegotiationFactory;
use Ellipse\Negotiation;
use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\AvailableMappings;

describe('NegotiationFactory', function () {

    beforeEach(function () {

        $this->available = mock(AvailableMappings::class)->get();

        $this->factory = new NegotiationFactory($this->available);

    });

    describe('->__invoke()', function () {

        it('should return a negotiation', function () {

            $request = mock(ServerRequestInterface::class)->get();

            $test = ($this->factory)($request);

            $negotiation = new Negotiation($request, new NegotiatorAdapter, $this->available);

            expect($test)->toEqual($negotiation);

        });

    });

});
