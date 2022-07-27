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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_name');
            $table->string('user_code');
            $table->unsignedBigInteger('permission_id')->default(1);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('language')->default('az');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->text('address')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('gender', ['man', 'woman'])->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_block')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
