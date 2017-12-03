<?php

use Ellipse\Negotiation\Exceptions\NegotiationExceptionInterface;
use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

describe('NegotiationFailedException', function () {

    it('should implement NegotiationExceptionInterface', function () {

        $exception = new NegotiationFailedException('text/html', [
            'application/json',
        ]);

        expect($exception)->toBeAnInstanceOf(NegotiationExceptionInterface::class);

    });

});
