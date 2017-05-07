<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

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

    protected $rememberTokenName = '';

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

    public function toArray()
    {
        $array = parent::toArray();
        $array['is_admin'] = $this->isAdministrator();
        $array['auth'] = Auth::check();
        return $array;
    }
}
