<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default("user");
            $table->longText('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->longText("extras")->nullable();
            $table->string("facebook_id")->nullable();
            $table->string("google_id")->nullable();
            $table->string("github_id")->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->integer("disable")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
