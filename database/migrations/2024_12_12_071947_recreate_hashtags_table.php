<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateHashtagsTable extends Migration
{
    public function up()
    {
        // Buat tabel sementara
        

        // Salin data dari tabel lama ke tabel baru (gunakan hanya kolom yang relevan)
        DB::statement('INSERT INTO hashtags_temp (id, hashtag, created_at, updated_at) SELECT id, hashtag, created_at, updated_at FROM hashtags');

        // Hapus tabel lama
        Schema::dropIfExists('hashtags');

        // Ganti nama tabel baru menjadi nama tabel asli
        Schema::rename('hashtags_temp', 'hashtags');

        Schema::getColumnListing('hashtags');

    }

    public function down()
    {
        Schema::dropIfExists('hashtags');
    }
}
