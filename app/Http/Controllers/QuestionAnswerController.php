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

                    $questions = Question::where('donor_id', $seeker->id);
                    $questions_answers = QuestionAnswerController::getQuestionsAnswersArray($questions);

                    return view('donor.myquestions', compact('donor', 'user', 'questions_answers'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());

                    $questions = Question::where('seeker_id', $seeker->id);
                    $questions_answers = QuestionAnswerController::getQuestionsAnswersArray($questions);

                    return view('seeker.myquestions', compact('seeker', 'user', 'questions_answers'));
            }
        } else {
            return view('home');
        }
    }

    /**
     * Show questions and answers of a donor using its id
     * @param int $donor_id
     * @return \Illuminate\Http\Response
     */
    public function questions(int $donor_id)
    {
        // TODO
    }

    /**
     * Ask a question to a donor using its id and the request.
     * Verifiy the auth user is a seeker and save the question in the DB.
     * @param int $donor_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create_question($donor_id)
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
     * Get an array with questions as key and answers as values
     * from a questions models array
     * @param Array[Question => Answer] $questions
     */
    private static function getQuestionsAnswersArray($questions)
    {
        $questions_answers = [];
        foreach ($questions as $item) {
            $questions_answers[$item] = $item->answer();
        }
        return $questions_answers;
    }
}
