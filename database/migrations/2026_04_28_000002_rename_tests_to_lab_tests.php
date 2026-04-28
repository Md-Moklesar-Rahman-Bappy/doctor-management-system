<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('tests', 'lab_tests');
    }

    public function down(): void
    {
        Schema::rename('lab_tests', 'tests');
    }
};