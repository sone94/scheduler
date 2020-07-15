<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index(){

        $events = Event::all();

        foreach($events as $event) {
            $data[] = array(
                'id'   => $event->id,
                'title'   => $event->title,
                'start'   => $event->start_event,
                'end'   => $event->end_event
            );
        }

        return response($data);
        
    }

    public function store(Request $request){

        $start = $request->start;
        $end = $request->end;

        $existed_event = Event::where(function ($query) use ($start, $end) {
            $query->where('start_event', '=', $start)
                  ->orWhere('end_event', '=', $end);
        })->orWhere(function ($query) use ($start, $end) {
            $query->where('start_event', '<', $start)
                  ->where('end_event', '>', $end );
        })->get();
        //dd($existed_event);
        if($existed_event->isEmpty()){
            $event = new Event();

            $event->title = $request->title;
            $event->start_event = $request->start;
            $event->end_event = $request->end;
            $event->user_id = Auth::id();
    
            $event->save();

            $status = "success";
            $msg = "Event has been added successfully";
            $code = 200;
        }
        else {
            $status = "error";
            $msg = "Event for certain date already exists";
            $code = 500;
        }

        return response()->json([$status => $msg], $code);
    }

    public function edit(Request $request){

        $event = Event::find($request->id);

        $event->title = $request->title;
        $event->start_event = $request->start;
        $event->end_event = $request->end;

        if($event->save()){
            $status = "success";
            $msg = "Event has been updated successfully";
            $code = 200;
        }
        else {
            $status = "error";
            $msg = "Can't updated, an error happened";
            $code = 500;
        }

        return response()->json([$status => $msg], $code);

    }

    public function destroy(Request $request){

        $id = $request->id;

        $event = Event::find($id);

        if($event->delete()){
            $status = "success";
            $msg = "Event has been deleted successfully";
            $code = 200;
        }
        else {
            $status = "error";
            $msg = "There was an error";
            $code = 500;
        }

        return response()->json([$status => $msg], $code);
    }
}
