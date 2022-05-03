<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OpenWeatherController extends Controller
{
    /*
     * The OpenWeatherApi will return these values
     * (lat & lng) in form of lon & lat
     * (in that order with lon being lng (the longitude) )
     */
    public function getCurrent($lat,$lng)
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather',[
            'lat' => $lat,
            'lon' => $lng,
            'appid' => \Config::get('envvalues.open_weather_key'),
            'units'=>'metric'
        ]);
        return $response->json();
    }

    /*
     * When a user chooses a city, return data about the city and save it
     * as the chosen city for the current user
     */
    public function getTownCurrent($city,$token): JsonResponse
    {
        // if town is not found in the database, return error message
        $town = DB::table('cities')->where('name','like','%'.$city.'%')->first();
        if(!$town){
            return response()->json(['status'=>'bad_city']);
        }

        // if the user token is not found in the database, return error message
        $userId = DB::table('personal_access_tokens')->where('token','=',strtolower(\hash('sha256',$token)))->first()->tokenable_id;
        if (!$userId){
            return response()->json(['status'=>'bad_user']);
        }

        // Find the user and change the chosen city to the one chosen in this call
        $user = User::find($userId);
        $user->chosen_city=$town->name;
        $user->save();

        return response()->json([
            'status'=>'success',
            'data'=>$town
        ]);
    }

    public function getTownForecast($city,$token)       // TODO There is some code duplication here, it could be written simpler
    {
        $town = DB::table('cities')->where('name','like','%'.$city.'%')->first();
        if(!$town){
            return response()->json(['status'=>'bad_city']);
        }

        $userId = DB::table('personal_access_tokens')->where('token','=',strtolower(\hash('sha256',$token)))->first()->tokenable_id;
        if (!$userId){
            return response()->json(['status'=>'bad_user']);
        }

        $user = User::find($userId);
        $user->chosen_city=$town->name;
        $user->save();

        $forecast = DB::table('city_hourly')
            ->where('city','=',$town->name)->get();

        return response()->json([
            'status'=>'success',
            'data'=>$forecast
        ]);
    }

    public function getUserCurrent($token): JsonResponse
    {
        // Search for and if the user token is not found in the database, return error message
        $userId = DB::table('personal_access_tokens')->where('token','=',strtolower(\hash('sha256',$token)))->first()->tokenable_id;
        if (!$userId){
            return response()->json(['status'=>'bad_user']);
        }
        $user = User::find($userId);

        $city = $user->chosen_city;
        $town = DB::table('cities')->where('name','=',$city)->first();

        return response()->json([
            'status'=>'success',
            'data'=>$town
        ]);
    }

    public function getUserForecast($token)
    {
        $userId = DB::table('personal_access_tokens')->where('token','=',strtolower(\hash('sha256',$token)))->first()->tokenable_id;
        if (!$userId){
            return response()->json(['status'=>'bad_user']);
        }
        $user = User::find($userId);

        $city = $user->chosen_city;
        $forecast = DB::table('city_hourly')
            ->where('city','=',$city)->get();

        return response()->json([
            'status'=>'success',
            'data'=>$forecast
        ]);
    }

}
