<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('status');
            $table->string('theme_color')->default('#000000')->after('cover_image');
            $table->string('bg_color')->default('#ffffff')->after('theme_color');
            $table->string('font_family')->default('Outfit')->after('bg_color');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'theme_color', 'bg_color', 'font_family']);
        });
    }
};
