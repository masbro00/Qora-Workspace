<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'steps',
        'expected_result',
        'actual_result',
        'status',
        'created_by',
    ];

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke QA yang membuat Test Case
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}   