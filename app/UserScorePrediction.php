<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class UserScorePrediction extends Model
{
    protected $table = 'user_score_prediction';
    protected $fillable = [
        'uid', 'eventid', 'subeventid', 'pred_score_team1', 'pred_score_team2', 'comment', 'point','isValid', 'created_at', 'updated_at' 
    ];

    //Get all user prediction score according to the admin score.
    protected function getAllUsersPredictions($eventId,$subeventId,$adminTeamScore1,$adminTeamScore2){
        $arrUserPredictions = array();
        
        $arrUserPredictions = UserScorePrediction::from('user_score_prediction as usp')
                ->leftJoin('members as m','usp.uid', '=', 'm.id')
                ->leftJoin('events as e','usp.eventid', '=', 'e.id')
                ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
                ->select('usp.uid','m.email','usp.id')
                ->where([
                            ['usp.pred_score_team1','=',$adminTeamScore1],
                            ['usp.pred_score_team2','=',$adminTeamScore2],
                            ['usp.eventid','=',$eventId],
                            ['usp.subeventid','=',$subeventId],
                            ['usp.isValid','=','n'],
                            ['e.isDeleted','=','n'],
                            ['se.isDeleted','=','n'],
                            ['m.isActive','=','y'],
                            ['m.isDeletedByUser','=','n']
                        ])
                        ->orderBy('usp.uid', 'asc')
                        ->get();

        return $arrUserPredictions;
    }

    //Get TOP PREDICTORS
    protected function getUserScorePredictions($currentMonth=0){
        $arrUserPredictions = array();
        $query = UserScorePrediction::from('user_score_prediction as usp')
            ->leftJoin('members as m','usp.uid', '=', 'm.id')
            ->leftJoin('events as e','usp.eventid', '=', 'e.id')
            ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
            ->select(DB::raw("SUM(usp.point) as totalpoints"), 'm.first_name', 'm.last_name')
            ->where([
                        ['usp.point','=',1],
                        ['usp.isValid','=','y'],
                        ['e.isDeleted','=','n'],
                        ['se.isDeleted','=','n'],
                        ['m.isActive','=','y'],
                        ['m.isDeletedByUser','=','n']
                    ]);

        //If current month data
        if($currentMonth == 1) {
            $query->where('e.month',date('n'));
        }

        $arrUserPredictions = $query->groupBy('usp.uid')
                    ->orderBy('totalpoints', 'desc')
                    ->offset(0)->limit(5)
                    ->get(); 

        return $arrUserPredictions;
    }

    //Get All USER PREDICTORS
    protected function getAllUserScorePredictions($eventid=0,$month=0,$year=0){
        $arrUserPredictions = array();
        $query = UserScorePrediction::from('user_score_prediction as usp')
            ->leftJoin('members as m','usp.uid', '=', 'm.id')
            ->leftJoin('events as e','usp.eventid', '=', 'e.id')
            ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
            ->select(DB::raw("SUM(usp.point) as totalpoints"), 'm.first_name', 'm.last_name', 'm.email', 'm.created_at')
            ->where([
                        ['usp.point','=',1],
                        ['usp.isValid','=','y'],
                        ['e.isDeleted','=','n'],
                        ['se.isDeleted','=','n']
                    ]);

        //If event id set
        if($eventid!=0) {
            $query->where('usp.eventid',$eventid);
        }   

        //If month set
        if($month!=0) {
            $query->whereYear('se.expiry_datetime', '=', $year)->whereMonth('se.expiry_datetime', '=', $month);
        }   

        $arrUserPredictions = $query->groupBy('usp.uid')
                    ->orderBy('totalpoints', 'desc')
                    ->get(); 

        return $arrUserPredictions;
    }

    //Get User Prediction according to the user
    protected function userPredictions($userid){
        $arrUserPredictions = array();
        $arrUserPredictions = UserScorePrediction::from('user_score_prediction as usp')
            ->leftJoin('members as m','usp.uid', '=', 'm.id')
            ->leftJoin('events as e','usp.eventid', '=', 'e.id')
            ->leftJoin('subevents as se','usp.subeventid', '=', 'se.id')
            ->select('e.event_name', 'se.name_team1', 'se.logo_team1', 'se.logo_team2', 'se.name_team2', 'se.score_team1','se.score_team2','usp.point','usp.pred_score_team1','usp.pred_score_team2','se.expiry_datetime','se.eventid','se.id', 'usp.id as user_prediction_id')
            ->where([
                        ['e.isDeleted','=','n'],
                        ['se.isDeleted','=','n'],
                        ['usp.uid','=',$userid]
                    ])
                    ->orderBy('se.expiry_datetime', 'desc')
                    ->get()->toArray(); 
        return $arrUserPredictions;
    }

    // select top 5 members to send winning email
    protected function getWiiningTopMembers($userid){
        //Get all memebers
        $arrMembers = array();
        $arrMembers = UserScorePrediction::from('user_score_prediction as usp')
                ->leftJoin('members as m','usp.uid', '=', 'm.id')
                ->select('usp.uid','m.email','m.first_name','m.last_name','usp.id', 'usp.eventid', 'usp.subeventid','usp.pred_score_team1', 'usp.pred_score_team2')
                ->where([
                            ['usp.uid','=',$userid],
                            ['usp.isValid','=','y'],
                            ['usp.isEmailSend','=','n'],
                            ['m.isActive','=','y'],
                            ['m.isDeletedByUser','=','n']
                        ])
                ->orderBy('usp.uid', 'asc')
                ->get()->first();
        return $arrMembers;
    }    
}
