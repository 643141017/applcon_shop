<?php

namespace Applcon\Models;

/**
 * \Applcon\Models\FailedLogins
 *
 * @package Applcon\Models
 */
class FailedLogin extends ModelBase
{
    const TABLE_NAME = 'failed_login';

    /**
     * The Entity ID.
     * @var integer
     */
    protected $id;

    /**
     * The Employee ID.
     * @var integer
     */
    protected $employee_id;

    /**
     * The Employee IP address.
     * @var integer
     */
    protected $ip_address;

    /**
     * The attempted time.
     * @var integer
     */
    protected $attempted;

    /**
     * Initialize FailedLogin model.
     */
    public function initialize()
    {
        $this->setTableSource(self::TABLE_NAME);
        $this->belongsTo('employee_id', Employee::class, 'id', ['alias' => 'employee', 'reusable' => true]);
    }

    /**
     * Method to set the value of field id.
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field employee_id.
     *
     * @param  integer $employee_id
     * @return $this
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    /**
     * Method to set the value of field ip_address.
     *
     * @param  integer $ip_address
     * @return $this
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    /**
     * Method to set the value of field attempted.
     *
     * @param  integer $attempted
     * @return $this
     */
    public function setAttempted($attempted)
    {
        $this->attempted = $attempted;

        return $this;
    }

    /**
     * Returns the value of field id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field employee_id.
     *
     * @return integer
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Returns the value of field ip_address.
     *
     * @return integer
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Returns the value of field attempted.
     *
     * @return integer
     */
    public function getAttempted()
    {
        return $this->attempted;
    }

    /**
     * Allows to query a set of records that match the specified conditions.
     *
     * @param  mixed $parameters
     * @return \Phalcon\Mvc\Model\ResultsetInterface|FailedLogins[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions.
     *
     * @param  mixed $parameters
     * @return FailedLogins
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
