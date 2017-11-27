<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Negotiation\Agreement;
use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\Outcomes;
use Ellipse\Negotiation\OutcomesWithFallback;
use Ellipse\Negotiation\OutcomesInterface;
use Ellipse\Negotiation\Exceptions\FallbackNotPresentException;

describe('Outcomes', function () {

    beforeEach(function () {

        $this->factories1 = stub();
        $this->factories2 = stub();
        $this->factories3 = stub();

        $this->factories = [
            'mapping1' => $this->factories1,
            'mapping2' => $this->factories2,
            'mapping3' => $this->factories3,
        ];

        $this->mimetypes = [
            'text/html' => 'mapping2',
            'application/json' => 'mapping3',
        ];

        $this->outcomes = new Outcomes($this->factories, $this->mimetypes);

    });

    it('should implement OutcomesInterface', function () {

        expect($this->outcomes)->toBeAnInstanceOf(OutcomesInterface::class);

    });

    describe('->fallback()', function () {

        context('when the given key is associated with a formatter', function () {

            it('should return a new OutcomesWithFallback', function () {

                $test = $this->outcomes->fallback('mapping1');

                expect($test)->toBeAnInstanceOf(OutcomesWithFallback::class);

            });

        });

        context('when the given key is not associated with a formatter', function () {

            it('should throw a new FallbackNotPresentException', function () {

                $test = function () {

                    $this->outcomes->fallback('mapping4');

                };

                $exception = new FallbackNotPresentException('mapping4', $this->factories);

                expect($test)->toThrow($exception);

            });

        });

    });

    describe('->withFactory()', function () {

        it('should return a new Outcomes', function () {

            $test = $this->outcomes->withFactory('mapping4', ['text/csv'], stub());

            expect($test)->toBeAnInstanceOf(Outcomes::class);
            expect($test)->not->toBe($this->outcomes);

        });

    });

    describe('->agreement()', function () {

        beforeEach(function () {

            $this->negotiator = mock(NegotiatorAdapter::class);

        });

        it('should use the negotiator to get a formatter key and return a new Agreement', function () {

            $this->negotiator->negotiatedMimetype
                ->with('text/html', ['text/html', 'application/json'])
                ->returns('text/html');

            $test = $this->outcomes->agreement($this->negotiator->get(), 'text/html');

            expect($test)->toBeAnInstanceOf(Agreement::class);

        });

    });

});
