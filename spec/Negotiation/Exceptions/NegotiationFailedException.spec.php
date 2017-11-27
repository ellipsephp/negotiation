<?php

use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

describe('NegotiationFailedException', function () {

    beforeEach(function () {

        $this->exception = new NegotiationFailedException('text/html', [
            'application/json',
        ]);

    });

    it('should implement NegotiationExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
