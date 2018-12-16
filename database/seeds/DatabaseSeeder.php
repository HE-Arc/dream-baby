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
            UserTypeNameTableSeeder::class,
            EthnicitiesTableSeeder::class,
            HairColorsTableSeeder::class,
            EyeColorsTableSeeder::class,
            UsersTableSeeder::class,
            DonorsTableSeeder::class,
            SeekersTableSeeder::class,
            CriteriaTableSeeder::class,
            RandomDonorSeeder::class,
            RandomQuestionsAnswersTableSeeder::class,
        ]);
    }
}
