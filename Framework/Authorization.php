<?php

namespace Framework;

use Framework\Session;

class Authorization {
    //Check if current logged in user owns a resource
    public static function isOwner($resourceId){
        $sessionUser = Session::get('user');

        if ($sessionUser && isset($sessionUser['id'])){
            $id = (int) $sessionUser['id'];
            return $id === $resourceId;
        }
        return false;
    }
}