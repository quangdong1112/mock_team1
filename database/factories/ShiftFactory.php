<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $checkin = $this->faker->unique()->randomElement(['8h', '9h', '8h30']);
        return [
            'shift_name' => $this->faker->unique()->randomElement(['Ca 1', 'Ca 2', 'Ca 3']),
            'check_in' => $checkin,
            'check_out' => $checkin == '8h' ? '17h' : ($checkin == '9h' ? '18h' : ($checkin == '8h30' ? '17h30' : false)),
            'work_time' => 8,
            'lunch_break' => 60,
            'note' => 'note',
        ];
    }
}
