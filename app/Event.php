<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const DATE_FORMAT = 'Y-m-d\TH:i';

    public $timestamps = false;

    protected $dates = [
        'time_start',
        'time_end'
    ];

    protected $fillable = [
        'name',
        'time_start',
        'time_end',
        'description',
        'color'
    ];

    public function setTimeStartAttribute($value)
    {
        $this->attributes['time_start'] = Carbon::createFromFormat(self::DATE_FORMAT, $value);
    }

    public function setTimeEndAttribute($value)
    {
        $this->attributes['time_end'] = Carbon::createFromFormat(self::DATE_FORMAT, $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:m');
        $startTime = $this->time_start->format('Y-m-d H:m');
        $endTime = $this->time_end->format('Y-m-d H:m');

        if ($currentTime > $startTime && $currentTime < $endTime) {
            return 'in-progress';
        } elseif ($currentTime > $endTime) {
            return 'done';
        } else {
            return 'new';
        }
    }
}
