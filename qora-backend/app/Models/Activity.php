<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // INI KUNCI JAWABANNYA: Mendaftarkan kolom ke "Daftar Putih"
    protected $fillable = [
        'bug_id', 
        'user_id', 
        'action', 
        'description'
    ];

    // Relasi ke User (Siapa yang melakukan aktivitas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Bug (Aktivitas ini milik Bug yang mana)
    public function bug()
    {
        return $this->belongsTo(Bug::class);
    }
}