<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // علاقة مع جدول users
            $table->string('title');
            $table->text('description')->nullable(); // إذا الوصف ممكن يكون فارغ
            $table->string('status')->default('open'); // أو ممكن تخليه enum إذا بتحب
            $table->timestamps(); // created_at و updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('issues');
    }
};
