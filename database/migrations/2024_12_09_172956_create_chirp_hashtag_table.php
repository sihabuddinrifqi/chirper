<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_chirp_hashtag_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChirpHashtagTable extends Migration
{
    public function up()
    {
        Schema::create('chirp_hashtag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chirp_id')->constrained()->onDelete('cascade');
            $table->foreignId('hashtag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chirp_hashtag');
    }
}

