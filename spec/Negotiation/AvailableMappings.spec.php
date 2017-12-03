<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\anInstanceOf;

use Ellipse\Negotiation\Mapping;
use Ellipse\Negotiation\AvailableMappings;
use Ellipse\Negotiation\Outcomes;
use Ellipse\Negotiation\Exceptions\MappingNotAvailableException;

describe('AvailableMappings', function () {

    beforeEach(function () {

        $this->mapping1 = mock(Mapping::class);
        $this->mapping2 = mock(Mapping::class);
        $this->mapping3 = mock(Mapping::class);

        $this->mappings = [
            'mapping1' => $this->mapping1->get(),
            'mapping2' => $this->mapping2->get(),
            'mapping3' => $this->mapping3->get(),
        ];

        $this->available = new AvailableMappings($this->mappings);

    });

    describe('->withMapping()', function () {

        it('should return a new AvailableMappings with the given mapping associated to the given key', function () {

            $mapping = mock(Mapping::class)->get();

            $test = $this->available->withMapping('mapping4', $mapping);

            $available = new AvailableMappings([
                'mapping1' => $this->mapping1->get(),
                'mapping2' => $this->mapping2->get(),
                'mapping3' => $this->mapping3->get(),
                'mapping4' => $mapping,
            ]);

            expect($test)->toEqual($available);
            expect($test)->not->toBe($this->available);

        });

    });

    describe('->withMappings()', function () {

        it('should return a new AvailableMappings with the given associative array of mappings', function () {

            $mapping4 = mock(Mapping::class)->get();
            $mapping5 = mock(Mapping::class)->get();

            $test = $this->available->withMappings([
                'mapping4' => $mapping4,
                'mapping5' => $mapping5,
            ]);

            $available = new AvailableMappings([
                'mapping1' => $this->mapping1->get(),
                'mapping2' => $this->mapping2->get(),
                'mapping3' => $this->mapping3->get(),
                'mapping4' => $mapping4,
                'mapping5' => $mapping5,
            ]);

            expect($test)->toEqual($available);
            expect($test)->not->toBe($this->available);

        });

    });

    describe('->outcomes()', function () {

        context('when all the given formatters are available', function () {

            it('should return the Outcomes produces by all the given mappings ->populatedOutcomes() methods', function () {

                $outcomes0 = anInstanceOf(Outcomes::class);
                $outcomes1 = mock(Outcomes::class);
                $outcomes2 = mock(Outcomes::class);

                $this->mapping2->populatedOutcomes->with('mapping2', $outcomes0)->returns($outcomes1);
                $this->mapping3->populatedOutcomes->with('mapping3', $outcomes1)->returns($outcomes2);

                $test = $this->available->outcomes(['mapping2', 'mapping3']);

                expect($test)->toBe($outcomes2->get());

            });

        });

        context('when some formatters are not available', function () {

            it('should throw a MappingNotAvailableException', function () {

                $test = function () {

                    $this->available->outcomes(['mapping4']);

                };

                $exception = new MappingNotAvailableException('mapping4', $this->mappings);

                expect($test)->toThrow($exception);

            });

        });

    });

});
