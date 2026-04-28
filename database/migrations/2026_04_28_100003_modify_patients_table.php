<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('unique_id')->unique();
            $table->string('patient_name');
            $table->integer('age');
            $table->enum('sex', ['male', 'female']);
            $table->date('date');
            $table->dropColumn(['gender', 'date_of_birth', 'blood_group', 'medical_history']);
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropUnique(['unique_id']);
            $table->dropColumn(['unique_id', 'patient_name', 'age', 'sex', 'date']);
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group')->nullable();
            $table->text('medical_history')->nullable();
        });
    }
};
