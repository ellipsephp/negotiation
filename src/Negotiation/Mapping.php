<?php declare(strict_types=1);

namespace Ellipse\Negotiation;

use Interop\Http\Factory\ResponseFactoryInterface;

class Mapping
{
    private $factory;

    private $mimetypes;

    public function __construct(callable $factory, array $mimetypes = [])
    {
        $this->factory = $factory;
        $this->mimetypes = $mimetypes;
    }

    public function populatedOutcomes(string $key, Outcomes $outcomes): Outcomes
    {
        return $outcomes->withFactory($key, $this->mimetypes, $this->factory);
    }
}
