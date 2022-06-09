<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class DivisionMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $memberId =1;
        $member = DB::table('divisions')->pluck('member_id');
        $divisonId = DB::table('divisions')->pluck('id');
        $check = in_array($memberId,$member->toArray());
        $divison = DB::table('divisions')->where('member_id', $memberId)->first();
        return [
                'member_id' => $memberId++,
                'division_id' => $check ? $divison->id : $this->faker->randomElement($divisonId),
            ];
    }
}
