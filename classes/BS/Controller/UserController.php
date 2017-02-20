<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 5:55
 */
namespace BS\Controller;

use BS\Common\Response;
use BS\Entity\User;
use BS\Repository\UserRepository;

/**
 * Class UserController
 * @package BS\Controller
 */
class UserController extends BaseController
{
    /**
     * List of users
     * @return string
     */
    public function indexAction()
    {
        $resp = new Response();
        $rep = new UserRepository();
        try {
            $users = $rep->getAll();
            $resp->setResponse(Response::RESP_SUCCESS, json_encode($users));
        } catch (\Exception $e) {
            $resp->setResponse(Response::RESP_ERROR, $e->getMessage());
        } finally {
            return $resp->send();
        }
    }

    /**
     * User item
     * @param $params
     * @return string
     */
    public function showAction($params)
    {
        $resp = new Response();
        $userId = $params['route']['paths'][3];
        $rep = new UserRepository();
        try {
            $user = $rep->get($userId);
            $resp->setResponse(Response::RESP_SUCCESS, json_encode($user));
        } catch (\Exception $e) {
            $resp->setResponse(Response::RESP_ERROR, $e->getMessage());
        } finally {
            return $resp->send();
        }
    }

    /**
     * Create user
     * @param $params
     * @return string
     */
    public function createAction($params)
    {
        $resp = new Response();
        $data = $params['body'];
        $user = new User();
        $user->setEmail($data->email);
        $user->setAge($data->age);
        $user->setUsername($data->username);
        $user->setRole($data->role);
        $password = $user->generatePassword(); // auto-generated
        $user->createPasssword($password); // hash password and create salt

        $rep = new UserRepository();
        try {
            $this->verifGranted($user); // compare roles between current user and target user
            $rep->create($user);
            // TODO Don't return pass here !!!111;
            $resp->setResponse(Response::RESP_SUCCESS, $password);
        } catch (\Exception $e) {
            $resp->setResponse(Response::RESP_ERROR, $e->getMessage());
        } finally {
            return $resp->send();
        }
    }

    /**
     * Edit user
     * @param $params
     * @return string
     */
    public function editAction($params)
    {
        $resp = new Response();
        $data = $params['body'];
        $userId = $params['route']['paths'][3];
        $rep = new UserRepository();
        try {
            $user = $rep->getObject($userId);
            $user->setEmail($data->email);
            $user->setAge($data->age);
            $user->setUsername($data->username);
            $this->verifGranted($user); // compare roles between current user and target user
            $rep->edit($user);
        } catch (\Exception $e) {
            $resp->setResponse(Response::RESP_ERROR, $e->getMessage());
        }

        return $resp->send();
    }

    /**
     * Delete user
     * @param $params
     * @return string
     */
    public function deleteAction($params)
    {
        $resp = new Response();
        $userId = $params['route']['paths'][3];
        $rep = new UserRepository();
        try {
            $user = $rep->getObject($userId);
            $this->verifGranted($user); // compare roles between current user and target user
            $rep->delete($user->getId());
        } catch (\Exception $e) {
            $resp->setResponse(Response::RESP_ERROR, $e->getMessage());
        }

        return $resp->send();
    }
}