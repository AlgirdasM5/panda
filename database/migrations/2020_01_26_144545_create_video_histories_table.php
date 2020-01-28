<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_histories', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('video_id');
            $table->bigInteger('view_count');
            $table->timestamp('created_at');

            $table->index('id');
            $table->index('video_id');

            $table->foreign('video_id')
                ->references('id')->on('videos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_histories');
    }
}
