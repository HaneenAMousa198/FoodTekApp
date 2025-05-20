<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // معرف المستخدم
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('verification_token')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();//email_verified_at
            $table->foreignId('role_id')->constrained()->onDelete('cascade'); // ربط المستخدم بالدور
             $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
