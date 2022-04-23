<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Task extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'text',
        'discipline_id',
        'type',
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

    public function disciplines()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
}
