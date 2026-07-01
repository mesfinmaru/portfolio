<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // languages | infrastructure
            $table->string('icon');     // e.g. fab fa-php
            $table->string('icon_color')->default('#ffffff');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};