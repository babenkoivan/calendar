<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function validateTime(Event $event)
    {
        if ($event->time_end->timestamp < $event->time_start->timestamp) {
            throw new HttpResponseException(response()->json(
                ['time_end' => ['The end time must be greater than the start time']], 422)
            );
        }
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

        $this->validateTime($event);

        $event->save();
    }

    public function update(Event $event, Request $request)
    {
        if (!Auth::user()->can('modify', $event)) {
            return;
        }

        $this->validate($request, [
            'name' => 'sometimes|required',
            'time_start' => 'sometimes|required',
            'time_end' => 'sometimes|required',
            'color' => 'sometimes|required'
        ]);

        $event->fill($request->all());

        $this->validateTime($event);

        $event->save();
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
        return Event::with('user')->get()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->time_start->toDateTimeString(),
                'end' => $event->time_end->toDateTimeString(),
                'color' => $event->color,
                'description' => $event->description,
                'editable' => Auth::user()->can('modify', $event),
                'author' => $event->user->name,
                'className' => 'status-'.$event->status(),
                'allDay' => $event->allDay(),
            ];
        })->all();
    }
}
