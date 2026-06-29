<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();        // hero, cambio, enfoque, areas, sobre-mi, proceso, faq, primer-paso, contacto
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->text('extra')->nullable();       // texto adicional / destacado
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_sections');
    }
};
