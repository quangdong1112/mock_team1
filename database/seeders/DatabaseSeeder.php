<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Member::factory(100)->create();
        \App\Models\Role::factory(3)->create();
        \App\Models\MemberRole::factory(100)->create();
        \App\Models\Shift::factory(3)->create();
        \App\Models\MemberShift::factory(100)->create();
        \App\Models\Division::factory(6)->create();
        \App\Models\DivisionMember::factory(100)->create();
        \App\Models\Checklog::factory(18000)->create();
        \App\Models\MemberRequestQuota::factory(500)->create();
        \App\Models\LeaveQuota::factory(100)->create();
        \App\Models\Worksheet::factory(9000)->create();
    }
}
