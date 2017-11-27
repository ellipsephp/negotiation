<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation;
use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\AvailableMappings;
use Ellipse\Negotiation\Outcomes;
use Ellipse\Negotiation\OutcomesWithFallback;
use Ellipse\Negotiation\Agreement;

describe('Negotiation', function () {

    beforeEach(function () {

        $this->request = mock(ServerRequestInterface::class);
        $this->negotiator = mock(NegotiatorAdapter::class);
        $this->available = mock(AvailableMappings::class);

        $this->negotiation = new Negotiation($this->request->get(), $this->negotiator->get(), $this->available->get());

    });

    describe('->agreement()', function () {

        beforeEach(function () {

            $this->request->getHeaderLine->with('Accept')->returns('text/html');

        });

        context('when no fallback is given', function () {

            it('should get a collection of accepted outcomes and proxy its ->agree() method', function () {

                $keys = ['formatter1', 'formatter2'];

                $outcomes = mock(Outcomes::class);
                $agreement = mock(Agreement::class);

                $this->available->outcomes->with($keys)->returns($outcomes);

                $outcomes->agreement->with($this->negotiator, 'text/html')->returns($agreement);

                $test = $this->negotiation->agreement($keys);

                expect($test)->toBe($agreement->get());

            });

        });

        context('when a fallback is given', function () {

            it('should get a collection of accepted outcomes with fallback and proxy its ->agree() method', function () {

                $keys = ['formatter1', 'formatter2'];
                $fallback = 'formatter1';

                $outcomes1 = mock(Outcomes::class);
                $outcomes2 = mock(OutcomesWithFallback::class);
                $agreement = mock(Agreement::class);

                $this->available->outcomes->with($keys)->returns($outcomes1);

                $outcomes1->fallback->with($fallback)->returns($outcomes2);

                $outcomes2->agreement->with($this->negotiator, 'text/html')->returns($agreement);

                $test = $this->negotiation->agreement($keys, $fallback);

                expect($test)->toBe($agreement->get());

            });

        });

    });

});
