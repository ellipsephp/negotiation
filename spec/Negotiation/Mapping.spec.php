<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Negotiation\Mapping;
use Ellipse\Negotiation\Outcomes;

describe('Mapping', function () {

    beforeEach(function () {

        $this->factory = stub();
        $this->mimetypes = ['text/html', 'application/json'];

        $this->mapping = new Mapping($this->factory, $this->mimetypes);

    });

    describe('->populatedOutcomes()', function () {

        it('should proxy the given outcomes ->withFactory() method', function () {

            $outcomes1 = mock(Outcomes::class);
            $outcomes2 = mock(Outcomes::class);

            $outcomes1->withFactory->with('key', $this->mimetypes, $this->factory)->returns($outcomes2);

            $test = $this->mapping->populatedOutcomes('key', $outcomes1->get());

            expect($test)->toBe($outcomes2->get());

        });

    });

});
