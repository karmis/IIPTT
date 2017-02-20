<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 19.02.2017
 * Time: 23:25
 */

namespace BS\Controller;
use BS\Common\Response;
use BS\Entity\User;
use BS\Repository\UserRepository;

class AuthController extends BaseController
{
    /**
     * Auth user
     * @param array $params
     */
    public function authAction(array $params) {
        $resp = new Response();
        $data = $params['body'];
        $user = new User();
        $user->setEmail($data->email);
        $user->createPasssword($data->password);

        $rep = new UserRepository();
        $user = $rep->getUserForAuth($user);

        if($user){
            $_SESSION['user'] = $user;
            $resp->setResponse(Response::RESP_SUCCESS, json_encode($user));
        } else {
            $resp->setResponse(Response::RESP_ERROR, 'User not found');
        }

        return $resp->send();
    }
}