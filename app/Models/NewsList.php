<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author',
        'title',
        'image',
        'content',
        'posted_by'
    ];

    public function comments() {
        return $this->hasMany(NewsComment::class);
    }
}
