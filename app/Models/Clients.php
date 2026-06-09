<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Clients extends Model
{
    protected $appends = ['initial', 'color'];
    protected $fillable = [
        'name',
        'alamat_email',
        'phone',
        'address',
        'user_id',
        'notes',
        'status',
        'company_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Projects::class, 'client_id');
    }
    public function getColorAttribute()
    {
        $colors = [
            'bg-blue-500',
            'bg-green-500',
            'bg-purple-500',
            'bg-pink-500',
            'bg-yellow-500',
        ];

        $index = crc32($this->company_name) % count($colors);
        return $colors[$index];
    }

    public function getInitialAttribute(): string
    {
        if (blank($this->company_name)) {
            return '?';
        }

        return collect(explode(' ', $this->company_name))
            ->filter()
            ->map(fn($word) => Str::upper(Str::substr($word, 0, 1)))
            ->take(2)
            ->implode('');
    }

    public function getFormattedPhoneAttribute()
    {
        if (blank($this->phone)) {
            return '_';
        }

        $phone = preg_replace('/\D/', '', $this->phone);

        // Konversi 62xxxx → 0xxxx
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        // Format standar Indonesia
        if (strlen($phone) >= 10) {
            return preg_replace('/(\d{4})(\d{4})(\d+)/', '$1-$2-$3', $phone);
        }

        return $phone;
    }
}
