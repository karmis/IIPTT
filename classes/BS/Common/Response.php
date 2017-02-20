<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 6:24
 */
namespace BS\Common;

/**
 * Class Response
 * @package BS\Common
 */
class Response
{
    const RESP_SUCCESS = 'ok';
    const RESP_ERROR = 'fail';
    private $resp = [
        'status' => self::RESP_SUCCESS,
        'data' => '',
    ];
    public function setResponse(string $status = self::RESP_SUCCESS, string $data = '')
    {
        $this->resp['status'] = $status;
        $this->resp['data'] = $data;
    }

    public function send()
    {
        header("Content-Type: application/json; charset=UTF-8");
        return $this->toJSON();
    }


    private function toJSON()
    {
        return json_encode($this->resp, ENT_NOQUOTES);
    }

}