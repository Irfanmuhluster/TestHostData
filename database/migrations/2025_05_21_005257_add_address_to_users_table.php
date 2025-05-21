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
        Schema::table('users', function (Blueprint $table) {
            //'
            $table->string('address')->nullable()->after('email');
            $table->string('city')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('firstName')->nullable()->after('postal_code');
            $table->string('lastName')->nullable()->after('firstName');
            $table->string('phone')->nullable()->after('lastName');
            $table->string('countryCode')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');
            $table->dropColumn('phone');
            $table->dropColumn('countryCode');
            // $table->dropColumn('countryCode');
        });
    }
};
