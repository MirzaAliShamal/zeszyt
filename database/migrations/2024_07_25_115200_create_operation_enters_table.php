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
        Schema::create('operation_enters', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('category');
            $table->string('brut_value');
            $table->string('profit');
            $table->string('vat_tax_percent');
            $table->string('vat_tax_value');
            $table->string('net_value');
            $table->string('title');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_enters');
    }
};
