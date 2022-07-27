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
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('permission_pivot_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->index()->comment('Cedvel adi permissions');
            $table->unsignedBigInteger('group_id')->index()->comment('Cedvel adi permissions_groups');
            $table->json('option_field')->nullable();

            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('permissions_groups')->onDelete('cascade');
        });
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_pivot_groups');
    }
};
