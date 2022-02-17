<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class comentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contenido' => $this->faker->text(255), 
            'hotel_id' => $this->faker->randomDigit, 
            'user_id' => User::all()->random()->id
            //
        ];
    }
}
