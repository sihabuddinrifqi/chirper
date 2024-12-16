<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model

{

    use HasFactory;

    // Jika menggunakan guarded, pastikan tidak ada pengaturan yang menghalangi pengisian massal
    // protected $guarded = []; // Ini akan mengizinkan semua kolom untuk mass assignment

    // Atau gunakan $fillable
    protected $fillable = ['name']; // lebih aman untuk mengizinkan beberapa kolom saja

    public function chirps()
    {
        return $this->belongsToMany(Chirp::class, 'chirp_hashtag', 'hashtag_id', 'chirp_id');
    }
}

