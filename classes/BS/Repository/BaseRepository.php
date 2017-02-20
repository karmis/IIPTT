<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 20.02.2017
 * Time: 1:10
 */
namespace BS\Repository;

use BS\Common\DBConnect;

class BaseRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = new DBConnect();
        $this->db = $this->db->connect();
    }
}