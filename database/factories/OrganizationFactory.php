<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'code' => $this->faker->slug(3),
            'name' => $this->faker->company(),
            'description' => $this->faker->sentences(3, true),
            'active' => true,
        ];
    }
}
