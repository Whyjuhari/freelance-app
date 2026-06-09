<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Projects extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'category',
        'description',
        'status',
        'deadline',
        'progress',
        'budget',
        'completed_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function getTotalTaskAttribute()
    {
        return $this->tasks()->count();
    }

    public function getCompletedTasksAttribute()
    {
        return $this->tasks()
            ->where('status', 'done')
            ->count();
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLogs::class, 'project_id');
    }

    public function finances()
    {
        return $this->hasMany(Finances::class, 'project_id');
    }

    // Progress Bar
    // public function getProgressLabelAttribute()
    // {
    //     return match (true) {
    //         $this->progress >= 100 => 'Selesai',
    //         $this->progress >= 80 => 'Hampir Selesai',
    //         $this->progress >= 40 => 'Berjalan',
    //         default => 'Perencanaan',
    //     };
    // }

    // Warna Progress Bar
    public function getProgressColorAttribute()
    {
        return match (true) {
            $this->progress >= 100 => 'bg-green-500',
            $this->progress >= 60  => 'bg-emerald-500',
            $this->progress >= 20  => 'bg-blue-500',
            default                => 'bg-gray-400',
        };
    }

    // public function getStatusLabelAttribute()
    // {
    //     if ($this->progress >= 100) {
    //         $this->status = 'completed';
    //     }

    //     return $this->status;
    // }

    // // Warna Status
    public function getStatusColorAttribute(): string
    {
        return match (true) {
            $this->status === 'active'    => 'bg-blue-100 text-blue-700',
            $this->status === 'completed' => 'bg-green-100 text-green-700',
            $this->status === 'on_hold'   => 'bg-yellow-100 text-yellow-700',
            $this->status === 'canceled'  => 'bg-red-100 text-red-600',
            default                         => 'bg-blue-200 text-gray-700',
        };
    }

    public function getIsUrgentAttribute()
    {
        if (!$this->deadline) return false;

        return now()->diffInDays($this->deadline, false) <= 3
            && $this->progress < 100;
    }


    public function getInitialAttribute(): string
    {
        if (blank($this->name)) {
            return '?';
        }

        return collect(explode(' ', $this->name))
            ->filter()
            ->map(fn($word) => Str::upper(Str::substr($word, 0, 1)))
            ->take(3)
            ->implode('');
    }

    public function getColorAttribute(): string
    {
        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444'];
        $index = crc32((string) $this->name) % count($colors);

        return $colors[$index];
    }

    public function getDurationAttribute()
    {
        if (blank($this->deadline)) {
            return 'Ongoing';
        }

        $start = $this->created_at->startOfDay();
        $end   = Carbon::parse($this->deadline)->startOfDay();

        // Jika deadline lebih kecil dari start date
        if ($end->lessThan($start)) {
            return 'Invalid date';
        }

        $days = $start->diffInDays($end);

        return $days . ' hari';
    }
}
