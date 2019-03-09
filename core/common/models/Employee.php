<?php

namespace Applcon\Models;

use Phalcon\Validation;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * \Applcon\Models\Employee
 *
 * @package Applcon\Models
 */
class Employee extends ModelBase
{
    const TABLE_NAME = 'employee';

    const STATUS_ACTIVE   = 1;
    const STATUS_DISABLED = 2;
    const STATUS_PENDING  = 3;
    const STATUS_INACTIVE = 4;

    /**
     *
     * @var integer
     */
    protected $employee_id;

    /**
     *
     * @var integer
     */
    protected $lang_id;

    /**
     *
     * @var string
     */
    protected $lastname;

    /**
     *
     * @var string
     */
    protected $firstname;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     *
     * @var integer
     */
    protected $last_login_time;


    public function initialize()
    {
        parent::initialize();
        $this->setTableSource(self::TABLE_NAME);

        $this->hasManyToMany(
            'employee_id',
            RolesUsers::class,
            'userId',
            'roleId',
            Roles::class,
            'id',
            ['alias' => 'roles']
        );

        $this->hasMany('id', RolesUsers::class, 'userId', ['alias' => 'rolesUsers', 'reusable' => true]);
    }

    /**
     * Method to set the value of field employee_id
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
     * Method to set the value of field lang_id
     *
     * @param  integer $lang_id
     * @return $this
     */
    public function setLangId($lang_id)
    {
        $this->lang_id = $lang_id;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param  string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field firstname
     *
     * @param  string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Method to set the value of field lastname
     *
     * @param  string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param  int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Method to set the value of field status
     *
     * @param  int $status
     * @return $this
     */
    public function setLastLoginTime($last_login_time)
    {
        $this->last_login_time = $last_login_time;

        return $this;
    }


    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Returns the value of field lang_id
     *
     * @return integer
     */
    public function getLangId()
    {
        return $this->lang_id;
    }


    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field last_login_time
     *
     * @return integer
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time;
    }

    /**
     * Get information full name
     *
     * @return string
     */
    public function getFullName()
    {
        if ($this->firstname && $this->lastname) {
            return $this->firstname . " " . $this->lastname;
        } elseif ($this->firstname) {
            return $this->firstname;
        }
        return $this->email;
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new PresenceOf([
                'model' => $this,
                'message' => t('Please enter a correct email address'),
                'cancelOnFail' => true
            ])
        );

        $validator->add(
            'email',
            new Email([
                'model' => $this,
                'message' => t('Please enter a correct email address'),
                'cancelOnFail' => true
            ])
        );

        $validator->add(
            'email',
            new Uniqueness([
                'model' => $this,
                'message' => t('Another user with same email already exists'),
                'cancelOnFail' => true
            ])
        );
        return $this->validate($validator);
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'employee_id'     => 'employee_id',
            'lang_id'         => 'lang_id',
            'lastname'        => 'lastname',
            'firstname'       => 'firstname',
            'email'           => 'email',
            'password'        => 'password',
            'status'          => 'status',
            'last_login_time' => 'last_login_time',
        );
    }
}
