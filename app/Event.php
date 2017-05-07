<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        $currentTime = Carbon::now()->timestamp;
        $startTime = $this->time_start->timestamp;
        $endTime = $this->time_end->timestamp;

        if ($currentTime > $startTime && $currentTime < $endTime) {
            return 'in-progress';
        } elseif ($currentTime > $endTime) {
            return 'done';
        } else {
            return 'new';
        }
    }

    public function allDay()
    {
        $startTime = $this->time_start->format('H:i');
        $endTime = $this->time_end->format('H:i');

        return $startTime == '00:00' && $endTime == '00:00';
    }
}
