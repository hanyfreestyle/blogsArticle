<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('page_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean("is_active")->nullable()->default(true);
            $table->string("photo")->nullable();
            $table->string("photo_thum_1")->nullable();
            $table->integer('url_type')->nullable()->default(0);
            $table->string('youtube')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('page_id')->unsigned();
            $table->string('locale')->index();
            $table->string('slug')->nullable();

            $table->string('name')->nullable();
            $table->longText('des')->nullable();
            $table->string('g_title')->nullable();
            $table->text('g_des')->nullable();
            $table->string('youtube_title')->nullable();

            $table->unique(['page_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('page_id')->references('id')->on('page_pages')->onDelete('cascade');
        });

    }


    public function down(): void {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('page_pages');
    }
};
