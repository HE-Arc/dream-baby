<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','eye_color','ethnicity','hair_color','medical_antecedents','family_antecedents','sex','birth_date'
    ];

    /**
     * Return Question Models of the used Donor
     */
    public function questions()
    {
        return Question::where('donor_id', $this->id)->get();
    }

    /**
     * Return User Model of the used Seeker
     * @return User
     */
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
