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
        Schema::create('classe_user', function (Blueprint $table) {
        $table->unsignedBigInteger('classe_id');
        $table->unsignedBigInteger('user_id');
        $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->primary(['classe_id', 'user_id']);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_user');
    }
};
