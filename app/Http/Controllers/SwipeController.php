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
     * can throw an error 403 if the authe user_type is not seeker
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
     * Can throw an error 403 if auth user_type is not seeker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSwipeHistory()
    {
        if (Auth::user()->user_type_id == 2) {
            $seeker_id = SeekerController::getSeekerInfo(Auth::id())->id;
            HistorySwipe::where('seeker_id', $seeker_id)->delete();
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
                array_push($criterionsIds, $criterionId);
            }
        }
        return $criterionsIds;
    }

    public static function history()
    {
        if (Auth::check()) {
            switch (Auth::user()->user_type_id) {
                case 1: // Donor
                    $donor = DonorController::getDonorInfo(Auth::id());
                    $positiveSwipeSeekerIds = HistorySwipe::where('donor_id', $donor->id)->where('like', 1)->pluck('seeker_id')->toArray();
                    $positiveSwipeUserIds = Seeker::whereIn('id', $positiveSwipeSeekerIds)->pluck('user_id')->toArray();

                    break;
                case 2: //Seeker
                    $seeker = SeekerController::getSeekerInfo(Auth::id());
                    $positiveSwipeDonorIds = HistorySwipe::where('seeker_id', $seeker->id)->where('like', 1)->pluck('donor_id')->toArray();
                    $positiveSwipeUserIds = Donor::whereIn('id', $positiveSwipeDonorIds)->pluck('user_id')->toArray();

                    $criterions = Seeker::where('id', $seeker->id)->first()->criterions();

                    $alreadySwipedIds = HistorySwipe::where('seeker_id', $seeker->id)->pluck('donor_id')->toArray();

                    $remainingDonors = Donor::whereNotIn('id', $alreadySwipedIds)
                    ->where('sex', $criterions['main']->sex)
                    ->whereDate('birth_date', '>', $criterions['main']->birth_date_max)
                    ->whereIn('eye_color', SwipeController::getCriterionIdArray($criterions, 'eye'))
                    ->whereIn('hair_color', SwipeController::getCriterionIdArray($criterions, 'hair'))
                    ->whereIn('ethnicity', SwipeController::getCriterionIdArray($criterions, 'ethnicity'))
                    ->inRandomOrder()->get();

                    $swipeCounter = array();
                    $swipeCounter['positiveCount'] = count($positiveSwipeUserIds);
                    $swipeCounter['negativeCount'] = HistorySwipe::where('seeker_id', $seeker->id)->count()-$swipeCounter['positiveCount'];
                    $swipeCounter['remainingCount'] = count($remainingDonors);

                    $swipeCounter['total']=$swipeCounter['positiveCount']+$swipeCounter['negativeCount']+$swipeCounter['remainingCount'];
                    break;
            }
            $positiveSwipeUserNames = User::whereIn('id', $positiveSwipeUserIds)->pluck('name')->toArray();

            $positiveSwipesArray = array_combine($positiveSwipeUserIds, $positiveSwipeUserNames);
        } else {
            return redirect('/home');
        }

        return view('swipe_history', compact('positiveSwipesArray', 'swipeCounter'));
    }
}
