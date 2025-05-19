<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // على الأغلب الاسم لازم يكون فريد
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // جدول العلاقة الوسيطة
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['role_id', 'permission_id']); // لتجنب التكرار
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
    }
};
