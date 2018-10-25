<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTypeNameTableSeeder extends Seeder
{
    /**
     * Create de two types of user and the name of the type
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'user_type_name'  => 'Donor',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_types')->insert([
            'user_type_name'  => 'Seeker',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
