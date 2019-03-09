<?php

namespace Applcon\Models;

/**
 * \Applcon\Models\RolesUsers
 *
 * @property int $userId
 * @property int $roleId
 *
 * @package Applcon\Models
 */
class RolesUsers extends ModelBase
{
    const TABLE_NAME = 'roles_users';
    /**
     * @var integer
     */
    protected $userId;

    /**
     * @var integer
     */
    protected $roleId;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function initialize()
    {
        $this->setTableSource(self::TABLE_NAME);
        $this->belongsTo('userId', Employee::class, 'employee_id', ['alias' => 'employee', 'reusable' => true]);
        $this->belongsTo('roleId', Roles::class, 'id', ['alias' => 'role', 'reusable' => true]);
    }

    /**
     * Independent Column Mapping.
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'users_id' => 'userId',
            'roles_id' => 'roleId',
        ];
    }
}
