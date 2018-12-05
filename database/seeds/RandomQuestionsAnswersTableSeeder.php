<?php

use Illuminate\Database\Seeder;
use App\Seeker;
use App\Donor;
use Carbon\Carbon;

class RandomQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For test
        $question_id = DB::table('questions')->insertGetId([
            'seeker_id'     => 1,
            'donor_id'      => 1,
            'message'       => 'Hello, Do you have any illness undeclared?',
            'anonymous'     => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('answers')->insert([
            'question_id'   => $question_id,
            'reply'         => 'No...',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        // questions (30)
        $questions = [
            'Do you swear often?',
            'Can you play an instrument?',
            'When is your birthday?',
            'Which do you like better, Google or Apple?',
            'Have you ever ironed clothes?',
            'What is you favorite snack?',
            'How many pairs of shoes do you own?',
            'Have you ever hitchhiked?',
            'Do you like bugs?',
            'Have you ever had bad sun burn?',
            'Have you ever been water skiing?',
            'Do you like ice in your drinks?',
            'What is your favorite fruit?',
            'What are your favorite movies?',
            'Do you like the beach?',
            'Where did you go to school?',
            'What is the strangest thing you\'ve eaten?',
            'Have you ever changed a diaper?',
            'What is your favorite fast food meal?',
            'Which do you like better, book or eBook?',
            'What is your favorite comedy?',
            'Have you ever ran in a race?',
            'Which do you like better, beer or wine?',
            'Where have you traveled?',
            'Which do you like better, TV or movies?',
            'Have you ever broken a bone?',
            'Who do you most resemble?',
            'Which do you like better, pens or pencils?',
            'What is the worst movie you\'ve seen?',
            'Have you ever burnt your hair?',
        ];

        // replies (30)
        $replies = [
            'What was the person thinking when they discovered cow’s milk was fine for human consumption… and why did they do it in the first place!?',
            'I am happy to take your donation; any amount will be greatly appreciated.',
            'There were white out conditions in the town; subsequently, the roads were impassable.',
            'He told us a very exciting adventure story.',
            'She always speaks to him in a loud voice.',
            'Tom got a small piece of pie.',
            'He turned in the research paper on Friday; otherwise, he would have not passed the class.',
            'I will never be this young again. Ever. Oh damn… I just got older.',
            'She did her best to help him.',
            'Cats are good pets, for they are clean and are not noisy.',
            'The clock within this blog and the clock on my laptop are 1 hour different from each other.',
            'Wow, does that work?',
            'The quick brown fox jumps over the lazy dog.',
            'This is a Japanese doll.',
            'I checked to make sure that he was still alive.',
            'Sixty-Four comes asking for bread.',
            'I am counting my calories, yet I really want dessert.',
            'Rock music approaches at high velocity.',
            'He didn’t want to go to the dentist, yet he went anyway.',
            'I\'d rather be a bird than a fish.',
            'Mary plays the piano.',
            'There was no ice cream in the freezer, nor did they have money to go to the store.',
            'Hurry!',
            'It was getting dark, and we weren’t there yet.',
            'Sometimes it is better to just walk away from things and go back to them later when you’re in a better frame of mind.',
            'The river stole the gods.',
            'She wrote him a long letter, but he didn\'t read it.',
            'Malls are great places to shop; I can find everything I need under one roof.',
            'I would have gotten the promotion, but my attendance wasn’t good enough.',
            'Everyone was busy, so I went to the movie alone.',
        ];

        for($i = 0 ; $i < 50; $i++) // Generate 50 randoms Questions and Answers
        {
            $seeker_id = Seeker::inRandomOrder()->first()->id;
            $donor_id = Donor::inRandomOrder()->first()->id;
            $message = $questions[rand(0, 29)];
            $anonymous = false;
            $reply = $replies[rand(0, 29)];

            $question_id = DB::table('questions')->insertGetId([
                'seeker_id'     => $seeker_id,
                'donor_id'      => $donor_id,
                'message'       => $message,
                'anonymous'     => $anonymous,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
    
            DB::table('answers')->insert([
                'question_id'   => $question_id,
                'reply'         => $reply,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
