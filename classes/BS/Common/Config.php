<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 4:51
 */

namespace BS\Common;

class Config
{
    /**
     * @var array
     */
    private static $data = array(
        'db' => [
            'host' => 'localhost',
            'name' => 'tt_user_api',
            'user' => 'root',
            'pass' => ''
        ],
        'routes' => [
            // method::free|guarded::path => namespace of class::method
            'post::free|guarded::api\/auth(\/?)+$' => '\\BS\Controller\AuthController::auth',
            'get::free|guarded::hierarchy(\/?)+$' => '\\BS\Controller\HierarchyController::build',
            'get::guarded::api\/users(\/?)+$' => '\\BS\Controller\UserController::index',
            'get::guarded::api\/users\/\d+(\/?)+$' => '\\BS\Controller\UserController::show',
            'post::guarded::api\/users\/create(\/?)+$' => '\\BS\Controller\UserController::create',
            'post::guarded::api\/users\/\d+\/edit(\/?)+$' => '\\BS\Controller\UserController::edit',
            'post::guarded::api\/users\/\d+\/delete(\/?)+$' => '\\BS\Controller\UserController::delete',
            '__404__' => '\\BS\Controller\BaseController::notFound',
        ],
        'roles' => [
            'SUPER_ADMIN',
            'ADMIN',
            'USER',
            'ANON'
        ],
        'methodsPostfix' => 'Action'
    );

    /**
     * Add value to register
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    /**
     * Return value from register
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        return isset(self::$data[$key]) ? self::$data[$key] : null;
    }
} 