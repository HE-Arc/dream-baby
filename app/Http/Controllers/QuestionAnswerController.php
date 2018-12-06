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
                    $seekers_users = QuestionAnswerController::getSeekersUsersArray($questions);
                    $answers = QuestionAnswerController::getAnswersArray($questions);

                    return view('donor.myquestions', compact('donor', 'user', 'questions', 'answers', 'seekers_users'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());

                    $questions = $seeker->questions();
                    $donors_users = QuestionAnswerController::getDonorsUsersArray($questions);
                    $answers = QuestionAnswerController::getAnswersArray($questions);

                    return view('seeker.myquestions', compact('seeker', 'user', 'questions', 'answers', 'donors_users'));
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
     * Delete a question using its id
     * and delete the answer if exist
     * 
     * @param int $question_id
     */
    public function deleteQuestion(int $question_id)
    {
        if(Auth::check()) {
            switch(Auth::user()->user_type_id)
            {
                case 1: // Donor
                    $donor = DonorController::getDonorInfo(Auth::id());
                    $question = Question::where('id', $question_id)->first();
                    if($question->donor_id == $donor->id) {
                        $answer = $question->answer();
                        if(isset($answer)){
                            $answer->delete();
                        }
                        $question->delete();
                        return back()->with('success', 'Question deleted successfully');
                    }
                    return back()->withErrors('failure', 'You\'re not allowed to delete this question');
                case 2: // Seeker
                    $seeker = SeekerController::getSeekerInfo(Auth::id());
                    $question = Question::where('id', $question_id)->first();
                    if($question->seeker_id == $seeker->id) {
                        $answer = $question->answer();
                        if(isset($answer)){
                            $answer->delete();
                        }
                        $question->delete();
                        return back()->with('success', 'Question deleted successfully');
                    }
                    return back()->withErrors('failure', 'You\'re not allowed to delete this question');
            }
        } else {
            return back()->withErrors('failure', 'You\'re not allowed to delete this question');
        }
    }

    /**
     * Delete all the questions of the auth id.
     * and delete the answers exists
     */
    public function deleteAllQuestions()
    {
        if(Auth::check())
        {
            switch(Auth::user()->user_type_id)
            {
                case 1: // Donor
                    $donor = DonorController::getDonorInfo(Auth::id());
                    $questions = Question::where('donor_id', $donor->id)->get();
                    break;
                case 2: // seeker
                    $seeker = SeekerController::getSeekerInfo(Auth::id());
                    $questions = Question::where('seeker_id', $seeker->id)->get();
                    break;
            }
            foreach($questions as $question) {
                $answer = $question->answer();
                if(isset($answer)){
                    $answer->delete();
                }
                $question->delete();
            }
            return back()->with('success', 'Question deleted successfully');
        } else {
            return back()->withErrors('failure', 'You\'re not allowed to delete this question');
        }
    }

    /**
     * Get an array of seeker users from a questions models array.
     * The key is the donor id and the content is the user
     * @param Array[Question] $questions
     * @return Array[Seeker]
     */
    private static function getSeekersUsersArray($questions)
    {
        $seekers_users = [];
        foreach ($questions as $item) {
            $seeker = $item->seeker();
            $seekers_users[$seeker->id] = $seeker->user();
        }
        return $seekers_users;
    }

    /**
     * Get an array of donor users from a questions models array.
     * The key is the donor id and the content is the user
     * @param Array[Question] $questions
     * @return Array[Donor]
     */
    private static function getDonorsUsersArray($questions)
    {
        $donors_users = [];
        foreach ($questions as $item) {
            $donor = $item->donor();
            $donors_users[$donor->id] = $donor->user();
        }
        return $donors_users;
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
