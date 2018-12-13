<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Criteria;
use App\EyeCriteria;
use App\HairCriteria;
use App\EthnicityCriteria;
use App\Question;
use App\HistorySwipe;


class Seeker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Return Critera Model that belongs to the used Seeker
     * @return Critera
     */
    public function criteria()
    {
        return Criteria::where('seeker_id', $this->id)->first();
    }

    /**
     * Return EyeCriteria Models that belongs to the used Seeker
     * @return Array[EyeCriteria]
     */
    public function eyes()
    {
        return $this->hasMany("App\EyeCriteria");
    }

    /**
     * Return HairCriteria Models that belong to the used Seeker
     * @return Array[HairCriteria]
     */
    public function hairs()
    {
        return $this->hasMany("App\HairCriteria");
    }

    /**
     * Return EthnicityCriteria Models that belong to the used Seeker
     * @return Array[EthnicityCriteria]
     */
    public function ethnicities()
    {
        return $this->hasMany("App\EthnicityCriteria");
    }

    /**
     * Return all criterions models that belongs to the used Seeker
     * @return MixedArray[string] Model
     */
    public function criterions()
    {
        $main = $this->criteria();
        $eye = $this->eyes;
        $hair = $this->hairs;
        $ethnicity = $this->ethnicities;
        return compact('main', 'eye', 'hair', 'ethnicity');
    }

    /**
     * Return Question Models of the used Seeker
     */
    public function questions()
    {
        return Question::where('seeker_id', $this->id)->get();
    }

    /**
     * Return SwipeHistory of the used Seeker
     */
    public function swipeHistory()
    {
        return $this->hasMany('App\HistorySwipe')->get();
    }

    /**
     * Return the count of negative swipes in history for the used seeker
     * @return int count
     */
    public function negativeSwipeHistoryCount()
    {
        return HistorySwipe::where('seeker_id', $this->id)->where('like', 0)->count();
    }

    /**
     * Return the count of positive swipes in history for the used seeker
     * @return int count
     */
    public function positiveSwipeHistoryCount()
    {
        return HistorySwipe::where('seeker_id', $this->id)->where('like', 1)->count();
    }

    /**
     * Return array of donors names that are positive in the seeker swipe history
     */
    public function positiveSwipeHistoryDonors_names()
    {
        $donor_ids = HistorySwipe::where('seeker_id', $this->id)->where('like', 1)->pluck('donor_id')->toArray();
        $user_ids = Donor::whereIn('id', $donor_ids)->pluck('user_id')->toArray();
        return User::whereIn('id', $user_ids)->get()->map(function ($user) {
            return collect($user->toArray())
                ->only(['id', 'name'])
                ->all();
        });
    }

    /**
     * Count how many donors can be swipe by the used seeker
     * @return int count
     */
    public function remainingDonorsCount()
    {
        $alreadySwipedIds = HistorySwipe::where('seeker_id', $this->id)->pluck('donor_id')->toArray();
        $criterions = $this->criterions();

        return Donor::whereNotIn('id', $alreadySwipedIds)
                    ->where('sex', $criterions['main']->sex)
                    ->whereDate('birth_date', '>', $criterions['main']->birth_date_max)
                    ->whereIn('eye_color', Seeker::getCriterionIdArray($criterions, 'eye'))
                    ->whereIn('hair_color', Seeker::getCriterionIdArray($criterions, 'hair'))
                    ->whereIn('ethnicity', Seeker::getCriterionIdArray($criterions, 'ethnicity'))
                    ->count();
    }

    /**
     * Delete all the seeker's swipe history
     */
    public function deleteSwipeHistory()
    {
        HistorySwipe::where('seeker_id', $this->id)->delete();
    }

    /**
     * Return User Model of the used Seeker
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User')->first();
    }

    /**
     * Get an array of criterions ids.
     * Foreach criterions at the criterion key, if the item is searched, this item is push to the array.
     * Then, the array is return
     *
     * @param array[string]Criteria $criterions array of criterions
     * @param string $criterionKey criteria class name
     * @return array[]int array of criterions id
     */
    private static function getCriterionIdArray($criterions, $criterionKey)
    {
        $criterionsIds = [];
        foreach ($criterions[$criterionKey] as $item) {
            if ($item->searched) {
                switch ($criterionKey) {
                    case "eye":
                        $criterionId = $item->eye_color;
                        break;
                    case "hair":
                        $criterionId = $item->hair_color;
                        break;
                    case "ethnicity":
                        $criterionId = $item->ethnicity;
                        break;
                }
                array_push($criterionsIds, $criterionId);
            }
        }
        return $criterionsIds;
    }
}
