<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 20.02.2017
 * Time: 7:48
 */

namespace BS\Repository;


class HierarchyRepository extends BaseRepository
{
    /**
     * Return list of nodes
     * @return array
     */
    public function getTree(): array
    {
        $query = "select * from tree where 1";
        $sth = $this->db->prepare($query);
        $sth->execute();
        $resp = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $resp;
    }
}