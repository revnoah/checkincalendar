<?php

namespace Database\Factories;

use App\Models\Checkin;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checkin::class;

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
            'location_id' => function () {
                return Location::inRandomOrder()->first()->id;
            },
            'username' => $this->faker->name(),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
