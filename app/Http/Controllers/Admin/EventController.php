<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function Events()
    {
        return view('admin.events.events_list');
    }

    public function CreateEvents()
    {
        return view('admin.events.create_events');
    }

    public function StoreEvent(Request $request)
    {
        try {

            if (isset($request->name) && !empty($request->name))
                throw new \Exception("Please Enter Event Name");
            if (isset($request->explanation) && !empty($request->explanation))
                throw new \Exception("Please Enter Event Explanation");
            if (isset($request->address) && !empty($request->address))
                throw new \Exception("Please Enter Event Address");
            if (isset($request->selected_time) && !empty($request->selected_time))
                throw new \Exception("Please Enter Event Time");
            if ($request->file('files') && !empty($request->file('files')))
                throw new \Exception("Please Upload Event File");

        } catch (\Exception $e)
        {
            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            return response()->json($jsonData);
        }
    }
}
