<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropHashtagsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('hashtags');
    }

    public function down()
    {
        Schema::create('hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
}
