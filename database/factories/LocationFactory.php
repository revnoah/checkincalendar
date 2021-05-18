<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_id' => function () {
                return Organization::inRandomOrder()->first()->id;
            },
            'code' => $this->faker->slug(1),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentences(2, true),
            'max' => 20,
            'active' => true
        ];
    }
}
