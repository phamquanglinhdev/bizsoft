<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer("session");
            $table->integer("classroom_id");
            $table->integer("teacher_id");
            $table->string("title");
            $table->date("day");
            $table->string("start");
            $table->string("end");
            $table->longText("attendances");
            $table->integer("hour_salary");
            $table->longText("record")->nullable();
            $table->longText("exercises")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
