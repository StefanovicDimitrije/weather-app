<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_hourly', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('city');
            $table->dateTime('time');
            $table->integer('hour_from');
            $table->integer('current');
            $table->integer('feels');

            $table->string('icon');

            $table->foreign('city')->references('name')->on('cities');
        });

        $jsonData = file_get_contents(__DIR__ . "/data.json");
        $cities = json_decode($jsonData,true);

        for ($i = 0; $i < count($cities);$i++){

            // Get weather data based on one-call api
            $data = $this->oneCallApi($cities[$i]['lat'],$cities[$i]['lng']);

            // Insert data about current weather into table cities
            DB::table('cities')->where('id','=',$i+1)
                ->update([
                    'time'=> date('Y-m-d H:i:s'),
                    'current'=> $data['current']['temp'],
                    'feels'=> $data['current']['feels_like'],
                    'icon'=> $data['current']['weather'][0]['icon']
                ]);

            for($j = 0; $j < 12;$j++){
                // New insert into city_hourly about the hourly weathers
                DB::table('city_hourly')
                    ->insert([
                       'city'=>$cities[$i]['name'],
                       'time'=>date('Y-m-d H:i:s'),
                       'hour_from'=>$j+1,
                       'current'=>$data['hourly'][$j]['temp'],
                       'feels'=>$data['hourly'][$j]['feels_like'],
                       'icon'=>$data['hourly'][$j]['weather'][0]['icon']    // TODO Maybe add more info about the weather into the table
                    ]);
            }
        }

    }

    public function oneCallApi($lat,$lng){

        $response = Http::get('https://api.openweathermap.org/data/2.5/onecall',[
            'lat' => $lat,
            'lon' => $lng,
            'exclude'=>'minutely,daily,alerts',
            'appid' => \Config::get('envvalues.open_weather_key'),
            'units'=>'metric'
        ]);

        return $response->json();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_hourly');
    }
};
