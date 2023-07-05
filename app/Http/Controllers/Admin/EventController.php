<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventFileModel;
use App\Models\EventModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function Events()
    {
        $events = EventModel::where('deleted', 0)->get();

        $data = [
            "events" => $events
        ];

        return view('admin.events.events_list', $data);
    }

    public function CreateEvents()
    {
        return view('admin.events.create_events');
    }

    public function StoreEvent(Request $request)
    {
        try {

            $name = $request->name;
            $explanation = $request->explanation;
            $address = $request->address;
            $selected_time = $request->selected_time;
            $files = [];

            if (!isset($request->name))
                throw new \Exception("Please Enter Event Name");
            if (!isset($request->explanation))
                throw new \Exception("Please Enter Event Explanation");
            if (!isset($request->address))
                throw new \Exception("Please Enter Event Address");
            if (!isset($request->selected_time))
                throw new \Exception("Please Enter Event Time");
            if (!$request->file('files'))
                throw new \Exception("Please Upload Event File");

            foreach ($request->file('files') as $file) {
                $files[] = $file;
            }

            $event = new EventModel();

            $event->name = $name;
            $event->explanation = $explanation;
            $event->address = $address;
            $event->selected_time = $selected_time;
            $event->created_by = Auth::user()->id;

            $event->save();

            if ($event->save()) {

                foreach ($files as $file) {
                    $image_extension = $file->getClientOriginalExtension();
                    if ($image_extension == "jpg" || "jpeg" || "png") {
                        $image = $file;
                        $file_name = date('YmdHi') . '.' . 'events' . '.' . $image->getClientOriginalName();
                        $file_upload = $image->storeAs('events', $file_name, 'public');
                    } else {
                        throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                    }

                    $event_file = new EventFileModel();

                    $event_file->event_id = $event->id;
                    $event_file->file = $file_upload;

                    $event_file->save();
                }
            }

            $jsonData = [
                "error" => 0,
                "message" => "Event Created Successfuly",
                "url" => route("Events")
            ];

            return response()->json($jsonData);

        } catch (\Exception $e) {
            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            return response()->json($jsonData);
        }
    }

    public function EditEvent($id)
    {
        $event = EventModel::find($id);
        $file = EventFileModel::where('event_id', $id)->get();


        $data = [
            "event" => $event,
            "file" => $file
        ];
        return view('admin.events.event_edit', $data);
    }

    public function UpdateEvent(Request $request, $id)
    {
        try {

            $name          = $request->name;
            $explanation   = $request->explanation;
            $address       = $request->address;
            $selected_time = $request->selected_time;
            $files         = [];

            if (!isset($request->name))
                throw new \Exception("Please Enter Event Name");
            if (!isset($request->explanation))
                throw new \Exception("Please Enter Event Explanation");
            if (!isset($request->address))
                throw new \Exception("Please Enter Event Address");
            if (!isset($request->selected_time))
                throw new \Exception("Please Enter Event Time");

            foreach ($request->file('files') as $file) {
                $files[] = $file;
            }

            $event = EventModel::find($id);

            $event->name          = $name;
            $event->explanation   = $explanation;
            $event->address       = $address;
            $event->selected_time = $selected_time;
            $event->created_by    = Auth::user()->id;

            $event->update();

            if ($event->update()) {

                if ($files){

                    $existFiles = EventFileModel::where('event_id',$id)->get();
                    foreach ($existFiles as $exist){
                        if (file_exists(storage_path("app/public/$exist->file"))){
                            unlink(storage_path("app/public/$exist->file"));
                            $exist->delete();
                        } else {
                            throw new \Exception("File Does Not Exist");
                        }
                    }

                    foreach ($files as $file) {
                        $image_extension = $file->getClientOriginalExtension();
                        if ($image_extension == "jpg" || "jpeg" || "png") {
                            $image = $file;
                            $file_name = date('YmdHi') . '.' . 'events' . '.' . $image->getClientOriginalName();
                            $file_upload = $image->storeAs('events', $file_name, 'public');
                        } else {
                            throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                        }

                        $event_file = new EventFileModel();

                        $event_file->event_id = $event->id;
                        $event_file->file = $file_upload;

                        $event_file->save();
                    }
                }
            }

            $jsonData = [
                "error"   => 0,
                "message" => "Event Updated Successfuly",
                "url"     => route("Events")
            ];

            return response()->json($jsonData);

        } catch (\Exception $e) {

            $jsonData = [
                "error"   => 1,
                "message" => $e->getMessage()
            ];

            return response()->json($jsonData);
        }
    }

    public function DeleteEvent($id)
    {
        try {
            $event = EventModel::where('id', $id)->first();
            if (!$event){
                throw new \Exception("The Event Could Not Found");
            }
            else {
                $event->deleted = 1;
                $event->deleted_by = Auth::user()->id;
                $event->update();
                if (!$event->update()){
                    throw new \Exception("The Event Could Not Delete. Please Try Again Later.");
                }
                else {
                    $notification = [
                        'message'    => 'The Event Deleted Successfully',
                        'alert-type' => 'success'
                    ];

                    return redirect()->back()->with($notification);
                }
            }
        }
        catch (\Exception $e){

            $notification = [
                'message'    => $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
}
