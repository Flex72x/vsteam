<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Group extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
    ];

    public function sluggable(): array
    {
        return [
            'slug'=> [
                'source'=>'name',
            ]
        ];
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }
}
