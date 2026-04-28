<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('name');
            $table->json('degrees')->nullable();
            $table->string('email')->unique();
            $table->boolean('email_verified')->default(false);
            $table->string('phone');
            $table->text('address');
            $table->dropColumn(['specialization', 'license_number', 'department', 'bio']);
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropColumn(['name', 'degrees', 'email', 'email_verified', 'phone', 'address']);
            $table->string('specialization');
            $table->string('license_number');
            $table->string('department');
            $table->text('bio')->nullable();
        });
    }
};
