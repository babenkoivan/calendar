<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const DATE_FORMAT = [
        'DB' => 'Y-m-d H:i:s',
        'ISO' => 'Y-m-d\TH:i'
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'time_start',
        'time_end',
        'description',
        'color'
    ];

    public function setTimeStartAttribute($value)
    {
        $this->attributes['time_start'] = Carbon::createFromFormat(self::DATE_FORMAT['ISO'], $value);
    }

    public function getTimeStartAttribute($value)
    {
        return Carbon::createFromFormat(self::DATE_FORMAT['DB'], $value)->format(self::DATE_FORMAT['ISO']);
    }

    public function setTimeEndAttribute($value)
    {
        $this->attributes['time_end'] = Carbon::createFromFormat(self::DATE_FORMAT['ISO'], $value);
    }

    public function getTimeEndAttribute($value)
    {
        return Carbon::createFromFormat(self::DATE_FORMAT['DB'], $value)->format(self::DATE_FORMAT['ISO']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
