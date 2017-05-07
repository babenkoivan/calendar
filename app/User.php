<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function groups()
    {
        return $this->belongsToMany(UserGroup::class);
    }

    public function isAdministrator()
    {
        return $this->groups()->where('name', 'administrator')->count() > 0;
    }
}
