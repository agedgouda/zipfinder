<?php

namespace App\Http\Controllers;

use App\RecommendationMatrix;
use App\LaData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class RecommendationController extends Controller
{
    public function show(Request $request)
    {
        $url = 'https://raw.githubusercontent.com/agedgouda/Coursera_Capstone/master/ZIP%20Codes.geojson';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $la_str = curl_exec($ch);
        curl_close($ch);
        $la_geojson = json_decode($la_str);

        //$la_geojson = $list->features;

        $costSelect = $request->cost;

        $preferencesArray = $request->all();
        unset($preferencesArray["cost"]);
        unset($preferencesArray["submit"]);
        unset($preferencesArray["_token"]);
        $preferences = array_keys($preferencesArray);

        $query = RecommendationMatrix::query();
        switch ($costSelect) {
        case 0:
            $query = $query->where('cost_2018','<', 500000);
            break;
        case 1:
            $query = $query->where('cost_2018','<', 700000);
            break;
        case 2:
            $query = $query->where('cost_2018','<' ,900000);
            break;
        }

        $recommendationMatrix = $query->get();

        $score = [];

        foreach($recommendationMatrix as $zip) {
            $score[$zip->zip] = 0;
            foreach($preferences as $field) {
                $score[$zip->zip] += $zip->$field;
            }
        }

        $filteredZips = Arr::where($score, function ($value, $key) {
            return $value > 0;
        });

        $zips = array_keys($filteredZips);

        $la_data = LaData::whereIn('zip',$zips)
            ->get();


        foreach($la_data as $zip) {
            foreach($filteredZips as $key=>$match) {
                if ($key == $zip->zip) {
                    $zip->score = $match;
                }
            }
        }

        $la_data = array_reverse(array_values(Arr::sort($la_data, function ($value) {
            return $value['score'];
        })));

        $max_score = $la_data[0]->score;


        return view('welcome', ['la_data' => $la_data, 'max_score' => $max_score, 'la_geojson' => $la_str ]);

    }
}
