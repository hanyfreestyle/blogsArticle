<?php

namespace App\AppPlugin\BlogPost\Seeder;


use App\AppPlugin\BlogPost\Models\BlogTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BlogTranslationSeeder4 extends Seeder {

    public function run(): void {

        BlogTranslation::unguard();
        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_16.sql');
        DB::unprepared(file_get_contents($tablePath));

        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_17.sql');
        DB::unprepared(file_get_contents($tablePath));

        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_18.sql');
        DB::unprepared(file_get_contents($tablePath));

        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_19.sql');
        DB::unprepared(file_get_contents($tablePath));

        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_20.sql');
        DB::unprepared(file_get_contents($tablePath));

//        $tablePath = public_path('db/SQLDumpSplitterResult/blog_translations_21.sql');
//        DB::unprepared(file_get_contents($tablePath));


    }
}
