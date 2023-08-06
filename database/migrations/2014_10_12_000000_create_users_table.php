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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string("phone")->unique()->nullable();
            $table->string("address")->nullable();
            $table->date("birthday")->nullable();
            $table->integer("gender")->nullable();
            $table->string("parent")->nullable();
            $table->longText("extra_information")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("role")->default("customer");
            $table->string("avatar")->default("https://t4.ftcdn.net/jpg/04/08/24/43/360_F_408244382_Ex6k7k8XYzTbiXLNJgIL8gssebpLLBZQ.jpg");
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
