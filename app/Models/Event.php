<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan kolom diisi melalui form
    protected $fillable = [
    'category_id',
    'title',
    'description',
    'date',
    'location',
    'price',
    'stock',
    'poster_path', // Cek apakah di database nama kolomnya poster_path atau poster
    ];

    protected $casts = [
    'date' => 'datetime',
    ];

    // Relasi ke Category (supaya kategori bisa tampil di tabel)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}