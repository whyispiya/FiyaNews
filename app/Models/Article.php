<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'author',
        'image',
        'excerpt',
        'content',
        'source',
        'category',
        'created_at' 
    ];
    /**
     * 👤 Hubungan ke tabel Users (Penulis Artikel)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 💬 Hubungan ke tabel Comments (Satu artikel punya banyak komentar)
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ❤️ Hubungan ke tabel Likes (Satu artikel punya banyak like)
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}