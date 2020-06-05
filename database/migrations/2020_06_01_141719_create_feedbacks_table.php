<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('commentator_id')->unsigned();
            $table->float('leadership');
            $table->float('english');
            $table->float('communication');
            $table->float('problemSolving');
            $table->float('programming');
            $table->float('learining');
            $table->float('workflow');
            $table->float('humor');
            $table->string('positive')->nullable();
            $table->string('negative')->nullable();
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
        Schema::dropIfExists('feedbacks');
    }
}
