<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/WinnersController.php
# Created on : JULY 2018
# Purpose: Controller for winners management at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\WinnersSelection;
use DB;
use Validator;

class WinnersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function saveLastMonthWinners(Request $request)
    {
        //If date not empty
        $month = date("m",strtotime("-1 month"));
        $year = date("Y",strtotime("-1 month"));
        $lastmonthdate = date("Y-m-d H:i:s",strtotime("-1 month"));
        
        if(!empty($request->input())) {
           //Delete existing data if present
           WinnersSelection::whereYear('month', '=', $year)->whereMonth('month', '=', $month)->delete();
           //add updated restaurant working hours
           WinnersSelection::insert([
                [
                    'username'       => ucwords(addslashes($request->winner1)),
                    'rank'           => 1,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner2)),
                    'rank'           => 2,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner3)),
                    'rank'           => 3,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner4)),
                    'rank'           => 4,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner5)),
                    'rank'           => 5,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner6)),
                    'rank'           => 6,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner7)),
                    'rank'           => 7,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner8)),
                    'rank'           => 8,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner9)),
                    'rank'           => 9,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ],
                [
                    'username'       => ucwords(addslashes($request->winner10)),
                    'rank'           => 10,     
                    'month'          => $lastmonthdate,              
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]
            ]);

            return redirect()->route(ADMIN.'.winnersselection')->withSuccess(trans('app.winning_member'));
        }

        //Get winner data
        $arrWinners = array();
        $arrWinners = WinnersSelection::whereYear('month', '=', $year)->whereMonth('month', '=', $month)->orderBy('rank', 'asc')->get();
        return view('admin.winnerselection.create', compact('arrWinners'));
    }    
}
