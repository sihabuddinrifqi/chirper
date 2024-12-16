<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameHashtagColumnInHashtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->renameColumn('hashtag', 'name'); // Mengganti nama kolom 'hashtag' menjadi 'name'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->renameColumn('name', 'hashtag'); // Mengembalikan kolom 'name' menjadi 'hashtag'
        });
    }
}
