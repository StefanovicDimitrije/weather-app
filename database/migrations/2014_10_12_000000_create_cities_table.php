<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('lat',6,4);
            $table->double('lng',6,4);
            $table->dateTime('time')->nullable();
            $table->integer('current')->nullable();
            $table->integer('feels')->nullable();
            //humidity
            //cloud cover
            $table->string('icon')->nullable();
        });

        $jsonData = file_get_contents(__DIR__ . "/data.json");
        $data = json_decode($jsonData,true);

        DB::table('cities')->insert($data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
