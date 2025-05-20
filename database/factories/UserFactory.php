<?php

namespace Database\Factories;
// database/factories/UserFactory.php
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(), // يرجع تاريخ بصيغة yyyy-mm-dd
            'password' => bcrypt('password'), // كلمة مرور ثابتة لكل المستخدمين
            'email_verified_at' => now(),
            'role_id' => 1, // ✅ أو استخدم factory للـ Role لو عندك جدول roles

        ];
    }
}
