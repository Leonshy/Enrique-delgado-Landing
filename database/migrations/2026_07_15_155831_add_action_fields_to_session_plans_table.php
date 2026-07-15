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
            $table->string('icon')->nullable()->after('cta_label');
            $table->string('action_type')->default('whatsapp')->after('icon');
            $table->string('action_url')->nullable()->after('action_type');
            $table->string('action_url_target')->default('_self')->after('action_url');
            $table->string('action_email_to')->nullable()->after('action_url_target');
            $table->string('action_email_subject')->nullable()->after('action_email_to');
            $table->text('action_email_body')->nullable()->after('action_email_subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_plans', function (Blueprint $table) {
            $table->dropColumn([
                'icon', 'action_type', 'action_url', 'action_url_target',
                'action_email_to', 'action_email_subject', 'action_email_body',
            ]);
        });
    }
};
