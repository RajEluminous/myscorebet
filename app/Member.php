<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name','last_name', 'email','password','isActive','isEmailVerified', 'reset_token','isDeletedByUser' 
    ];

    //Get member details which are active
    protected function getMemberDetails($memberId){
    	$arrData = array();
		$arrData = Member::select('id','first_name','last_name', 'email', 'created_at')
					->where([
							['isActive','=','y'], 
							['id','=',trim($memberId)]		
					  ])->first();
		return $arrData;
    }

    //Delete member account
    protected function deleteMember($memberId){
        //Get member details
        $objMember = Member::findOrFail($memberId);
        $objMember->update([
            'first_name'        => "Deleted",
            'last_name'         => "User",
            'email'             => "deleteduser".$memberId."@myscorebet.com",
            'password'          => '',
            'isDeletedByUser'   => 'y',
            'updated_at'        => date('Y-m-d H:i:s'),    
        ]);
        return true;  
    }
}
