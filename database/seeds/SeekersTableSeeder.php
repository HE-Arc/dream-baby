<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SeekersTableSeeder extends Seeder
{
    /**
     * seeds the seekers table
     *
     * @return void
     */
    public function run()
    {
        DB::table('seekers')->insert([
            'user_id'               => 3,
            'bio'                   => 'looking for good quality sperm, wants baby but my man is sterile',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        
        DB::table('seekers')->insert([
            'user_id'               => 4,
            'bio'                   => 'looking for a friend who wants a baby',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
