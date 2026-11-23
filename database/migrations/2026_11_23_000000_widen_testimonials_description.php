<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The forms accept 500 characters, but the column held only 255.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('description', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * MySQL in strict mode refuses it while there are texts over 255 characters.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('description', 255)->change();
        });
    }
};
