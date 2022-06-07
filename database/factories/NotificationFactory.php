<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $divionId = DB::table('divisions')->pluck('id');
        $createBy = DB::table('members')->pluck('created_by');
        return [
            'published_date' => $this->faker->date(),
            'subject' => $this->faker->name,
            'status' => rand(0, 3),
            'attachment' => 'http://127.0.0.1:8000/storage/images/members/6294504f50c90-159726055_3884927424894828_3378186297290425618_n.jpg',
            'published_to' => json_encode([$this->faker->randomElement($divionId)]),
            'created_by' => $this->faker->randomElement($createBy),
        ];
    }
}
