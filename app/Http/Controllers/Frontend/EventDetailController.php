<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EventFileModel;
use App\Models\EventModel;
use App\Models\EventParticipantsModel;
use Illuminate\Http\Request;

class EventDetailController extends Controller
{
    public function DetailEvent($id)
    {
        $event = EventModel::find($id);
        $event_file = EventFileModel::where('event_id', $id)->get();

        $data = [
          "event" => $event,
          "files" => $event_file
        ];

        return view('frontend.event.event_detail', $data);
    }

    public function JoinEvent(Request $request)
    {
        try {

            $event_id = $request->event_id;
            $user_id  = $request->user_id;

            if (!isset($event_id)){
                throw new \Exception("The Event Could Not Found");
            }
            if (!isset($user_id)){
                throw new \Exception("The User Could Not Found");
            }

            $participant = new EventParticipantsModel();

            $participant->event_id     = $event_id;
            $participant->participants = $user_id;
            $participant->status       = 1;

            $participant->save();

            $jsonData = [
                "error"      => 0,
                "message"    => "You Have Registered To The Event Successfuly",
//                "url"       => route("login")
            ];

            return response()->json($jsonData);

        } catch (\Exception $e){

            $jsonData = [
                "error"    => 1,
                "message"  => $e->getMessage()
            ];

            return response()->json($jsonData);

        }
    }
}
