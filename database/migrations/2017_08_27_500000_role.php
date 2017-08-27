<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Role extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('role', function (Blueprint $table){
		    $table->increments('id')->unsigned();
		    $table->string('role_name');
	    });

	    DB::table('role')->insert(
	    	['role_name' => 'admin',]
	    );

	    DB::table('role')->insert(
		    ['role_name' => 'user',]
	    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
