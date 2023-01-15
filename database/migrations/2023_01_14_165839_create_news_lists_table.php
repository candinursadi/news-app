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
        Schema::create('news_lists', function (Blueprint $table) {
            $table->id();
            $table->string('author', 30)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('image', 200)->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('posted_by');
            $table->foreign('posted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_lists');
    }
};
