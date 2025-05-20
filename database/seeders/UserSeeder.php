<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ينشئ 10 مستخدمين باستخدام الـ Factory
        User::factory()->count(10)->create();
    }
}
