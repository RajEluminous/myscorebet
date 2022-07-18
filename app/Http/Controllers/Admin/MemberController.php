<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/MemberController.php
# Created on : JULY 2018
# Purpose: Controller for memebers listing management at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\UserScorePrediction;
use Hash;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrMembers = Member::orderBy('created_at', 'desc')->get();
        return view('admin.members.index', compact('arrMembers'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $arrMembers = Member::findOrFail($id);
        return view('admin.members.view', compact('arrMembers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arrMembers = Member::findOrFail($id);
        return view('admin.members.edit', compact('arrMembers'));
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
        Validator::make($request->all(), [
            'first_name' => 'required|max:35',
            'last_name'  => 'required',
            'isActive'   => 'required'
        ])->validate();   

        Member::where('id', $id)
            ->update([
                'first_name' => ucfirst(trim($request->first_name)),
                'last_name'  => ucfirst(trim($request->last_name)),
                'isActive'   => trim($request->isActive),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        //If request for a new password is set then save the new password
        if(isset($request->fp_txt_generate_new_pw)) {
            Member::where('id', $id)
            ->update([
                'password'=> Hash::make($request->fp_txt_generate_new_pw)
            ]);
        }  

        return redirect()->route(ADMIN.'.members.index')->withSuccess(trans('app.memeber_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Member::destroy($id);
        $objDeleteMember = Member::deleteMember($id);
        return back()->withSuccess(trans('app.member_destroy'));
    }

    /**
     * Get user predictions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function showPredictions($id)
    {
        $intMemberId = base64_decode($id);
        if($intMemberId!='') {     
            $arrUserPredictions = UserScorePrediction::userPredictions($intMemberId);
            $arrMembers = Member::findOrFail($intMemberId);
            return view('admin.members.memeberpredictions', compact('arrUserPredictions','arrMembers'));
        }
        return redirect()->route(ADMIN.'.dash');
    }
}
