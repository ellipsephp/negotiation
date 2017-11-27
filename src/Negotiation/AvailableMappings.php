<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Ellipse\Negotiation\Exceptions\MappingNotAvailableException;

class AvailableMappings
{
    /**
     * The associative array of mappings.
     *
     * @var array
     */
    private $mappings;

    /**
     * Set up an available mappings with the given associative array of
     * mappings.
     */
    public function __construct(array $mappings = [])
    {
        $this->mappings = $mappings;
    }

    /**
     * Return a new AvailableMappings with the given key associated to the given
     * mapping.
     *
     * @param string                        $key
     * @param \Ellipse\Negotiation\Mapping  $mapping
     * @return \Ellipse\Negotiation\AvailableMappings
     */
    public function withMapping(string $key, Mapping $formatter): AvailableMappings
    {
        $mappings = array_merge($this->mappings, [$key => $formatter]);

        return new AvailableMappings($mappings);
    }

    /**
     * Return a new AvailableMappings with the given associative array of
     * mappings.
     *
     * @param array $mappings
     * @return \Ellipse\Negotiation\AvailableMappings
     */
    public function withMappings(array $mappings): AvailableMappings
    {
        $keys = array_keys($mappings);

        return array_reduce($keys, function ($negotiation, $key) use ($mappings) {

            return $negotiation->withMapping($key, $mappings[$key]);

        }, $this);
    }

    /**
     * Return a new outcomes from the given keys.
     *
     * @param array $keys
     * @return \Ellipse\Negotiation\Outcomes
     * @throws \Ellipse\Negotiation\Exceptions\MappingNotAvailableException
     */
    public function outcomes(array $keys): Outcomes
    {
        return array_reduce($keys, function ($outcomes, $key) {

            if (array_key_exists($key, $this->mappings)) {

                return $this->mappings[$key]->populatedOutcomes($key, $outcomes);

            }

            throw new MappingNotAvailableException($key, $this->mappings);

        }, new Outcomes);
    }
}
