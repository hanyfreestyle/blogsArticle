<?php

namespace Database\Seeders;

use App\AppPlugin\BlogPost\Seeder\BlogCategorySeeder;
use App\AppPlugin\BlogPost\Seeder\BlogPhotoSeeder;
use App\AppPlugin\BlogPost\Seeder\BlogPivotSeeder;
use App\AppPlugin\BlogPost\Seeder\BlogSeeder;

use App\AppPlugin\Config\Meta\SeederMetaTag;
use App\AppPlugin\Config\Privacy\SeederWebPrivacy;
use App\AppPlugin\Leads\NewsLetter\SeederNewsLetter;

use Database\Seeders\roles\AdminUserSeeder;
use Database\Seeders\roles\PermissionSeeder;
use Database\Seeders\roles\RoleSeeder;
use Database\Seeders\config\DefPhotoSeeder;
use Database\Seeders\config\SettingsTableSeeder;

use Database\Seeders\config\UploadFilterSeeder;
use Database\Seeders\config\UploadFilterSizeSeeder;
use Database\Seeders\config\UsersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run(): void {

        $this->call(PermissionSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(SettingsTableSeeder::class);
        $this->call(SeederMetaTag::class);
        $this->call(DefPhotoSeeder::class);
        $this->call(UploadFilterSeeder::class);
        $this->call(UploadFilterSizeSeeder::class);

        $this->call(BlogCategorySeeder::class);
//        $this->call(BlogSeeder::class);
//        $this->call(BlogPivotSeeder::class);
//        $this->call(BlogPhotoSeeder::class);

    }
}
