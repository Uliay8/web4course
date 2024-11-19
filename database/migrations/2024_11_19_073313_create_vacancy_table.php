<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Vacancy', function (Blueprint $table) {
            $table->id();
            $table->foreign('firm')->references('id')->on('Firm')->onDelete('cascade');
            $table->foreign('staff')->references('id')->on('Staff')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Vacancy');
    }
};
