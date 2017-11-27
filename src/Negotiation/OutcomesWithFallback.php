<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Negotiation\Exceptions\NegotiationFailedException;

class OutcomesWithFallback implements OutcomesInterface
{
    /**
     * The fallback key.
     *
     * @var string
     */
    private $key;

    /**
     * The fallback factory.
     *
     * @var callable
     */
    private $factory;

    /**
     * The delegate.
     *
     * @var \Ellipse\Negotiation\OutcomesInterface
     */
    private $delegate;

    /**
     * Set up a outcomes with fallback using the given key, factory and
     * delegate.
     *
     * @param string                                    $key
     * @param callable                                  $factory
     * @param \Ellipse\Negotiation\OutcomesInterface    $delegate
     */
    public function __construct(string $key, callable $factory, OutcomesInterface $delegate)
    {
        $this->key = $key;
        $this->factory = $factory;
        $this->delegate = $delegate;
    }

    /**
     * Return an agreement using the fallback key and factory when the delegate
     * fails to find an agreement.
     *
     * @param \Ellipse\Negotiation\NegotiatorAdapter    $negotiator
     * @param string                                    $accept
     * @return \Ellipse\Negotiation\Agreement
     */
    public function agreement(NegotiatorAdapter $negotiator, string $accept): Agreement
    {
        try {

            return $this->delegate->agreement($negotiator, $accept);

        }

        catch (NegotiationFailedException $e) {

            return new Agreement($this->key, $this->factory);

        }
    }
}
