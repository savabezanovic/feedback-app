<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned();
            $table->string("image");
            $table->string("position");
            $table->float("score")->nullable();
            $table->float('leadership')->nullable();
            $table->float('english')->nullable();
            $table->float('communication')->nullable();
            $table->float('problemSolving')->nullable();
            $table->float('programming')->nullable();
            $table->float('learining')->nullable();
            $table->float('workflow')->nullable();
            $table->float('humor')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
