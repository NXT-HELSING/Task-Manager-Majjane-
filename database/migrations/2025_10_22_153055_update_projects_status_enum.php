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
        Schema::table('projects', function (Blueprint $table) {
            // First, we need to modify the enum to include 'on_hold' and remove 'archived'
            $table->enum('status', ['active', 'on_hold', 'completed'])
                ->default('active')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('status', ['active', 'completed', 'archived'])
                ->default('active')
                ->change();
        });
    }
};
