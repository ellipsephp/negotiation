<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Interop\Http\Factory\ResponseFactoryInterface;

class Agreement
{
    /**
     * The negotiated key.
     *
     * @var string
     */
    private $key;

    /**
     * The negotiated response factory factory.
     *
     * @var callable
     */
    private $factory;

    /**
     * Set up an agreement with the given negotiated key and factory.
     *
     * @param string    $key
     * @param callable  $factory
     */
    public function __construct(string $key, callable $factory)
    {
        $this->key = $key;
        $this->factory = $factory;
    }

    /**
     * Return a response factory by using this agreement factory wrapped inside
     * one of the given builders when one has a matching key.
     *
     * @param array $builders
     * @return \Interop\Http\Factory\ResponseFactoryInterface
     */
    public function factory(array $builders = []): ResponseFactoryInterface
    {
        $builder = $builders[$this->key] ?? function (ResponseFactoryInterface $factory) {

            return $factory;

        };

        return $builder(($this->factory)());
    }
}
