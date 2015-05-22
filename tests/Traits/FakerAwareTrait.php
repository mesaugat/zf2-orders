<?php

namespace Tests\Traits;

use Faker\Factory as FakerFactory;

trait FakerAwareTrait
{
    protected $faker;

    public function getFaker()
    {
        if (!$this->faker) {
            $this->faker = FakerFactory::create();
        }

        return $this->faker;
    }
}