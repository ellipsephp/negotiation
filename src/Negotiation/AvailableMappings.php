<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Ellipse\Negotiation\Exceptions\MappingNotFoundException;

class AvailableMappings
{
    private $mappings;

    public function __construct(array $mappings = [])
    {
        $this->mappings = $mappings;
    }

    public function withFormatter(string $key, Mapping $formatter): AvailableMappings
    {
        $mappings = array_merge($this->mappings, [$key => $formatter]);

        return new AvailableMappings($mappings);
    }

    public function withFormatters(array $mappings): AvailableMappings
    {
        $keys = array_keys($mappings);

        return array_reduce($keys, function ($negotiation, $key) use ($mappings) {

            return $negotiation->withFormatter($key, $mappings[$key]);

        }, $this);
    }

    public function outcomes(array $keys): Outcomes
    {
        return array_reduce($keys, function ($outcomes, $key) {

            if (array_key_exists($key, $this->mappings)) {

                return $this->mappings[$key]->populatedOutcomes($outcomes);

            }

            throw new MappingNotFoundException($key, $this->mappings);

        }, new Outcomes);
    }
}
