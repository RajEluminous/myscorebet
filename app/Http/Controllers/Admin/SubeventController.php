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
# Purpose: Controller for sub event management at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subevent;
use App\Event;
use App\WinningUsers;
use App\UserScorePrediction;
use File;
use DB;
use Validator;

class SubeventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($getEventId = '')
    {
        $strSubeventQry = Subevent::with('event')->where('isDeleted','n');
        if($getEventId!='') {
            $strSubeventQry->where('eventid', base64_decode($getEventId));
        }
        $arrSubevents = $strSubeventQry->orderBy('expiry_datetime', 'desc')->get();
        return view('admin.subevents.index', compact('arrSubevents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrEvents = Event::getEvents();
        $arrStatus = array('n' => 'Inactive', 'y' => 'Active');
        return view('admin.subevents.create', compact('arrEvents','arrStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate form fields
        $rules = [
            'eventid'       => 'required',
            'name_team1'    => 'required|max:50',
            'name_team2'    => 'required|max:50',
            'isActive'      => 'required',
            'logo_team1'    => 'image|mimes:jpeg,png,jpg|max:2000',
            'logo_team2'    => 'image|mimes:jpeg,png,jpg|max:2000',
            'expiry_datetime'=> 'required'
        ];

        $customMessages = [
            'max' => 'Image size must be less than 2MB.',
            'image' => 'File type must be an image.'
        ];
        $this->validate($request, $rules, $customMessages);

        //upload logo of team 1
        if($file = $request->hasFile('logo_team1')) 
        {
            $strImageName1 = microtime(true).'.'.$request->logo_team1->getClientOriginalExtension();
            $request->logo_team1->move(config('variables.images.folder'), $strImageName1);
            //$restaurant->restaurant_image = $strImageName ;
            $request->request->add(['logo_img_team1' => $strImageName1]);
        }

         //upload logo of team 1
        if($file = $request->hasFile('logo_team2')) 
        {
            $strImageName2 = microtime(true).'.'.$request->logo_team2->getClientOriginalExtension();
            $request->logo_team2->move(config('variables.images.folder'), $strImageName2);
            //$restaurant->restaurant_image = $strImageName ;
            $request->request->add(['logo_img_team2' => $strImageName2]);
        }

        //add record in sub event table
        $arrSubeventDetails   =  Subevent::create([
            'eventid'         => $request->eventid,
            'name_team1'      => $request->name_team1,
            'name_team2'      => $request->name_team2,
            'expiry_datetime' => date('Y-m-d H:i:s',strtotime($request->expiry_datetime)),
            'logo_team1'      => $request->logo_img_team1,
            'logo_team2'      => $request->logo_img_team2,
            'isActive'        => $request->isActive,
        ]);
        return redirect()->route(ADMIN.'.subevents.index')->withSuccess(trans('app.subevent_store'));
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
        $arrEvents = Event::getEvents();
        $objSubevent = Subevent::findOrFail($id);

        $arrStatus = array('n' => 'Inactive', 'y' => 'Active');
        $strGetTime =  date('Y-m-d H:i:s', strtotime($objSubevent->expiry_datetime));
        $strExpiredTimeValid = ($strGetTime >= date('Y-m-d H:i:s')) ? '': '1';

        //If date expired then cancel event flag will be disable
        if($strExpiredTimeValid!='1') {
            $arrStatus['c'] = 'Cancel';
        }
        
        return view('admin.subevents.edit', compact('objSubevent','arrEvents','arrStatus'));
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
        $rules = [
            'eventid'       => 'required',
            'name_team1'    => 'required|max:50',
            'name_team2'    => 'required|max:50',
            'isActive'      => 'required',
            'logo_team1'    => 'image|mimes:jpeg,png,jpg|max:2000',
            'logo_team2'    => 'image|mimes:jpeg,png,jpg|max:2000'
        ];

        $customMessages = [
            'max' => 'Image size must be less than 2MB.',
            'image' => 'File type must be an image.'
        ];
        $this->validate($request, $rules, $customMessages);

        //If validity true then show score otherwise not
        if($request->fpIsScoreValid=='1'){
            Validator::make($request->all(), [
                'score_team1'   => 'required|numeric',
                'score_team2'   => 'required|numeric',
            ])->validate();
        }
        
        //get sub event details
        $objSubevent = Subevent::findOrFail($id);
        //If logo of team 1 set
        if($request->hasFile('logo_team1')) 
        {
            //delete previous image
            if($objSubevent->logo_team1) {            
                File::delete(config('variables.images.folder').$objSubevent->logo_team1);
            }
            $strImageName1 = microtime(true).'.'.$request->logo_team1->getClientOriginalExtension();
            $request->logo_team1->move(config('variables.images.folder'), $strImageName1);
        }
         //If logo of team 2 set
        if($request->hasFile('logo_team2')) 
        {
            //delete previous image
            if($objSubevent->logo_team2) {            
                File::delete(config('variables.images.folder').$objSubevent->logo_team2);
            }
            $strImageName2 = microtime(true).'.'.$request->logo_team2->getClientOriginalExtension();
            $request->logo_team2->move(config('variables.images.folder'), $strImageName2);
        }
        
        //Get datetime based on the expiry date condition
        $strDateTime = ($request->fpIsScoreValid=='1') ? $request->old_expiry_datetime : $request->expiry_datetime;

        //Get date to store in valid format
        $objSubevent->update([
            'eventid'       => $request->eventid,
            'name_team1'    => $request->name_team1,
            'name_team2'    => $request->name_team2,
            'score_team1'   => $request->score_team1,
            'score_team2'   => $request->score_team2,
            'logo_team1'    => isset($strImageName1) ? $strImageName1 : $objSubevent->logo_team1,
            'logo_team2'    => isset($strImageName2) ? $strImageName2 : $objSubevent->logo_team2,
            'expiry_datetime' =>  date('Y-m-d H:i:s',strtotime($strDateTime)),
            'isActive'      => $request->isActive,
            'updated_at'    => date('Y-m-d H:i:s'),    
        ]);  

        //If score are set then uodate all user prediction score according to the admin & send an email to all users.
        $arrUsers = array();
        //If status cancelled
        if($request->isActive == 'c') {
            $arrGetPredictions = UserScorePrediction::from('user_score_prediction as usp')
                ->leftJoin('members as m','usp.uid', '=', 'm.id')
                ->leftJoin('events as e','usp.eventid', '=', 'e.id')
                ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
                ->select('usp.uid','m.email','m.first_name', 'm.last_name','e.event_name','se.name_team1','se.name_team2')
                ->where([
                            ['usp.eventid','=',$request->eventid],
                            ['usp.subeventid','=',$id],
                            ['e.isDeleted','=','n'],
                            ['se.isDeleted','=','n']
                        ])
                        ->orderBy('usp.uid', 'asc')
                        ->get();

            // Send an email to the user for cancelled match
            if($arrGetPredictions) {
                $strCustomerMailSubject = config('emailcontents.emails.6.subject');
                foreach($arrGetPredictions as $predictionsVal) {
                    $strCustomerMessage     = config('emailcontents.emails.6.message');
                    $strCustomerName = $predictionsVal->first_name.' '.$predictionsVal->last_name;
                    $strSubEvents  = $predictionsVal->name_team1.' vs '.$predictionsVal->name_team2;
                    $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
                    $strCustomerMessage     = str_replace('[EVENT_NAME]', $predictionsVal->event_name, $strCustomerMessage);
                    $strCustomerMessage     = str_replace('[SUBEVENTS]',$strSubEvents, $strCustomerMessage);
                    $isSent = sendEmail($predictionsVal->email, $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");
                }
            }

            //Delete  user predictions        
            $deletedPrediction = DB::table('user_score_prediction')->where([['eventid', '=', $request->eventid],['subeventid', '=', $id]])->delete();
        }
        
        if($request->fpIsScoreValid=='1' && isset($request->score_team1) && isset($request->score_team2)) {
            
            $arrUserPredictions = UserScorePrediction::getAllUsersPredictions($request->eventid, $id, $request->score_team1, $request->score_team2);

            //It users are present
            if(isset($arrUserPredictions)) {
                foreach($arrUserPredictions as $item) {
                    //Update user prediction score flag
                    $objUserPredictions = UserScorePrediction::findOrFail($item->id);
                    $objUserPredictions->update([
                        'point'       => 1,
                        'isValid'     => 'y',                
                        'updated_at'  => date('Y-m-d H:i:s')     
                    ]);

                    //GET WINNING USERS ID
                    $arrUsers[] = $item->uid;
                }
            } 

            //Insert data in winning table
            if(!empty($arrUsers)) {
                foreach($arrUsers as $userVal) {

                    $points = UserScorePrediction::where([
                        ['uid','=',$userVal],
                        ['isValid','=','y']       
                    ])->count();

                    $arrWinningUsers = WinningUsers::updateOrCreate(
                        ['uuid' => $userVal],
                        [
                            'uuid'        => $userVal,
                            'points'      => $points,                
                            'updated_at'  => date('Y-m-d H:i:s'),                
                        ]
                    );
                }
            }
        }
        return redirect()->route(ADMIN.'.subevents.index')->withSuccess(trans('app.subevent_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Update is deleted flag of subevent data
        Subevent::where('id', $id)->update(['isDeleted'=>'y']);
        return redirect()->route(ADMIN.'.subevents.index')->withSuccess(trans('app.subevent_destroy'));
    }
}
