<?php

namespace App\Http\Controllers;

use App\Donor;
use App\Ethnicity;
use App\EyeColor;
use App\HairColor;
use App\HistorySwipe;
use App\Seeker;
use App\User;
use Response;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SwipeController extends Controller
{
    /**
     * Search random donors for the authented seeker
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (Auth::user()->user_type_id == 2) {
            $bufferSize = 2;
            Cookie::queue(Cookie::forget('hiddenDonorIds'));
            $donorsArray = SwipeController::getRandomDonorProfil($bufferSize + 1);

            return view('seeker.search', $donorsArray);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Add a donor in auth user swipe history using request object
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addToSwipeHistory(Request $request)
    {
        //TO-DO: add validator for request
        if (Auth::user()->user_type_id == 2) {
            $historySwipe = new HistorySwipe();

            $historySwipe->seeker_id = SeekerController::getSeekerInfo(Auth::id())->id;
            $historySwipe->donor_id = Input::get('donor_id');
            $historySwipe->like = Input::get('like');

            $historySwipe->save();

            return Response::json(SwipeController::getRandomDonorProfil(1));

        } else {
            $response = array(
                'status' => 'KO',
                'msg' => 'Invalid use',
            );
            return Response::json($response, 401);
        }
    }

    /**
     * Delete the swipe history of the auth user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSwipeHistory()
    {
        if (Auth::user()->user_type_id == 2) {
            $seeker = SeekerController::getSeekerInfo(Auth::id());

            $seeker->deleteSwipeHistory();

            return back()->with('success', 'Swipe history deleted successfully');
        } else {
            return redirect('/home');
        }
    }

    /**
     * Get random donor profils using the criteria of the auth seeker criterions
     * @param int $count number of random donor profils
     * @return ['donorsArray' => $donorsArray]
     */
    public static function getRandomDonorProfil(int $count)
    {
        $seekerId = SeekerController::getSeekerInfo(Auth::id())->id;

        $criterions = Seeker::where('id', $seekerId)->first()->criterions();

        if (Cookie::get('hiddenDonorIds') != null && $count == 1) { //if count == 1 it means that this function is called from an ajax request
            $hiddenDonorIds = json_decode(Cookie::get('hiddenDonorIds'));
        } else {
            $hiddenDonorIds = [];
        }

        $alreadySwipedIds = HistorySwipe::where('seeker_id', $seekerId)->pluck('donor_id')->toArray();

        $donorProfil = Donor::whereNotIn('id', $alreadySwipedIds)
            ->whereNotIn('id', $hiddenDonorIds)
            ->where('sex', $criterions['main']->sex)
            ->whereDate('birth_date', '>', $criterions['main']->birth_date_max)
            ->whereIn('eye_color', SwipeController::getCriterionIdArray($criterions, 'eye'))
            ->whereIn('hair_color', SwipeController::getCriterionIdArray($criterions, 'hair'))
            ->whereIn('ethnicity', SwipeController::getCriterionIdArray($criterions, 'ethnicity'))
            ->inRandomOrder()->take($count)->get();

        if (count($donorProfil) == 0) {
            return ['donorsArray' => null];
        }

        $donorsArray = [];

        for ($i = 0; $i < $count; $i++) {
            if (isset($donorProfil[$i])) {
                $donor = $donorProfil[$i];
                $username = User::where('id', $donor->user_id)->first()->name;
                $ethnicity = Ethnicity::where('id', $donor->ethnicity)->first()->name;
                $haircolor = HairColor::where('id', $donor->hair_color)->first()->name;
                $eyecolor = EyeColor::where('id', $donor->eye_color)->first()->name;
                array_push($donorsArray, compact('donor', 'username', 'ethnicity', 'haircolor', 'eyecolor'));
                array_push($hiddenDonorIds, $donor->id);
            }
        }

        Cookie::queue(Cookie::forever('hiddenDonorIds', json_encode($hiddenDonorIds)));
        return ['donorsArray' => $donorsArray];
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
               $criterionsIds[]= $criterionId;
            }
        }
        return $criterionsIds;
    }

    public static function history()
    {
        if (Auth::check()) {
            switch (Auth::user()->user_type_id) {
                case 1: // Donor
                    return redirect('/home');

                case 2: //Seeker
                    $seeker = SeekerController::getSeekerInfo(Auth::id());

                    $criterions = $seeker->criterions();

                    $swipeCounter = array();
                    $swipeCounter['positiveCount'] = $seeker->positiveSwipeHistoryCount();
                    $swipeCounter['negativeCount'] = $seeker->negativeSwipeHistoryCount();
                    $swipeCounter['remainingCount'] = $seeker->remainingDonorsCount();

                    $swipeCounter['total']=$swipeCounter['positiveCount']+$swipeCounter['negativeCount']+$swipeCounter['remainingCount'];
                    
                    $positiveSwipesArray = $seeker->positiveSwipeHistoryDonors_names();

                    return view('seeker.swipe_history', compact('positiveSwipesArray', 'swipeCounter'));
            }
        } else {
            return redirect('/home');
        }
    }
}
