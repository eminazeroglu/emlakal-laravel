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
        Schema::create('menus', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('parent_id')->index()->default(0);
            $table->string('link')->nullable();
            $table->enum('type', \App\Enums\MenuTypeEnum::getValues());
            $table->string('photo_path')->nullable();
            $table->json('translates')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('menus');
    }
};
