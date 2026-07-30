<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organization_id', 'category_id', 'partner_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Menandakan atribut: 1 Event harus terpaut pada satu wujud Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Event dapat memiliki satu Partner (opsional)
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Event dimiliki oleh satu Organization (tenant/kepanitiaan)
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Event dapat memiliki banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function averageRating()
    {
    return $this->reviews()->avg('rating');
    }
}