<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'slug', 'owner_user_id', 'status', 'logo_path', 'description'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function averageRating()
    {
        return Review::whereIn('event_id', $this->events()->pluck('id'))->avg('rating');
    }

    public function reviewsCount()
    {
        return Review::whereIn('event_id', $this->events()->pluck('id'))->count();
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}