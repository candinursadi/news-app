<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_list_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_list_id')->nullable();
            $table->foreign('news_list_id')->references('id')->on('news_lists');
            $table->string('action', 10)->nullable();
            $table->string('author', 30)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('image', 200)->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('posted_by');
            $table->foreign('posted_by')->references('id')->on('users');
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
        Schema::dropIfExists('news_list_logs');
    }
};
