<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'contact_number' => $this->phNumber(),
            'email' => fake()->unique()->safeEmail(),
            'gender' => fake()->randomElement(['male', 'female', null]),
            'user_type' => fake()->randomElement([User::TYPE_FARMER, User::TYPE_VENDOR, User::TYPE_ADMIN]),
            'profile_picture' => 'none',
            'remember_token' => Str::random(10),
        ];
    }

    public function male()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => 'male',
            ];
        });
    }

    public function female()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => 'female',
            ];
        });
    }

    public function farmer()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => User::TYPE_FARMER,
            ];
        });
    }
    public function vendor()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => User::TYPE_VENDOR,
            ];
        });
    }
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => User::TYPE_ADMIN,
            ];
        });
    }

    public function phNumber()
    {
        return Str::of(fake()->randomNumber(9, true))->prepend("9");
    }
}
