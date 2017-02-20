<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 6:57
 */

namespace BS\Common;


class Request
{
    private $server;

    public function __construct()
    {
        $this->server = $_SERVER;
    }

    /**
     * Return $_SERVRER array
     * @return mixed
     */
    public function getServerParams(): array
    {
        return $this->server;
    }

    /**
     * Return body of request
     * @return \stdClass|null
     */
    public function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'));
    }

    /**
     * Return method name
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * Get base path
     * @return string
     */
    public function getBasePath(): string
    {
        return implode('/', array_slice(explode('/', $this->server['SCRIPT_NAME']), 0, -1)) . '/';
    }

} 