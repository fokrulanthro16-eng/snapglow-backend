<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tool_histories', function (Blueprint $table) {
            $table->id();
            $table->string('tool_type');
            $table->string('input_file');
            $table->string('output_file')->nullable();
            $table->integer('original_size_kb')->nullable();
            $table->integer('processed_size_kb')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_histories');
    }
};
