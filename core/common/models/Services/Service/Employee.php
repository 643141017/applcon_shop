<?php

namespace Applcon\Models\Services\Service;

use DateTime;
use DateTimeZone;
use Applcon\Models\Employee as EmployeeEntity;
use Applcon\Models\Services\Service;
use Applcon\Models\Services\Exceptions;

/**
 * \Applcon\Models\Services\Service\Employee
 *
 * @package Applcon\Models\Services\Service
 */
class Employee extends Service
{

    /**
     * @var Employee
     */
    protected $viewer;

    /**
     * Finds Employee by ID.
     *
     * @param  int $id The Employee ID.
     * @return Employee|null
     */
    public function findFirstByEmployeeId($id)
    {
        return EmployeeEntity::findFirstByEmployeeId($id) ?: null;
    }

    /**
     * Finds Employee by email.
     *
     * @param  string $email.
     * @return Employee|null
     */
    public function findFirstByEmail($email)
    {
        $employee = EmployeeEntity::query()
            ->where('email = :email:', ['email' => $email])
            ->limit(1)
            ->execute();

        return $employee->valid() ? $employee->getFirst() : null;
    }

    /**
     * Checks whether the Employee is active.
     *
     * @param  EmployeeEntity $employee
     * @return bool
     */
    public function isActiveEmployee(EmployeeEntity $employee)
    {
        return $employee->getStatus() == EmployeeEntity::STATUS_ACTIVE;
    }

    /**
     * create current viewer.
     *
     * @return Employee
     */
    protected function createDefaultViewer()
    {
        $entity = new EmployeeEntity(['employee_id' => 0]);

        return $entity;
    }

    /**
     * Gets current viewer.
     *
     * @return Employee
     */
    public function getCurrentViewer()
    {
        if ($this->viewer) {
            return $this->viewer;
        }

        $entity = null;
        if ($this->auth->isAuthorizedVisitor()) {
            $entity = $this->findFirstByEmployeeId($this->auth->getId());
        }

        if (!$entity) {
            $entity = $this->createDefaultViewer();
        }

        $this->viewer = $entity;

        return $entity;
    }

    /**
     * Sets current viewer.
     *
     * @param Employee $entity
     */
    public function setCurrentViewer(EmployeeEntity $entity)
    {
        $this->viewer = $entity;
    }

    /**
     * Gets role names for current viewer.
     *
     * @return string[]
     */
    public function getRoleNamesForCurrentViewer()
    {
        $entity = $this->getCurrentViewer();
        if ($entity->getEmployeeId() == 0) {
            return [Role::ANONYMOUS_SYSTEM_ROLE];
        }
        return array_column($entity->getRoles(['columns' => ['name']])->toArray(), 'name');
    }

    /**
     * Checks whether the User is Admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return in_array(Role::ADMINS_SYSTEM_ROLE, $this->getRoleNamesForCurrentViewer());
    }
}
