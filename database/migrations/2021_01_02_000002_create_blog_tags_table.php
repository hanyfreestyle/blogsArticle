<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('old_id')->nullable();
            $table->boolean("is_active")->default(true);
            $table->integer('count')->default(0);
            $table->integer('old_count')->default(0);
        });

        Schema::create('blog_tags_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tag_id')->unsigned();
            $table->string('locale')->index();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->unique(['tag_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('blog_tags_translations');
        Schema::dropIfExists('blog_tags');
    }
};
