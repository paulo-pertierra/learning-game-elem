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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('title');
            $table->string('description');
            $table->integer('grade_level');
            $table->integer('quarter');
            $table->timestamps();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'videos_user_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
