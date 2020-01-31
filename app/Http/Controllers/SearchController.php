<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use RuneStat\RS3\API;

class SearchController extends Controller
{
    public function doSearch (Request $request) {
        $request->validate([
            'search' => 'required'
        ]);

        $search = $request->input('search');

        $api = new API;

        try {
            $player = $api->getProfile($search);            
        } catch (\Exception $e) {
            return response()->json(['message' => 'The given data was invalid.', 'errors' => [ 'player' => [$e->getMessage()]]], 422);
        }

        $activities = [];
        foreach ($player->getActivities()->getActivities() as $activity) {
            $activities[] = [
                'name' => $activity->getText(),
                'details' => $activity->getDetails(),
                'date' => Carbon::instance($activity->getdate())->diffForHumans()
            ];
        }

        $array = [
            'activities' => $activities,
            'combat' => $player->getCombatLevel()
        ];

        return response()->json($array);
    }
}
