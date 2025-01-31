<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use App\Services\EventService;

class EventController extends Controller
{
    private $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = Event::orderBy('start_date', 'asc')
        ->paginate(10);
        // dd($events);
        return view('manager.events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $check = $this->eventService->checkEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );
        if($check){
            session()->flash('status', 'この時間は既に他の予約が存在します。');
            return redirect()->back()->withInput();
        }

        $startDate = $this->eventService->joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = $this->eventService->joinDateAndTime($request['event_date'], $request['end_time']);
        
        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', '登録が完了しました。');

        return to_route('events.index');
    }

    public function show(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view('manager.events.show', compact('event', 'eventDate', 'startTime', 'endTime'));
    }

    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        // dd($event->is_visible);
        return view('manager.events.edit', compact('event', 'eventDate', 'startTime', 'endTime'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $count = $this->eventService->countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );
        // dd($count);
        if($count > 1){
            session()->flash('status', 'この時間は既に他の予約が存在します。');
            return back()->withInput();
        }

        $startDate = $this->eventService->joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = $this->eventService->joinDateAndTime($request['event_date'], $request['end_time']);
        
        $event = Event::findOrFail($event->id);
        $event->name = $request['event_name'];
        $event->information = $request['information'];
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status', '更新が完了しました。');

        return to_route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
