<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\NegotiationFactory;
use Ellipse\Negotiation;
use Ellipse\Negotiation\AvailableMappings;

describe('NegotiationFactory', function () {

    beforeEach(function () {

        $this->available = mock(AvailableMappings::class);;

        $this->factory = new NegotiationFactory($this->available->get());

    });

    describe('->__invoke()', function () {

        it('should return a negotiation', function () {

            $request = mock(ServerRequestInterface::class)->get();

            $test = ($this->factory)($request);

            expect($test)->toBeAnInstanceOf(Negotiation::class);

        });

    });

});
