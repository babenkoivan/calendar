<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'color' => 'required'
        ]);

        $event = new Event($request->all());

        $user = Auth::user();
        $event->user_id = $user->id;

        $event->save();
    }

    public function update(Event $event, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|sometimes',
            'time_start' => 'required|sometimes',
            'time_end' => 'required|sometimes',
            'color' => 'required|sometimes'
        ]);

        $event->fill($request->all())->save();
    }

    public function delete(Event $event)
    {
        $event->delete();
    }

    public function list()
    {
        return Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->time_start,
                'end' => $event->time_end,
                'color' => $event->color,
                'description' => $event->description
            ];
        })->all();
    }
}
