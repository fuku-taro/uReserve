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

    /**
     * Store a newly created resource in storage.
     */
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

        // dd($event, $eventDate, $startTime, $endTime);
        return view('manager.events.show', compact('event', 'eventDate', 'startTime', 'endTime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
