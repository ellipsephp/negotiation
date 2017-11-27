<?php

use function Eloquent\Phony\Kahlan\mock;

use Negotiation\Negotiator;
use Negotiation\BaseAccept;

use Ellipse\Negotiation\NegotiatorAdapter;
use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

describe('NegotiatorAdapter', function () {

    beforeEach(function () {

        $this->negotiator = mock(Negotiator::class);

        allow(Negotiator::class)->toBe($this->negotiator->get());

        $this->adapter = new NegotiatorAdapter;

    });

    describe('->negotiatedMimetype()', function () {

        context('when the negotiator ->getBest() method returns a value', function () {

            it('should return the mimetype negotiated by the negotiator', function () {

                $value = mock(BaseAccept::class);

                $value->getValue->returns('text/html');

                $this->negotiator->getBest->with('text/html', ['text/html', 'application/json'])->returns($value);

                $test = $this->adapter->negotiatedMimetype('text/html', ['text/html', 'application/json']);

                expect($test)->toEqual('text/html');

            });

        });

        context('when the negotiator ->getBest() method returns null', function () {

            it('should throw a NegotiationFailedException', function () {

                $this->negotiator->getBest->with('text/html', ['text/html', 'application/json'])->returns(null);

                $test = function () {

                    $this->adapter->negotiatedMimetype('text/html', ['text/html', 'application/json']);

                };

                $exception = new NegotiationFailedException('text/html', ['text/html', 'application/json']);

                expect($test)->toThrow($exception);

            });

        });

    });

});
