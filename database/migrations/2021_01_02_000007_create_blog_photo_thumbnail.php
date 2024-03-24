<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('blog_photo_thumbnail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blog_id')->unsigned();

            $table->string("key")->nullable();
            $table->string("file")->nullable();
            $table->string("width")->nullable();
            $table->string("height")->nullable();
            $table->string("url")->nullable();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('blog_post')->onDelete('cascade');
        });
    }


    public function down(): void {
        Schema::dropIfExists('blog_photo_thumbnail');
    }
};
