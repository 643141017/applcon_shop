<?php

namespace Applcon\Models\Services\Service;

use Applcon\Models\SuccessLogin as SuccessLoginEntity;;
use Applcon\Models\Services\Service;
use Applcon\Models\Services\Exceptions\EntityException;

/**
 * \Applcon\Models\Services\Service\SuccessLogin
 *
 * @package Applcon\Models\Services\Service
 */
class SuccessLogin extends Service
{
    /**
     * Create new SuccessLoginEntity with desired attributes.
     *
     * @param array $attributes
     *
     * @return SuccessLoginEntity
     * @throws EntityException
     */
    public function createOrFail(array $attributes)
    {
        $entity = new SuccessLoginEntity($attributes);
        if (!$entity->save()) {
            throw new EntityException($entity, 'SuccessLogin could not be saved.');
        }

        return $entity;
    }
}
