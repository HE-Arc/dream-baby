<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * seeds the database with some users.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_type_id'  => 1,
            'name'          => 'Donor1',
            'email'         => 'donor1@sperm.ch',
            'password'      => bcrypt('123456'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'user_type_id'  => 1,
            'name'          => 'Donor2',
            'email'         => 'donor2@sperm.ch',
            'password'      => bcrypt('123456'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'user_type_id'  => 2,
            'name'          => 'Seeker1',
            'email'         => 'seeker1@sperm.ch',
            'password'      => bcrypt('123456'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'user_type_id'  => 2,
            'name'          => 'Seeker2',
            'email'         => 'seeker2@sperm.ch',
            'password'      => bcrypt('123456'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'user_type_id'  => 2,
            'name'          => 'Donor3',
            'email'         => 'Donor3@egg.ch',
            'password'      => bcrypt('123456'),
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
