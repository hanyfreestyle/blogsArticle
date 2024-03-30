<?php

namespace App\AppPlugin\Pages\Seeder;


use App\AppPlugin\Pages\Models\PageCategory;
use App\AppPlugin\Pages\Models\PageCategoryTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PageCategorySeeder extends Seeder {

    public function run(): void {

        PageCategory::unguard();
        $tablePath = public_path('db/page_categories.sql');
        DB::unprepared(file_get_contents($tablePath));


        PageCategoryTranslation::unguard();
        $tablePath = public_path('db/page_category_translations.sql');
        DB::unprepared(file_get_contents($tablePath));

    }
}
