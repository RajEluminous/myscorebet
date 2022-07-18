<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: Admin/ReportController.php
# Created on : JULY 2018
# Purpose: Controller for reports management at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin; //admin add
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\UserScorePrediction;
use App\Event;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Save user prediction details
        if(!empty($request->input())) {
          
            //Get TOP PREDICTORS
            $arrTopPredictions = UserScorePrediction::getAllUserScorePredictions();
            $intGetExcelData =create_excel('overall_records','All Records',$arrTopPredictions,'overall_records');
            if($intGetExcelData==1) {
                return redirect()->route(ADMIN.'.overallreports')->with('message', trans('app.records_not_found'));
           }
        }
        return view('admin.reports.index');
    }

    //Eventwise report generation
    public function eventsrpt(Request $request)
    {
        //Save user prediction details
        if(!empty($request->input())) {
            //validate form fields
            Validator::make($request->all(), [
                'events'         => 'required'
            ])->validate();

            //Get PREDICTORS ACCORDING TO EVENTS
            $arrTopPredictions = UserScorePrediction::getAllUserScorePredictions($request->events);

            //Get event name
            $objEvents = Event::where(['id' => $request->events ,'isDeleted'=> 'n'])->get()->first();
            $intGetExcelData = create_excel('eventwise_records',$objEvents->event_name, $arrTopPredictions,'eventwise_records');
           if($intGetExcelData==1) {
                return redirect()->route(ADMIN.'.eventsreports')->with('message', trans('app.records_not_found'));
           }
        }

        //GEt event list
        $arrEvents = Event::getEvents();
        return view('admin.reports.events', compact('arrEvents'));
    }

    //Monthwise report generation
    public function monthrpt(Request $request)
    {
        //Save user prediction details
        if(!empty($request->input())) {
            //validate form fields
            Validator::make($request->all(), [
                'month'        => 'required',
                'year'         => 'required'
            ])->validate();

            //Get PREDICTORS ACCORDING TO EVENTS
            $arrTopPredictions = UserScorePrediction::getAllUserScorePredictions(0,$request->month,$request->year);

           //Get event date and year
           $strMonthName = date("F", mktime(0, 0, 0, $request->month, 10)).', '.$request->year;
           $intGetExcelData  = create_excel('monthwise_records',$strMonthName, $arrTopPredictions,'monthwise_records');
           if($intGetExcelData==1) {
                return redirect()->route(ADMIN.'.monthreports')->with('message', trans('app.records_not_found'));
           }
        }

        $items = $arrYears = array();
        $items = DB::select('SELECT YEAR(user_score_prediction.created_at) as year from user_score_prediction group by year order by year DESC');

        //If years presents
        if($items) {
            foreach($items as $key => $yearVal) {
                $arrYears[$yearVal->year] = $yearVal->year;
            }
        }
        else {
            $arrYears[date('Y')] = date('Y');
        }       
        return view('admin.reports.month', compact('arrYears'));
    }
}
