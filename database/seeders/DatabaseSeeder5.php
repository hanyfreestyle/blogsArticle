<?php

namespace Database\Seeders;

use App\AppPlugin\BlogPost\Seeder\BlogTranslationSeeder5;
use Illuminate\Database\Seeder;


class DatabaseSeeder5 extends Seeder {

    public function run(): void {
        $this->call(BlogTranslationSeeder5::class);

    }
}
