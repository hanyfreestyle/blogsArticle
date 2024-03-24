<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {

        Schema::create('blog_tags_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('tag_id');
            $table->unsignedBiginteger('blog_id');

            $table->foreign('tag_id')->references('id')
                ->on('blog_tags')->onDelete('cascade');

            $table->foreign('blog_id')->references('id')
                ->on('blog_post')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('blog_tags_post');
    }

};
