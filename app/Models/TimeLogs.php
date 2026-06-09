<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLogs extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
