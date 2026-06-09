<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLogs::class);
    }

    public function getNameAttribute(): string
    {
        return $this->title;
    }
}
