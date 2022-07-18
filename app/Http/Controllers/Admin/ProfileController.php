<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/ProfileController.php
# Created on : JULY 2018
# Purpose: Controller for profile management of an admin
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $item = User::findOrFail($id);
        return view('admin.profile', compact('item'));
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
        //Log::info('user: '. print_r( $request->all() )   );
        $this->validate($request, User::rules(true,$id));
        $item = User::findOrFail($id);
        $item->update($request->all());

        //update the auth, will needed for refresh UI
        \Auth::user()->update(['name' => $request->name]);
        \Auth::user()->update(['email' => $request->email]);

        return back()->withSuccess(trans('app.success_update'));
    }
}