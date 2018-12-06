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
        // --- Seeker with seeker_id 1 ---
        //
        DB::table('criterias')->insert([
            'seeker_id'               => 1,
            'sex'                   => 0,
            'birth_date_max'        => Carbon::now()->subYears(99)->format('Y-m-d'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // eye_criterias
        DB::table('eye_criterias')->insert([
            'seeker_id'               => 1,
            'eye_color'             => 1,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'seeker_id'               => 1,
            'eye_color'             => 2,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'seeker_id'               => 1,
            'eye_color'             => 3,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // hair_criterias
        DB::table('hair_criterias')->insert([
            'seeker_id'               => 1,
            'hair_color'            => 1,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'seeker_id'               => 1,
            'hair_color'            => 2,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'seeker_id'               => 1,
            'hair_color'            => 3,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // ethnicity_criterias
        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 1,
            'ethnicity'             => 1,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 1,
            'ethnicity'             => 2,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 1,
            'ethnicity'             => 3,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //
        // --- Seeker with seeker_id 2 ---
        //
        DB::table('criterias')->insert([
            'seeker_id'               => 2,
            'sex'                   => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // eye_criterias
        DB::table('eye_criterias')->insert([
            'seeker_id'               => 2,
            'eye_color'             => 1,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'seeker_id'               => 2,
            'eye_color'             => 2,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('eye_criterias')->insert([
            'seeker_id'               => 2,
            'eye_color'             => 3,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // hair_criterias
        DB::table('hair_criterias')->insert([
            'seeker_id'               => 2,
            'hair_color'            => 2,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'seeker_id'               => 2,
            'hair_color'            => 3,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hair_criterias')->insert([
            'seeker_id'               => 2,
            'hair_color'            => 3,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // ethnicity_criterias
        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 2,
            'ethnicity'             => 1,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 2,
            'ethnicity'             => 2,
            'searched'              => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('ethnicity_criterias')->insert([
            'seeker_id'               => 2,
            'ethnicity'             => 3,
            'searched'              => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
