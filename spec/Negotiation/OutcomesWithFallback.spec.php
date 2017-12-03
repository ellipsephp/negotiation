<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\Agreement;
use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\OutcomesWithFallback;
use Ellipse\Negotiation\OutcomesInterface;
use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

describe('OutcomesWithFallback', function () {

    beforeEach(function () {

        $this->key = 'fallback';
        $this->factory = stub();
        $this->delegate = mock(OutcomesInterface::class);

        $this->outcomes = new OutcomesWithFallback($this->key, $this->factory, $this->delegate->get());

    });

    it('should implement OutcomesInterface', function () {

        expect($this->outcomes)->toBeAnInstanceOf(OutcomesInterface::class);

    });

    describe('->agreement()', function () {

        beforeEach(function () {

            $this->negotiator = mock(NegotiatorAdapter::class);

        });

        context('when the delegate ->agreement() method throws a NegotiationFailedException', function () {

            it('should return a new Agreement', function () {

                $exception = mock(NegotiationFailedException::class)->get();

                $this->delegate->agreement->with($this->negotiator, 'text/html')->throws($exception);

                $test = $this->outcomes->agreement($this->negotiator->get(), 'text/html');

                $agreement = new Agreement('fallback', $this->factory);

                expect($test)->toEqual($agreement);

            });

        });

        context('when the delegate ->agreement() method do not throw a NegotiationFailedException', function () {

            it('should proxy the delegate ->agreement() method', function () {

                $agreement = mock(Agreement::class)->get();

                $this->delegate->agreement->with($this->negotiator, 'text/html')->returns($agreement);

                $test = $this->outcomes->agreement($this->negotiator->get(), 'text/html');

                expect($test)->toBe($agreement);

            });

        });

    });

});
