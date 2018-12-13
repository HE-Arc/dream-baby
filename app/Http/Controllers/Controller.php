<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get an array of names from a model array
     * Key are id and value are object
     * @return Array[string]
     */
    public static function getNamesArray($tab)
    {
        $new_tab = [];
        foreach($tab as $item) {
            $new_tab[$item->id] = $item->name;
        }
        return $new_tab;
    }
}
