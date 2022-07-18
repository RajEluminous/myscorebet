<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/EventContrrolller.php
# Created on : JULY 2018
# Purpose: Controller for event management at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Subevent;
use Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrEvents = Event::where('isDeleted','n')->orderBy('month', 'desc')->get();
        return view('admin.events.index', compact('arrEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  //validate form fields
        $rules = [
            'event_name'    => 'required|max:50',
            'description'   => 'max:255',
            'month'         => 'required',
            'isActive'      => 'required'
        ];

        $objEvents = Event::where(['event_name' => $request->event_name ,'isDeleted'=> 'n'])->get()->first();
        
        if(@isset($objEvents)) {
            $rules = [
            'event_name'    => 'unique:events',
            ];
        }        
        $this->validate($request, $rules);

        //add record in restaurant table
        $arrEventDetails    =  Event::create([
            'event_name'    => $request->event_name,
            'description'   => $request->description,
            'month'         => $request->month,
            'isActive'      => $request->isActive,
        ]);
        return redirect()->route(ADMIN.'.events.index')->withSuccess(trans('app.event_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objEvent = Event::findOrFail($id);
        return view('admin.events.edit', compact('objEvent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate form fields
        Validator::make($request->all(), [
            'event_name'    => 'required|max:50',
            'description'   => 'max:255',
            'month'         => 'required',
            'isActive'      => 'required',
        ])->validate();

        //get event details
        $objEvent = Event::findOrFail($id);
        $objEvent->update([
            'event_name'    => $request->event_name,
            'description'   => $request->description,
            'month'         => $request->month,
            'isActive'      => $request->isActive,
            'updated_at'    => date('Y-m-d H:i:s'),   
        ]);

        if($request->isActive=='n') {
            Subevent::where('eventid', $id)->update(['isActive'=>'n']);
        }
        else {
            Subevent::where('eventid', $id)->update(['isActive'=>'y']);   
        }     
        return redirect()->route(ADMIN.'.events.index')->withSuccess(trans('app.event_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Update is deleted flag of event data
        Event::where('id', $id)->update(['isDeleted'=>'y']);
        Subevent::where('eventid', $id)->update(['isDeleted'=>'y']);
        return redirect()->route(ADMIN.'.events.index')->withSuccess(trans('app.event_destroy'));
    }
}
