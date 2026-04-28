<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['prescription_date', 'valid_until', 'notes']);
            $table->json('problem')->nullable();
            $table->json('tests')->nullable();
            $table->json('medicines')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['problem', 'tests', 'medicines']);
            $table->date('prescription_date');
            $table->date('valid_until');
            $table->text('notes')->nullable();
        });
    }
};
