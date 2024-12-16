<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNameToHashtagInHashtagsTable extends Migration
{
    public function up()
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->renameColumn('name', 'hashtag');
        });
    }

    public function down()
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->renameColumn('hashtag', 'name');
        });
    }
}

