<?php

use function Eloquent\Phony\Kahlan\stub;

use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\FallbackNotPresentException;

describe('FallbackNotPresentException', function () {

    beforeEach(function () {

        $this->exception = new FallbackNotPresentException('html', [
            'mapping1' => stub(),
            'mapping2' => stub(),
        ]);

    });

    it('should implement NegotiationExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
