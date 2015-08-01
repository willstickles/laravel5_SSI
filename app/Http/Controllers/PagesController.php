<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sensor;

class PagesController extends Controller
{

    public function about(){

//        $people = [];

        $people = [
            'Brittany Adams', 'Leo Stickles', 'Harmon Bennett', 'Todd Green'
        ];

        return view('pages.about', compact('people'));
    }

    public function contact(){
        return view('pages.contact');
    }

    public function ssi(){

        $src = "/home/tf/TempSim";

        // define the temperature and humidity sensor
        $TempHum = new Sensor($src, 7);

        $response = [
            'error' => $TempHum->Sensor_Err,
            'stream'    => $TempHum->Sensor_Stream
        ];

        return view('pages.ssi', $TempHum);
    }

    public function sdi(){
        return view('pages.sdi');
    }



}
