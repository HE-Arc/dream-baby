<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RandomDonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Names (30 of each)
        $firstnames_female = [
            'Elisabeth', 'Leela', 'Tess', 'Marlene', 'Amiyah',
            'Emeline', 'Maureen', 'Ellie', 'Danielle', 'Kacie',
            'Dale', 'Loren', 'Lilly', 'Kelly', 'Mila',
            'Jeane', 'Eliane', 'Marie', 'Kim', 'Caroline', 'Julie',
            'Sylvie', 'Fanny', 'Caroline', 'Dorianne', 'Camille',
            'Louise', 'Anna', 'Delphine', 'Jeanine', 'Amanda',
        ];
        $firstnames_male = [
            'John', 'Sergiy', 'Célien', 'Hubert', 'David',
            'Yoan', 'Simon', 'Célestin', 'Guillaume', 'Adrien',
            'Louis', 'Maxime', 'Julien', 'Jules', 'Fabien',
            'Kevin', 'Noah', 'Ludovic', 'Alexandre', 'Jordy',
            'Félix', 'Erwan', 'Etienne', 'Kim', 'Quentin', 'Malik',
            'Damian', 'Paul', 'Farid', 'Lucas', 'Bastien',
        ];
        $lastnames = [
            'Graells', 'Donzé', 'Goloviatinski', 'Droz', 'Grünenwald',
            'Blanc', 'Droz', 'Wermeille', 'Salomon', 'Perrelet',
            'Wohlfahrt', 'Biloni', 'Herbelin', 'Abdalla', 'Bütikofer', 'Chacun',
            'Bueche', 'Hüssler', 'Vorpe', 'Grava', 'Feuillade',
            'Fleury', 'Mottier', 'Petroff', 'Dias', 'Gros',
            'Arfa', 'Jeanneret', 'Rizzoti', 'Prêtre', 'Bianchi',
        ];

        // family antecedents (30)
        $family_antecedents = [
            'Is it free?',
            'Don\'t step on the broken glass.',
            'Malls are great places to shop; I can find everything I need under one roof.',
            'He said he was not there yesterday; however, many people saw him there.',
            'There was no ice cream in the freezer, nor did they have money to go to the store.',
            'The river stole the gods.',
            'Lets all be unique together until we realise we are all the same.',
            'I am counting my calories, yet I really want dessert.',
            'Let me help you with your baggage.',
            'The shooter says goodbye to his love.',
            'The lake is a long way from here.',
            'The clock within this blog and the clock on my laptop are 1 hour different from each other.',
            'Last Friday in three week’s time I saw a spotted striped blue worm shake hands with a legless lizard.',
            'He didn’t want to go to the dentist, yet he went anyway.',
            'She works two jobs to make ends meet; at least, that was her reason for not having time to join us.',
            'How was the math test?',
            'If the Easter Bunny and the Tooth Fairy had babies would they take your teeth and leave chocolate for you?',
            'The book is in front of the table.',
            'He told us a very exciting adventure story.',
            'I will never be this young again. Ever. Oh damn… I just got older.',
            'She did not cheat on the test, for it was not the right thing to do.',
            'We need to rent a room for our party.',
            'If I don’t like something, I’ll stay away from it.',
            'I am never at home on Sundays.',
            'The old apple revels in its authority.',
            'Cats are good pets, for they are clean and are not noisy.',
            'Joe made the sugar cookies; Susan decorated them.',
            'I think I will buy the red car, or I will lease the blue one.',
            'I am happy to take your donation; any amount will be greatly appreciated.',
            'Please wait outside of the house.',
        ];

        // medical antecedents (30)
        $medical_antecedents = [
            'She works two jobs to make ends meet; at least, that was her reason for not having time to join us.',
            'Someone I know recently combined Maple Syrup & buttered Popcorn thinking it would taste like caramel popcorn. It didn’t and they don’t recommend anyone else do it either.',
            'The old apple revels in its authority.',
            'If you like tuna and tomato sauce- try combining the two. It’s really not as bad as it sounds.',
            'The mysterious diary records the voice.',
            'Yeah, I think it\'s a good environment for learning English.',
            'I want to buy a onesie… but know it won’t suit me.',
            'We have a lot of rain in June.',
            'When I was little I had a car door slammed shut on my hand. I still remember it quite vividly.',
            'Sixty-Four comes asking for bread.',
            'Two seats were vacant.',
            'Malls are great places to shop; I can find everything I need under one roof.',
            'We have never been to Asia, nor have we visited Africa.',
            'The waves were crashing on the shore; it was a lovely sight.',
            'Joe made the sugar cookies; Susan decorated them.',
            'Let me help you with your baggage.',
            'The lake is a long way from here.',
            'Last Friday in three week’s time I saw a spotted striped blue worm shake hands with a legless lizard.',
            'I am never at home on Sundays.',
            'Where do random thoughts come from?',
            'Italy is my favorite country; in fact, I plan to spend two weeks there next year.',
            'The book is in front of the table.',
            'Rock music approaches at high velocity.',
            'She folded her handkerchief neatly.',
            'Writing a list of random sentences is harder than I initially thought it would be.',
            'He said he was not there yesterday; however, many people saw him there.',
            'I checked to make sure that he was still alive.',
            'The clock within this blog and the clock on my laptop are 1 hour different from each other.',
            'Christmas is coming.',
            'The river stole the gods.',
        ];

        // Egg Donor
        for ($i = 0; $i < 30; $i++) {
            $fn = $firstnames_female[rand(0, 29)];
            $ln = $lastnames[rand(0, 29)];
            
            $dateint = mt_rand(strtotime('1980-01-01'), strtotime('2000-12-31'));
            $date = date("Y-m-d", $dateint);

            try {
                $id = DB::table('users')->insertGetId([
                    'user_type_id' => 1,
                    'name' => $fn . ' ' . $ln,
                    'email' => $fn . '.' . $ln . '@egg.ch',
                    'password' => bcrypt('123456'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                DB::table('donors')->insert([
                    'user_id' => $id,
                    'sex' => 1,
                    'birth_date' => $date,
                    'eye_color' => rand(1, 3),
                    'hair_color' => rand(1, 3),
                    'ethnicity' => rand(1, 3),
                    'family_antecedents' => $family_antecedents[rand(0, 29)],
                    'medical_antecedents' => $medical_antecedents[rand(0, 29)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            } catch (Exception $e) {
                $i--;
            }
        }

        // Sperm Donor
        for ($i = 0; $i < 30; $i++) {
            $fn = $firstnames_male[rand(0, 29)];
            $ln = $lastnames[rand(0, 29)];

            $dateint = mt_rand(strtotime('1980-01-01'), strtotime('2000-12-31'));
            $date = date("Y-m-d", $dateint);

            try {
                $id = DB::table('users')->insertGetId([
                    'user_type_id' => 1,
                    'name' => $fn . ' ' . $ln,
                    'email' => $fn . '.' . $ln . '@sperm.ch',
                    'password' => bcrypt('123456'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                DB::table('donors')->insert([
                    'user_id' => $id,
                    'sex' => 0,
                    'birth_date' => $date,
                    'eye_color' => rand(1, 3),
                    'hair_color' => rand(1, 3),
                    'ethnicity' => rand(1, 3),
                    'family_antecedents' => $family_antecedents[rand(0, 29)],
                    'medical_antecedents' => $medical_antecedents[rand(0, 29)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            } catch (Exception $e) {
                $i--;
            }
        }
    }
}
