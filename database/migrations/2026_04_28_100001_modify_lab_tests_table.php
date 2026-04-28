<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->dropColumn(['name', 'category', 'description', 'price']);
            $table->string('department');
            $table->string('sample_type');
            $table->string('panel')->nullable();
            $table->string('test');
            $table->string('code')->unique();
            $table->string('unit')->nullable();
            $table->string('result_type')->nullable();
            $table->string('normal_range')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn(['department', 'sample_type', 'panel', 'test', 'code', 'unit', 'result_type', 'normal_range']);
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
        });
    }
};
