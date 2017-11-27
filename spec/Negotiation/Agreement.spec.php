<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Negotiation\Agreement;

describe('Agreement', function () {

    beforeEach(function () {

        $this->key = 'key';
        $this->factory = stub();

        $this->agreement = new Agreement($this->key, $this->factory);

    });

    describe('->factory()', function () {

        beforeEach(function () {

            $this->response = mock(ResponseFactoryInterface::class)->get();

            $this->factory->returns($this->response);

        });

        context('when no builder has the same key', function () {

            it('should proxy the factory', function () {

                $test = $this->agreement->factory(['builder' => stub()]);

                expect($test)->toBe($this->response);

            });

        });

        context('when a builder has the same key', function () {

            it('should proxy the builder with the response factory as parameter', function () {

                $builder = stub();
                $built = mock(ResponseFactoryInterface::class)->get();

                $builder->with($this->response)->returns($built);

                $test = $this->agreement->factory(['key' => $builder]);

                expect($test)->toBe($built);

            });

        });

    });

});
