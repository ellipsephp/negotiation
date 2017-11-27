<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Negotiation\Mapping;
use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\MappingNotAvailableException;

describe('MappingNotAvailableException', function () {

    beforeEach(function () {

        $this->exception = new MappingNotAvailableException('html', [
            'json' => mock(Mapping::class)->get(),
            'csv' => mock(Mapping::class)->get(),
        ]);

    });

    it('should implement NegotiationExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
