<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subevent extends Model
{
	protected $table = 'subevents';
    protected $fillable = [
        'eventid', 'description', 'name_team1', 'name_team2', 'logo_team1', 'logo_team2', 'score_team1', 'score_team2', 'winningteam' , 'expiry_datetime', 'isActive'
    ];

    /*
    * Define relationship between event and subevent
    */
    public function event()
    {
    	return $this->belongsTo(Event::class, 'eventid');
    }

    //Get event details
    protected function getSubEventData($intSubmittedSubevent) 
    {
       $arrData = array();
       $arrData = Subevent::select('name_team1', 'name_team2', 'score_team1', 'score_team2')
                    ->where([
                            ['isActive','=','y'],
                            ['isDeleted','=','n'],  
                            ['id','=',$intSubmittedSubevent]      
                      ])->first();
        return $arrData;
    }
}
