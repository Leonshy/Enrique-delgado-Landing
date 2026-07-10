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
        Schema::table('session_plans', function (Blueprint $table) {
            $table->string('price')->nullable()->after('description');
            $table->string('period')->nullable()->after('price');
            $table->string('cta_label')->nullable()->after('period');
            $table->text('whatsapp_text')->nullable()->after('cta_label');
        });
    }

    public function down(): void
    {
        Schema::table('session_plans', function (Blueprint $table) {
            $table->dropColumn(['price', 'period', 'cta_label', 'whatsapp_text']);
        });
    }
};
