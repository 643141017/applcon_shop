<?php

namespace Applcon\Common\Library\Events;

use Phalcon\Text;
use Phalcon\Events\Event;
use Phalcon\DispatcherInterface;
use Phalcon\Mvc\Dispatcher\Exception;
use Applcon\Models\Services\Service;
use Applcon\Common\Library\Acl\Manager;

/**
 * \Applcon\Common\Library\Events\AccessListener
 *
 * @package Applcon\Common\Library\Events
 */
class AccessListener extends AbstractEvent
{
    /**
     * This action is executed before execute any action in the application.
     *
     * @param Event               $event   Event object.
     * @param DispatcherInterface $dispatcher Dispatcher object.
     * @param array               $data    The event data.
     *
     * @return mixed
     */
    public function beforeDispatch(Event $event, DispatcherInterface $dispatcher, array $data = null)
    {
        /** @var Service\User $userService */
        $employeeService = $this->getDI()->getShared(Service\Employee::class);

        /** @var Manager $aclManager */
        $aclManager = $this->getDI()->getShared('aclManager');

        $roles = $employeeService->getRoleNamesForCurrentViewer();

        $controller = $dispatcher->getControllerName();

        // @todo Get secure resources e.g. controllers from module config
        $protectedResource = $dispatcher->getModuleName() === 'backend' || Text::startsWith($controller, 'Admin', true);

        if ($protectedResource && !$aclManager->isAllowed($roles, Manager::ADMIN_AREA, 'access')) {
            $dispatcher->forward([
                'module'     => 'oauth',
                'namespace'  => 'Applcon\Oauth\Controllers',
                'controller' => 'login',
                'action'     => 'index',
            ]);
        }

        return !$event->isStopped();
    }
}
