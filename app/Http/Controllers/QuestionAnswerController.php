<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Donor;
use App\Seeker;
use App\Question;
use App\Answer;

class QuestionAnswerController extends Controller
{
    /**
     * Return questions of auth user depending of its user_type
     * @return \Illuminate\Http\Response
     */
    public function myquestions()
    {
        if(Auth::check()) {
            switch(Auth::user()->user_type_id)
            {
                case 1: // Donor
                    $donor=DonorController::getDonorInfo(Auth::id());
                    $user=DonorController::getUserInfo(Auth::id());

                    $questions = $donor->questions();
                    $answers = QuestionAnswerController::getAnswersArray($questions);

                    return view('donor.myquestions', compact('donor', 'user', 'questions', 'answers'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());

                    $questions = $seeker->questions();
                    $answers = QuestionAnswerController::getAnswersArray($questions);

                    return view('seeker.myquestions', compact('seeker', 'user', 'questions', 'answers'));
            }
        } else {
            return view('home');
        }
    }

    /**
     * Show questions and answers of a donor using its user id
     * @param int $user_id
     * @return \Illuminate\Http\Response
     */
    public function questions(int $user_id)
    {
        if(Auth::check())
        {
            if(Auth::user()->user_type_id == 2)
            {
                $donor=DonorController::getDonorInfo($user_id);
                if ($donor==null) {
                    abort(404);
                }
                $user_donor = $donor->user();

                $questions = $donor->questions();
                $answers = QuestionAnswerController::getAnswersArray($questions);

                return view('donor.questions', compact('donor', 'user_donor', 'questions', 'answers'));
            }
        }
        return view('home');
    }

    /**
     * Ask a question to a donor using its user_id and the request.
     * Verifiy the auth user is a seeker and save the question in the DB.
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create_question($user_id)
    {
        // TODO
    }

    /**
     * Reply to a question using the request.
     * Verifying the auth user is a donor and save the answer in the DB.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create_reply()
    {
        // TODO
    }

    /**
     * Delete a question using its id.
     * A seeker can delete a question
     * 
     * @param int $question_id
     */
    public function deleteQuestion(int $question_id)
    {
        // TODO
    }

    /**
     * Delete all the questions asked by the auth id.
     * Verifiy the auth user is a seeker and delete all questions and related answers
     */
    public function deleteAllQuestions()
    {
        if(Auth::user()->user_type_id == 2)
        {
            // TODO
        } else {
            abort(403);
        }
    }

    /**
     * Get an array of answers from a questions models array.
     * The key is the question id and the content is the answer
     * @param Array[Question] $questions
     * @return Array[Answer]
     */
    private static function getAnswersArray($questions)
    {
        $answers = [];
        foreach ($questions as $item) {
            $answers[$item->id] = $item->answer();
        }
        return $answers;
    }
}
