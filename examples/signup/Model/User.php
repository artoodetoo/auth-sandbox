<?php

namespace Examples\Signup\Model;

use Examples\Signup\Base;

class User extends Base
{
    public function create($email, $password, $first_name, $last_name)
    {
        $sql = <<<SQL
INSERT INTO `:p_users`
  (`email`, `password`, `first_name`, `last_name`, `created_at`) VALUES 
( :email, :password, :first_name, :last_name, NOW() )
SQL;

        return self::$db
            ->query($sql, compact('email', 'password', 'first_name', 'last_name'))
            ->insertId();
    }

    public function update($user_id, $email, $password, $first_name, $last_name)
    {
        $sql = <<<SQL
UPDATE `:p_users`
SET `email` = :email, `password` = :password, `first_name` = :first_name, `last_name` = :last_name
WHERE id = :user_id
LIMIT 1
SQL;

        return self::$db->query($sql, compact('email', 'password', 'first_name', 'last_name', 'user_id'));
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM `:p_users` WHERE `id` = :id LIMIT 1";

        return self::$db->query($sql, compact('id'))->fetchAssoc();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM `:p_users` WHERE `email` = :email LIMIT 1";

        return self::$db->query($sql, compact('email'))->fetchAssoc();
    }

    public function findByEmailAndPassword($email, $password)
    {
        $sql = "SELECT * FROM `:p_users` WHERE `email` = '$email' AND `password` = '$password' LIMIT 1";

        return self::$db->query($sql, compact('email', 'password'))->fetchAssoc();
    }
}
