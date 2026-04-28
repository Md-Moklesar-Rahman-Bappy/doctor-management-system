<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->renameColumn('name', 'brand_name');
            $table->renameColumn('dosage', 'dosage_type');
            $table->string('company_name')->nullable()->after('strength');
            $table->string('package_mark')->nullable()->after('company_name');
            
            $table->dropColumn('generic_name');
            $table->dropColumn('form');
            $table->dropColumn('strength');
            $table->dropColumn('price');
            $table->dropColumn('stock_quantity');
            $table->dropColumn('description');
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->renameColumn('brand_name', 'name');
            $table->renameColumn('dosage_type', 'dosage');
            $table->string('generic_name')->nullable();
            $table->string('form')->nullable();
            $table->string('strength')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->text('description')->nullable();
            
            $table->dropColumn('company_name');
            $table->dropColumn('package_mark');
        });
    }
};