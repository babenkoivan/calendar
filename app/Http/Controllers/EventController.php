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
        $event->user_id = Auth::id();

        $event->save();
    }

    public function update(Event $event, Request $request)
    {
        if (!Auth::user()->can('modify', $event)) {
            return;
        }

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
        if (!Auth::user()->can('modify', $event)) {
            return;
        }

        $event->delete();
    }

    public function list()
    {
        if (Auth::user()->can('viewAll', Event::class)) {
            $events = Event::all();
        } else {
            $events = Event::where('user_id', Auth::id())->get();
        }

        return $events->map(function($event) {
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
