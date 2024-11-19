<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Person', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->foreign('staff')->references('id')->on('Staff')->onDelete('cascade');
            $table->string('phone');
            $table->integer('stage');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Person');
    }
};
