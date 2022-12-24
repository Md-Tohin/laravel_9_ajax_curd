<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('room.index');
    }

    //  get all rooms
    public function getRooms(){
        $rooms = Room::latest()->get();
        return response()->json($rooms);
    }

    //  store room in database
    public function storeRoom(Request $request){
        $request->validate([
            'name' => 'required|unique:rooms',
            'description' => 'required',
        ],[
            'name.required' => 'Room name is required',
            'name.unique' => 'Room name is already exists',
            'name.description' => 'Room description is required',
        ]);
        $room = new Room();
        $room->name = $request->name;
        $room->description = $request->description;
        $room->save();
        return response()->json([
            'status'=> 'success', 
            'message'=> 'Room saved successfully!!', 
        ]);
    }

    //  store room in database
    public function updateRoom(Request $request){
        $request->validate([
            'name' => 'required|unique:rooms',
            'description' => 'required',
        ],[
            'name.required' => 'Room name is required',
            'name.unique' => 'Room name is already exists',
            'name.description' => 'Room description is required',
        ]);
        $room = Room::find($request->room_id);
        $room->name = $request->name;
        $room->description = $request->description;
        $room->save();
        return response()->json([
            'status'=> 'success', 
            'message'=> 'Room updated successfully!!', 
        ]);
    }

    //  delete room from database
    public function deleteRoom($id){
        Room::find($id)->delete();
        return response()->json([
            'status'=> 'success', 
            'message'=> 'Room deleted successfully!!', 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
