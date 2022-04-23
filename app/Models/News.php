<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'text',
        'img',
    ];

    public function sluggable(): array
    {
        return [
            'slug'=> [
                'source'=>'title',
            ]
        ];
    }
}
