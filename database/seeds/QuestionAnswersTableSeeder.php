<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_answers')->insert([
            'donor_id'      => 1,
            'seeker_id'     => 1,
            'message'       => 'Hello, Do you have any illness undeclared?',
            'question'      => 1,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('question_answers')->insert([
            'donor_id'      => 1,
            'seeker_id'     => 1,
            'message'       => 'No.',
            'question'      => 0,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('question_answers')->insert([
            'donor_id'      => 1,
            'seeker_id'     => 1,
            'message'       => 'If i make 32 children with your DNA, would that pose a problem?',
            'question'      => 1,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        
        DB::table('question_answers')->insert([
            'donor_id'      => 1,
            'seeker_id'     => 1,
            'message'       => 'I dont mind having many offsprings :D',
            'question'      => 0,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('question_answers')->insert([
            'donor_id'      => 2,
            'seeker_id'     => 1,
            'message'       => 'Do you want to meet?',
            'question'      => 1,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        
        DB::table('question_answers')->insert([
            'donor_id'      => 2,
            'seeker_id'     => 1,
            'message'       => 'Sorry, but no.',
            'question'      => 0,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        
        DB::table('question_answers')->insert([
            'donor_id'      => 2,
            'seeker_id'     => 2,
            'message'       => 'Do you suffer from obesity?',
            'question'      => 1,
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
