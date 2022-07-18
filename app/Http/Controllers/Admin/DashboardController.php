<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/DashboardController.php
# Created on : JULY 2018
# Purpose: Controller for Dashboard data management
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Event;
use App\Member;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intEventCnt = Event::where(['isDeleted' => 'n', 'isActive' => 'y'])->get()->count();
        $intRegisteredMembers = Member::where('isActive', 'y')->where('isDeletedByUser', 'n')->get()->count();
        return view('admin.dashboard', compact('intEventCnt','intRegisteredMembers'));
    }
}
