<?php

/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 20.02.2017
 * Time: 1:08
 */
namespace BS\Repository;

use BS\Entity\User;

class UserRepository extends BaseRepository
{
    /**
     * Return list of users
     * @return array
     */
    public function getAll(): array
    {
        $query = "select `username`, `age`, `role` from users where 1";
        $sth = $this->db->prepare($query);
        $sth->execute();
        $resp = $sth->fetchAll(\PDO::FETCH_OBJ);

        return $resp;
    }

    /**
     * Return user by id
     * @param int $id
     * @return \stdClass
     * @throws \Exception
     */
    public function get(int $id): \stdClass
    {
        $query = "select `username`, `age`, `role` from users where id = :id limit 1";
        $sth = $this->db->prepare($query);
        $sth->execute(
            array(
                ":id" => $id,
            )
        );
        $resp = $sth->fetch(\PDO::FETCH_OBJ);

        if (!$resp) {
            $err = $sth->errorInfo();

            throw new \Exception('User not found', $err[1]);
        }

        return $resp;
    }

    /**
     * Return user by id as instance of User
     * @param int $id
     * @return User
     */
    public function getObject(int $id): User
    {
        $query = "select * from users where id = :id limit 1";
        $sth = $this->db->prepare($query);
        $sth->execute(
            array(
                ":id" => $id,
            )
        );
        $resp = $sth->fetch(\PDO::FETCH_OBJ);

        $user = new User();
        foreach ($resp as $k => $v) {
            $user->{'set' . ucfirst($k)}($v);
        }

        return $user;
    }

    /**
     * Create user by User object
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        $query = "insert into users (username, password, email, age, role, salt) values (:username, :password, :email, :age, :role, :salt)";
        $sth = $this->db->prepare($query);

        $this->db->beginTransaction();
        $resp = $sth->execute(
            array(
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':age' => $user->getAge(),
                ':password' => $user->getPassword(),
                ':salt' => $user->getSalt(),
                ':role' => $user->getRole()
            )
        );
        $this->db->commit();

        if (!$resp) {
            $err = $sth->errorInfo();

            throw new \Exception($err[2], $err[1]);
        }

        return $resp;
    }

    /**
     * Edit user by User object
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function edit(User $user)
    {
        $query = "update users set username=:username, email=:email, age=:age where id=:id";
        $sth = $this->db->prepare($query);
        $resp = $sth->execute(
            array(
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':age' => $user->getAge(),
                ':id' => $user->getId(),
            )
        );

        if (!$resp) {
            $err = $sth->errorInfo();

            throw new \Exception($err[2], $err[1]);
        }

        return $resp;
    }

    /**
     * Delete user by id
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $query = "delete from users where id = :id";
        $sth = $this->db->prepare($query);

        $resp = $sth->execute(
            array(
                ':id' => $id,
            )
        );

        if (!$resp) {
            $err = $sth->errorInfo();

            throw new \Exception($err[2], $err[1]);
        }

        return $resp;
    }

    /**
     * Search user by object of User by email and password
     * @param User $user
     * @return mixed
     */
    public function getUserForAuth(User $user)
    {
        $query = "select `username`, `age`, `role`, `email` from users where email = :email and password = :password limit 1";
        $sth = $this->db->prepare($query);
        $sth->execute(
            array(
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword()

            )
        );
        $resp = $sth->fetch(\PDO::FETCH_OBJ);

        return $resp;
    }
}