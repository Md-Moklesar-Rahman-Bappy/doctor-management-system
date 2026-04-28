<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('prescription_items');
    }

    public function down(): void
    {
        // Will be recreated by original migration if needed
    }
};
