<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class WinnersSelection extends Model
{
    protected $table = 'winners_selection';
    protected $fillable = [
        'uid', 'rank', 'month', 'created_at'
    ];

    //Get all users prediction.
    protected function getAllPredictors($currentMonth=0) {
        $arrUserPredictions = array();
        $query = UserScorePrediction::from('user_score_prediction as usp')
            ->leftJoin('members as m','usp.uid', '=', 'm.id')
            ->leftJoin('events as e','usp.eventid', '=', 'e.id')
            ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
            ->select(DB::raw("SUM(usp.point) as totalpoints"), 'm.first_name', 'm.last_name','m.id')
            ->where([
                        ['usp.point','=',1],
                        ['usp.isValid','=','y'],
                        ['e.isDeleted','=','n'],
                        ['se.isDeleted','=','n'],
                        ['m.isActive','=','y'],
                        ['m.isDeletedByUser','=','n']
                    ]);

        //If current month data
        // if($currentMonth == 1) {
        //     $query->where('e.month',date('n'));
        // }

        $arrUserPredictions = $query->groupBy('usp.uid')
                    ->orderBy('totalpoints', 'desc')
                    ->get(); 

        return $arrUserPredictions;
    }

     //Get TOP PREDICTORS
    protected function getWinners(){
        $arrUserPredictions = array();
        $month = date("m",strtotime("-1 month"));
        $year = date("Y",strtotime("-1 month"));
        $arrUserPredictions = WinnersSelection::select('username')->whereYear('month', '=', $year)->whereMonth('month', '=', $month)->orderBy('rank', 'asc')->get();
        return $arrUserPredictions;
    }
}
