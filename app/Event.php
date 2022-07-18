<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_name', 'description', 'month', 'event_date','event_time', 'isActive' 
    ];
    
    /*
    * Define relationship between event and subevent
    */
    public function subevent()
    {
    	return $this->hasMany(Subevent::class,'eventid');
    }

    //Get event details
    protected function getEventData($eventId) 
    {
        $arrData = array();
        $arrData = Event::select('event_name')
                    ->where([
                            ['isActive','=','y'],
                            ['isDeleted','=','n'],  
                            ['id','=',trim($eventId)]      
                      ])->first();
        return $arrData;
    }
    
    //Get all events
    protected function getAllEvents() 
    {
        $arrData = array();

        $arrData =  DB::table('events')
            ->join('subevents', 'events.id', '=', 'subevents.eventid')
            ->select('events.event_name', 'events.id', DB::raw("count(subevents.eventid) as count"))
            ->where([
                        ['events.isActive','=','y'],
                        ['events.isDeleted','=','n'],
                        ['subevents.isActive','=','y'],
                        ['subevents.isDeleted','=','n']       
                    ])
            ->where('events.month','>=',date('n'))
            ->where('subevents.expiry_datetime','>=',date('Y-m-d H:i:s'))
            ->orderBy('events.month','ASC')
			->orderBy('events.id','ASC')
            ->groupBy('events.id')
            ->offset(0)->limit(3)
            ->get();
			

        return $arrData;
    }

    //Get all events which are active
    protected function getEvents() 
    {
        $arrEvents = array();
        $arrEvents = Event::select('id','event_name')
                ->where([
                        ['isActive','=','y'],
                        ['isDeleted','=','n']       
                    ])
                ->orderBy('month', 'asc')->get();
        $items = array();
        if($arrEvents) {
            foreach ($arrEvents as $data) {
                $items[$data->id] = $data->event_name;
            }
        }
        return $items;
    }
}
