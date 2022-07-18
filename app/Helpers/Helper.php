<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    /**
      * Get user role name
      *
      * $return string
      */
    public static function getRolename($roleid)
    {
    	$allowedRoles = getUserRole();
        return $allowedRoles[$roleid];
    }

}
