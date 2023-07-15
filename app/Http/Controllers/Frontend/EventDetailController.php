<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EventFileModel;
use App\Models\EventModel;
use App\Models\EventParticipantsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventDetailController extends Controller
{
    public function DetailEvent($id)
    {
        $user_id            = Auth::user()->id;
        $event              = EventModel::find($id);
        $event_file         = EventFileModel::where('event_id', $id)->get();
        $event_participants = EventParticipantsModel::where('event_id', $id)->where('participants', $user_id)->first();
        $count              = EventParticipantsModel::where('event_id', $id)->where('status', 1)->count();

        $data = [
            "event"              => $event,
            "files"              => $event_file,
            "event_participants" => $event_participants,
            "user_id"            => $user_id,
            "count"              => $count
        ];

        return view('frontend.event.event_detail', $data);
    }

    public function JoinEvent(Request $request)
    {
        try {

            $event_id     = $request->event_id;
            $user_id      = $request->user_id;
            $cancel_event = $request->cancel_participants;

            if (!isset($event_id)){
                throw new \Exception("The Event Could Not Found");
            }
            if (!isset($user_id)){
                throw new \Exception("The User Could Not Found");
            }

            $participant = EventParticipantsModel::where('event_id', $event_id)->where('participants', $user_id)->first();

            if (isset($participant) && !empty($participant)){

                $participant->delete();
                if ($cancel_event){
                    $status = 0;
                } else {
                    $status = 1;
                }
                $participant = new EventParticipantsModel();

                $participant->event_id     = $event_id;
                $participant->participants = $user_id;
                $participant->status       = $status;

                $participant->save();

                $output['error']   = 0;
                $output['message'] = "You Status Has Changed To Joining The Event";


            } else {

                $participant = new EventParticipantsModel();

                $participant->event_id     = $event_id;
                $participant->participants = $user_id;
                $participant->status       = 1;

                $participant->save();

                $output['error']   = 0;
                $output['message'] = "You Have Registered To The Event Successfuly";

            }

            return response()->json($output);

        } catch (\Exception $e){

            $output['error']   = 1;
            $output['message'] = $e->getMessage();

            return response()->json($output);

        }
    }
}
