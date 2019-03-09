<?php

namespace Applcon\Models\Services\Service;

use Phalcon\Db\Column;
use Applcon\Models\FailedLogin as FailedLoginEntity;
use Applcon\Models\Services\Service;
use Applcon\Models\Services\Exceptions\EntityException;

/**
 * \Applcon\Models\Services\Service\FailedLogin
 *
 * @package Applcon\Models\Services\Service
 */
class FailedLogin extends Service
{
    /**
     * Create new FailedLoginEntity with desired attributes.
     *
     * @param array $attributes
     *
     * @return FailedLoginEntity
     * @throws EntityException
     */
    public function createOrFail(array $attributes)
    {
        $entity = new FailedLoginEntity($attributes);
        if (!$entity->save()) {
            throw new EntityException($entity, 'FailedLoginEntity could not be saved.');
        }

        return $entity;
    }

    /**
     * Count attempts of failed logins.
     *
     * @param string $ipAddress
     * @param int    $fromAttemptedTime
     *
     * @return int
     */
    public function countAttempts($ipAddress, $fromAttemptedTime)
    {
        return (int) FailedLoginEntity::count([
            'condition' => 'ipAddress = :address: AND attempted >= :attempted:',
            'bind' => [
                'address'   => $ipAddress,
                'attempted' => $fromAttemptedTime,
            ],
            'bindTypes' => [
                'address'   => Column::BIND_PARAM_INT,
                'attempted' => Column::BIND_PARAM_INT,
            ],
        ]);
    }
}
