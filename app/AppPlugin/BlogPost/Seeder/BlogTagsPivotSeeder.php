<?php
namespace App\AppPlugin\BlogPost\Seeder;


use App\AppPlugin\BlogPost\Models\BlogTagsPivot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BlogTagsPivotSeeder extends Seeder {

    public function run(): void {
        BlogTagsPivot::unguard();
        $tablePath = public_path('db/blog_tags_post.sql');
        DB::unprepared(file_get_contents($tablePath));
    }
}
