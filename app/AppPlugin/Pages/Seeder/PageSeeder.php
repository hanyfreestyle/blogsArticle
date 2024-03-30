<?php

namespace App\AppPlugin\Pages\Seeder;

use App\AppPlugin\Pages\Models\Page;
use App\AppPlugin\Pages\Models\PagePivot;
use App\AppPlugin\Pages\Models\PageTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PageSeeder extends Seeder {

    public function run(): void {

        Page::unguard();
        $tablePath = public_path('db/page_pages.sql');
        DB::unprepared(file_get_contents($tablePath));

        PageTranslation::unguard();
        $tablePath = public_path('db/page_translations.sql');
        DB::unprepared(file_get_contents($tablePath));

        PagePivot::unguard();
        $tablePath = public_path('db/pagecategory_page.sql');
        DB::unprepared(file_get_contents($tablePath));


    }
}
