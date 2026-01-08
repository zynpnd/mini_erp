<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
    ];

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

}
