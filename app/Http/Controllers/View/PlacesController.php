<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Place;
use App\WifiPoint;
use Carbon;
use Illuminate\Http\Request;

class PlacesController extends Controller
{

    public function createBlocksAndFloors()
    {
        foreach(['A', 'B', 'C', 'D', 'E'] as $block){

            if($block == 'E'){
                $start = -2;
            } else {
                $start = 1;
            }
            for($i = $start; $i <= 8; $i++){

                Place::create(
                    [
                        'block' => $block,
                        'floor' => $i
                    ]
                );
            }
        }
    }

    public function index()
    {
        $places = Place
            ::with([
                'wifi_points'
            ])
            ->get();

        $result = [];
        foreach($places as $place){
            if(!isset($result[$place->block][$place->floor])){
                $result[$place->block][$place->floor] = [];
            }
            $result[$place->block][$place->floor][] = $place;

        }

        return view('places', compact('result'));
    }
}