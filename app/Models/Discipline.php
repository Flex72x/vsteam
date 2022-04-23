<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Discipline extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'group_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug'=> [
                'source'=>'name',
            ]
        ];
    }

    public function groups()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function lecture()
    {
        return $this->hasMany(Task::class)->where('type', 1);
    }

    public function practica()
    {
        return $this->hasMany(Task::class)->where('type', 2);
    }
}
