<?php

use Illuminate\Database\Seeder;
use App\UserType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            UserTypeNameTableSeeder::class,
            DonorsTableSeeder::class,
            SeekersTableSeeder::class,
            QuestionAnswersTableSeeder::class,
            EthnicitiesTableSeeder::class,
            HairColorsTableSeeder::class,
            EyeColorsTableSeeder::class,
            CriteriaTableSeeder::class,
            RandomDonorSeeder::class,
            RandomQuestionsAnswersTableSeeder::class,
        ]);
    }
}
