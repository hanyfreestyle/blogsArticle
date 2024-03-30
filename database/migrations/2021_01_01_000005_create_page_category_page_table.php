<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('pagecategory_page', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('category_id');
            $table->unsignedBiginteger('page_id');
            $table->integer('postion')->default(0);

            $table->foreign('category_id')->references('id')
                ->on('page_categories')->onDelete('cascade');

            $table->foreign('page_id')->references('id')
                ->on('page_pages')->onDelete('cascade');
        });
    }


    public function down(): void {
        Schema::dropIfExists('pagecategory_page');
    }

};
