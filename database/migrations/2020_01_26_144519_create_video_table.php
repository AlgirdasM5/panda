<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('channel_id');
            $table->string('title');
            $table->string('tags')->nullable();
            $table->dateTime('published_at');
            $table->timestamps();

            $table->primary('id');
            $table->index('id');
            $table->index('channel_id');

            $table->foreign('channel_id')
                ->references('id')->on('channels')
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
        Schema::dropIfExists('video');
    }
}
