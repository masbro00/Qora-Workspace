<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bug extends Model
{
   use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'severity',
        'priority',
        'status',
        'assigned_to',
        'reported_by',
        'evidence',
    ];

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke QA/User yang melaporkan
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // Relasi ke Developer yang ditugaskan
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function activities()
{
    return $this->hasMany(Activity::class)->latest();
}

}