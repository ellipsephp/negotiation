<?php

use function Eloquent\Phony\Kahlan\stub;

use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\FallbackNotPresentException;

describe('FallbackNotPresentException', function () {

    it('should implement NegotiationExceptionInterface', function () {

        $test = new FallbackNotPresentException('html', [
            'mapping1' => stub(),
            'mapping2' => stub(),
        ]);

        expect($test)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
