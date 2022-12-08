<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::all();
        if($albums->count()>0){
            $data = [];
            $names = [];
            foreach($albums as $a){ $names[] = $a->name; $data[] = $a->images->count(); }
        }else{
            $names = ['Album 1', 'Album 2', 'Album 3', 'Album 4', 'Album 5', 'Album 6', 'Album 7'];
            $data = [65, 59, 80, 81, 56, 55, 40];
        }
        $chartjs = app()->chartjs
            ->name('albumsChart')
            ->type('bar')
            ->size(['width' => 600, 'height' => 300])
            ->labels($names)
            ->datasets([
                [
                    "label" => "Images/Album",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $data,
                ],
            ])
            ->options([]);

        return view("welcome", compact('chartjs'));
    }
}
