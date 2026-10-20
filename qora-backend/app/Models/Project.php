<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by',
    ];

    // Relasi ke pembuat project
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke bugs di dalam project ini
    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }

    // Relasi ke test cases
    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }
}