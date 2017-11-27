<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Interop\Http\Factory\ResponseFactoryInterface;

class Mapping
{
    /**
     * The mapped response factory factory.
     *
     * @var callable
     */
    private $factory;

    /**
     * The mimetypes associated with the factory.
     *
     * @var array
     */
    private $mimetypes;

    /**
     * Set up a mapping with the given response factory factory and mappings.
     *
     * @param callable  $factory
     * @param array     $mimetypes
     */
    public function __construct(callable $factory, array $mimetypes = [])
    {
        $this->factory = $factory;
        $this->mimetypes = $mimetypes;
    }

    /**
     * Return a new outcomes populated with the given key and this mapping data.
     *
     * @param string                        $key
     * @param \Ellipse\Negotiation\Outcomes $outcomes
     * @return \Ellipse\Negotiation\Outcomes
     */
    public function populatedOutcomes(string $key, Outcomes $outcomes): Outcomes
    {
        return $outcomes->withFactory($key, $this->mimetypes, $this->factory);
    }
}
