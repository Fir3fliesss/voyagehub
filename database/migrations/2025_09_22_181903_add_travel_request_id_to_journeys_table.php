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
        Schema::table('journeys', function (Blueprint $table) {
            $table->foreignId('travel_request_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->index('travel_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journeys', function (Blueprint $table) {
            $table->dropForeign(['travel_request_id']);
            $table->dropIndex(['travel_request_id']);
            $table->dropColumn('travel_request_id');
        });
    }
};
