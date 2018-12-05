<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class QuestionAnswerController extends Controller
{
    /**
     * Return questions of auth user depending of its user_type
     */
    public function myquestions()
    {
        if(Auth::user()->user_type_id == 1) // Donor
        {
            // TODO
            // return view myquestions donor
        }
        elseif (Auth::user()->user_type_id == 2)    // Seeker
        {
            // TODO
            // return view myquestions seeker
        }
        else {
            abort(403);
        }
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
}
