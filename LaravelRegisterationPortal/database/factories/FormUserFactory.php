<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormUser>
 */
class FormUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dummyImagePath = 'images/assets/dummy.png';

        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'password' => $this->faker->password(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'whatsapp_phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'image_path' => $dummyImagePath
        ];
    }
}
