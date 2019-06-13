<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class IOSController extends Controller
{
    public function login($username, $password){
        $HttpRequestArray = [];

        if(User::where('name', $username)->count() > 0){
            $pwd = User::where('name', $username)->first()->password;
            if (Hash::check($password, $pwd)) {
                $HttpRequestArray = [
                    'correct' => true,
                    'username' => $username,
                    'userid' => User::where('name',$username)->first()->id,
                    'usermail' => User::where('name',$username)->first()->email,
                    'error' => 'none'

                ];
            }else{
                $HttpRequestArray = [
                    'correct' => false,
                    'username' => 'false',
                    'userid' => 0,
                    'usermail' => "nomail",
                    'error' => 'wrongpw'

                ];
            }
        }else{
            $HttpRequestArray = [
                'correct' => false,
                'username' => 'false',
                'userid' => 0,
                'usermail' => "nomail",
                'error' => 'nouser'

            ];
        }
        return $HttpRequestArray;
    }
    public function showtimer($user){
        $timerarray = \App\Timer::where("user", $user)->cursor();
        $printarray = [];
        foreach ($timerarray as $time) {
            array_push($printarray, $time);
        }
        return $printarray;
    }
    public function addtimer($userUrl, $dateUrl, $inTimeUrl, $outTimeUrl, $totalUrl){
        $inHour = $inTimeUrl[0] . $inTimeUrl[1];
        $inMinute = $inTimeUrl[2] . $inTimeUrl[3];
        $outHour = $outTimeUrl[0] . $outTimeUrl[1];
        $outMinute = $outTimeUrl[2] . $outTimeUrl[3];        
        $Day = $dateUrl[0] . $dateUrl[1];
        $Month = $dateUrl[2] . $dateUrl[3];
        $Year = $dateUrl[4] . $dateUrl[5];

        $time = new \App\Timer;
        $time->inTime = $inTimeUrl;
        $time->outTime = $outTimeUrl;
        $time->totalHours = $totalUrl;
        $time->user = $userUrl;
        $time->date = $dateUrl;
        $time->save();

        $allShit = "User: ".$userUrl."<br>Ankomst: " . $inHour . ":" . $inMinute ."<br>Afgang: ". $outHour.":".$outMinute. "<br>Date: " . $Day ."/". $Month."-".$Year."<br>Total timer: ".$totalUrl/10;

        return ['feedback' => true];
    }

}

