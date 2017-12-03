<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Negotiation\Mapping;
use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\MappingNotAvailableException;

describe('MappingNotAvailableException', function () {

    it('should implement NegotiationExceptionInterface', function () {

        $test = new MappingNotAvailableException('html', [
            'json' => mock(Mapping::class)->get(),
            'csv' => mock(Mapping::class)->get(),
        ]);

        expect($test)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
