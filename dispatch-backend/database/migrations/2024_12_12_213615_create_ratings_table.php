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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID of the rater
            $table->foreignId('rider_id')->nullable()->constrained('users')->onDelete('cascade'); // Rider being rated
            $table->foreignId('rated_user_id')->nullable()->constrained('users')->onDelete('cascade'); // User being rated
            $table->integer('rating'); // Rating (1 to 5)
            $table->string('comment')->nullable(); // Optional comment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
