<?php
namespace App\AppPlugin\BlogPost\Seeder;

use App\AppPlugin\BlogPost\Models\BlogTags;
use App\AppPlugin\BlogPost\Models\BlogTagsTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BlogTagsSeeder extends Seeder {

    public function run(): void {

        BlogTags::unguard();
        $tablePath = public_path('db/blog_tags.sql');
        DB::unprepared(file_get_contents($tablePath));

        BlogTagsTranslation::unguard();
        $tablePath = public_path('db/blog_tags_translations.sql');
        DB::unprepared(file_get_contents($tablePath));
    }
}
