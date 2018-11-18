<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // --- Seeker with user_id 3 ---
        //
        DB::table('criterias')->insert([
            'user_id'               => 3,
            'sex'                   => 0,
            'birth_date_max'        => Carbon::now()->subYears(30)->format('Y-m-d H:i:s'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // eye_criterias
        DB::table('eye_criterias')->insert([
            'user_id'               => 3,
            'eye_color'             => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'user_id'               => 3,
            'eye_color'             => 2,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // hair_criterias
        DB::table('hair_criterias')->insert([
            'user_id'               => 3,
            'hair_color'            => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'user_id'               => 3,
            'hair_color'            => 3,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // ethnicity_criterias
        DB::table('ethnicity_criterias')->insert([
            'user_id'               => 3,
            'ethnicity_id'          => 2,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'user_id'               => 3,
            'ethnicity_id'          => 3,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //
        // --- Seeker with user_id 4 ---
        //
        DB::table('criterias')->insert([
            'user_id'               => 4,
            'sex'                   => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // eye_criterias
        DB::table('eye_criterias')->insert([
            'user_id'               => 4,
            'eye_color'             => 2,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'user_id'               => 4,
            'eye_color'             => 3,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // hair_criterias
        DB::table('hair_criterias')->insert([
            'user_id'               => 4,
            'hair_color'            => 2,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'user_id'               => 4,
            'hair_color'            => 3,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // ethnicity_criterias
        DB::table('ethnicity_criterias')->insert([
            'user_id'               => 4,
            'ethnicity_id'          => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'user_id'               => 4,
            'ethnicity_id'          => 2,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
