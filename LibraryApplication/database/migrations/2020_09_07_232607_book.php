<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Book extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_publisher')->references('id')->on('users');
            $table->string('title', 50);
            $table->string('cover')->nullable();    // path to the cover image
            $table->string('synopsis', 500);
            $table->string('category', 30);
            $table->string('publishing_company', 40);
            $table->string('author', 50);
            $table->string('edition', 20);
            $table->year('year');
            $table->integer('page_numbers');
            $table->integer('favorites')->default(0);
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
