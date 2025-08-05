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
        Schema::create('favorite_movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tmdb')->unique()->comment('ID do filme no TMDB');
            $table->string('title', 255);
            $table->string('tagline', 255)->nullable();
            $table->text('overview');
            $table->string('status', 50)->comment('Ex: Released, Post Production');
            $table->date('release_date');
            $table->integer('runtime')->nullable()->comment('Duração em minutos');
            $table->string('poster_path')->nullable();
            $table->string('homepage')->nullable();
            $table->decimal('popularity', 10, 4)->nullable();
            $table->unsignedInteger('vote_count')->default(0);
            $table->json('trailer')->nullable()->comment('Dados do trailer principal');
            $table->json('genres')->nullable()->comment('Array de gêneros');
            $table->json('production_countries')->nullable()->comment('Array de países');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_movies');
    }
};
