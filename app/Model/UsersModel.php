<?php

namespace Dykyi\Model;

use Dykyi\Model;

/**
 * Class UsersModel
 */
class UsersModel extends Model
{
    const TABLE_NAME = 'users';

    /**
     * Get All Users List
     *
     * @return mixed
     */
    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM ' . self::TABLE_NAME);
        return $stmt->fetchAll();
    }

}