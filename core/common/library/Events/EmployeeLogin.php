<?php

namespace Applcon\Common\Library\Events;

use Phalcon\Events\Event;
use Applcon\Models\Services\Service;
use Applcon\Models\Services\Exceptions\EntityException;

/**
 * \Applcon\Common\Library\Events\EmployeeLogin
 *
 * @package Applcon\Common\Library\Events
 */
class EmployeeLogin extends AbstractEvent
{
    const FROM_TIME_FETCH = 21600;

    /**
     * @param Event  $event
     * @param object $source
     * @param array  $data
     *
     * @return bool
     */
    public function failedLogin(Event $event, $source, array $data)
    {
        $failedLoginService = $this->getDI()->getShared(Service\FailedLogin::class);

        $address = ip2long($data['ipAddress']);
        $employeeId  = empty($data['employeeId']) ? null : $data['employeeId'];
        $time    = time();

        try {
            $failedLoginService->createOrFail([
                'employee_id' => $employeeId,
                'ip_address' => $address,
                'attempted' => $time,
            ]);
        } catch (EntityException $e) {
            $this->logger->error($event->getType() . ': ' . $e->getMessage());
        }

        $attempts = $failedLoginService->countAttempts($address, $time - self::FROM_TIME_FETCH);
        $this->throttling($attempts);

        return false;
    }

    /**
     * Register the successful login.
     *
     * @param Event  $event
     * @param object $source
     * @param array  $data
     *
     * @return bool
     */
    public function successLogin(Event $event, $source, array $data)
    {
        $successLoginService = $this->getDI()->getShared(Service\SuccessLogin::class);

        $address = ip2long($data['ipAddress']);
        $userAgent = empty($data['userAgent']) ? 'Unknown' : $data['userAgent'];

        try {
            $successLoginService->createOrFail([
                'employee_id'   => $data['employeeId'],
                'ip_address' => $address,
                'user_agent' => $userAgent,
            ]);
        } catch (EntityException $e) {
            $this->logger->error($event->getType() . ': ' . $e->getMessage());
        }

        return true;
    }

    /**
     * Implements login throttling.
     *
     * Reduces the effectiveness of brute force attacks
     *
     * @param int $attempts Failed login attempts
     */
    protected function throttling($attempts)
    {
        switch ($attempts) {
            case 1:
            case 2:
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }
}
