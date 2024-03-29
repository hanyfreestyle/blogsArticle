<?php

namespace Database\Seeders\config;

use App\Helpers\AdminHelper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder {

    public function run(): void {
        $users = [
            ['name' => 'Aya', 'email' => 'm2875650@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Aya Sanad', 'email' => 'mo34545@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Doha', 'email' => 'me685644452020@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Nancy', 'email' =>  'me6654488452020@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Norhan', 'email' => 'me66544884020@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Samar Sami', 'email' => 'me63583@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Shaimaa', 'email' => 'me68598452020@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Samar Tarek', 'email' => 's132393@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Nora Hashem', 'email' => 's3284y@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Rahma Hamed', 'email' => 'd874493@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Alaa Suliman', 'email' => 'a2320983@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Samar', 'email' => 'm949751@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Rana', 'email' => 'm99651@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Amira Bakr', 'email' => 'm829b@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Noha Hammad', 'email' => 'd8744@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Mirna', 'email' => 'm9451@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Doha Gamal', 'email' => 'm9491@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Habiba Gamal', 'email' => 'h123584@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Esraa Salah', 'email' => 'e3453@gmail.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Mohamed Sheref', 'email' => 'Mohamed-Sheref@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Esraa Hussien', 'email' => 'Esraa-Hussien@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Dina Shoaib', 'email' => 'Dina-Shoaib@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Mona Khairy', 'email' => 'Mona-Khairy@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Asmaa', 'email' => 'Asmaa@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'shaimaa sidqy', 'email' => 'shaimaa-sidqy@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Hoda', 'email' => 'Hoda@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'rehab', 'email' => 'rehab@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Islam', 'email' => 'Islam-Salah@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Mohamed Sharkawy', 'email' => 'Mohamed-Sharkawy@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'mohamed elsharkawy', 'email' => 'mohamed-elsharkawy@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Lamia Tarek', 'email' => 'Lamia-Tarek@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],
            ['name' => 'Omnia Samir', 'email' => 'Omnia-Samir@articlesarticle.com', 'password' => Hash::make('12345678'), 'roles_name' => ['editor']],

        ];
        $userCount = User::all()->count();
        if ($userCount == '1') {
            foreach ($users as $key => $value) {
                $user = User::create($value);
                $role = Role::findByName('editor');
                $user->assignRole([$role->id]);
            }
        }

        $addDes = 'مرحبًا بكم في عالمي، حيث الكلمات ترشدكم إلى فهم أعماق أحلامكم. أنا [USERName]، المتخصص في تفسير الأحلام وكتابة المقالات المعلوماتية التي تضيء الجوانب المخفية وراء رموز وقصص أحلامنا.';
        $addDes .= '<br/>'."بخلفية أكاديمية في علم النفس وعلم الاجتماع، أعمق في الأبعاد النفسية والثقافية التي تشكل عوالم أحلامنا. أسعى من خلال كتاباتي لتقديم تحليلات دقيقة ومفهومة، تساعد القراء على ربط تجاربهم الحلمية بواقع حياتهم.";
        $addDes .= '<br/>'."من خلال مقالاتي، ستجدون دليلًا شاملًا لفهم الرسائل الخفية في الأحلام وكيفية تطبيق هذه الفهوم في تعزيز النمو الشخصي والوعي الذاتي. انضموا إلي في هذه الرحلة الاستكشافية لعالم الأحلام، حيث كل حلم هو بوابة لاكتشاف الذات.";

        $users = User::all();
        foreach ($users as $user){
            $user->slug = AdminHelper::Url_Slug($user->name);
            $user->des = str_replace('[USERName]',$user->name,$addDes) ;
            $user->save();
        }

    }
}
