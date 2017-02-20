<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 4:02
 */

namespace BS\Common;

class DBConnect {
    private $db;

    public function connect()
    {
        $config = Config::get('db');
        try {
            $this->db = new \pdo("mysql:host=$config[host];dbname=$config[name]", $config['user'], $config['pass']);
            $this->db->query('set names utf8');
        } catch (\PDOException $e) {
            die( "Error connection: " . $e->getMessage());
        }

        return $this->db;
    }

    public function __destruct()
    {
        $this->db = null;
    }
} 