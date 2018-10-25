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
        $donorType=new UserType();
        $donorType->user_type_name="Donor";
        $donorType->save();

        $seekerType=new UserType();
        $seekerType->user_type_name="Seeker";
        $seekerType->save();
    }
}
