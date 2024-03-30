<?php

namespace App\AppPlugin\Pages\Seeder;


use App\AppPlugin\Pages\Models\PagePhoto;
use App\AppPlugin\Pages\Models\PagePhotoTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PagePhotoSeeder extends Seeder {

    public function run(): void {
        PagePhoto::unguard();
        $tablePath = public_path('db/page_photos.sql');
        DB::unprepared(file_get_contents($tablePath));

        PagePhotoTranslation::unguard();
        $tablePath = public_path('db/page_photo_translations.sql');
        DB::unprepared(file_get_contents($tablePath));

    }
}
