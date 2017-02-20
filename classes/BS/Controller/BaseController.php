<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 7:36
 */

namespace BS\Controller;

//use BS\Common\Request;
use BS\Common\Config;


use BS\Entity\User;

class BaseController
{
    /**
     * Blank page for 404
     */
    public function notFoundAction(): void
    {
        exit('404');
    }

    public function accessDeniedAction(): void
    {
        exit('403');
    }


    public function verifGranted(User $targetUser)
    {
        $currentUser = $_SESSION['user'];
        if(!$currentUser){
            $this->accessDeniedAction();
        }


        // compare roles
        $roles = Config::get('roles');
        $targetRole = $targetUser->getRole();
        $currentRole = $currentUser->role;
        $targetIndex = array_search($targetRole, $roles);
        $currentIndex = array_search($currentRole, $roles);

        if($currentIndex >= $targetIndex){
            $this->accessDeniedAction();
        }
    }



} 