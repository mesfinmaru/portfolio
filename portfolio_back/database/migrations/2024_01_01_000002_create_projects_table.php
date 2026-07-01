<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('tags')->nullable();
            $table->text('description');
            $table->json('code_snippet')->nullable();  // array of { n, html }
            $table->string('link_type')->default('github'); // github | docs | none
            $table->string('link_url')->nullable();
            $table->string('link_label')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};