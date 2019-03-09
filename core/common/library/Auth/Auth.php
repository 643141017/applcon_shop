<?php

namespace Applcon\Common\Library\Auth;

use Applcon\Models\Employee as EmployeeEntity;
use Phalcon\Mvc\User\Component;
use Applcon\Models\RememberTokens;
use Applcon\Models\Services\Service;
use Applcon\Models\Services\Exceptions\EntityNotFoundException;

/**
 * \Applcon\Auth\Auth
 *
 * Manages Authentication/Identity Management in Applcon
 *
 * @property \Phalcon\Config $config
 * @package Applcon\Auth
 */
class Auth extends Component
{
    /**
     * @var Service\Employee
     */
    protected $employeeService;

    /**
     * @var int
     */
    protected $cookieLifetime;

    /**
     * Auth constructor.
     *
     * @param null $cookieLifetime
     */
    public function __construct($cookieLifetime = null)
    {

        $this->employeeService = $this->di->getShared(Service\Employee::class);

        if ($cookieLifetime === null) {
            $cookieLifetime = $this->config->get('application')->cookieLifetime;
        }

        $this->cookieLifetime = $cookieLifetime;
    }

    /**
     * Performs an authentication attempt.
     *
     * @param  array $credentials
     * @throws Exception
     */
    public function check(array $credentials)
    {
        $clientIp  = $this->request->getClientAddress(true);
        $userAgent = $this->request->getUserAgent();

        try {
            // Check if the employee exist
            $employee = $this->employeeService->findFirstByEmail($credentials['email']);
            $employeeData = [
                'employeeId' => $employee->getEmployeeId(),
                'userAgent'  => $userAgent,
                'ipAddress'  => $clientIp,
            ];

            // Check the password
            if (!$this->security->checkHash($credentials['password'], $employee->getPassword())) {
                $this->getEventsManager()->fire('employee:failedLogin', $this, $employeeData);
                throw new Exception('Wrong email/password combination');
            }
            
            // Check if the employee was flagged
            if (!$this->employeeService->isActiveEmployee($employee)) {
                throw new Exception('The employee is inactive');
            }

            $this->getEventsManager()->fire('employee:successLogin', $this, $employeeData);

            // Check if the remember me was selected
            if (isset($credentials['remember'])) {
                $this->setRememberEnvironment($employee);
            }

            $this->setSession($employee);
        } catch (EntityNotFoundException $e) {
            $this->getEventsManager()->fire('employee:failedLogin', $this, ['ipAddress' => $clientIp]);
            throw new Exception('Wrong email/password combination');
        }
    }

    /**
     * Creates the remember me environment settings the related cookies
     * and generating tokens there is only remember token
     *
     * @param \Applcon\Models\EmployeeEntity $employee
     */
    public function setRememberEnvironment(EmployeeEntity $employee)
    {
        // $userAgent = $this->request->getUserAgent();
        // $token = md5($user->getEmail() . $user->getPasswd() . $userAgent);

        // $remember = new RememberTokens();
        // $remember->setUsersId($user->getId());
        // $remember->setToken($token);
        // $remember->setUserAgent($userAgent);

        // if ($remember->save()) {
        //     $expire = time() + $this->cookieLifetime;
        //     $this->cookies->set('RMU', $user->getId(), $expire);
        //     $this->cookies->set('RMT', $token, $expire);
        // }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        // return $this->cookies->has('RMU');
    }

    /**
     * Check if the session has a remember token
     *
     * @return boolean
     */
    public function hasRememberToken()
    {
        // return $this->cookies->has('RMT');
    }

    /**
     * Logs on using the information in the cookies, it will call in beforeExecuteRoute
     */
    public function loginWithRememberMe()
    {
        // if (!$this->hasRememberMe() || !$this->hasRememberToken() || $this->isAuthorizedVisitor()) {
        //     // Do nothing
        //     return;
        // }

        // $cToken = $this->cookies->get('RMT')->getValue();
        // $userId = $this->cookies->get('RMU')->getValue();

        // try {
        //     $user = $this->employeeService->getFirstById($userId);

        //     // Check if the user was flagged
        //     if (!$this->employeeService->isActiveMember($user)) {
        //         $this->remove();

        //         return;
        //     }
        // } catch (EntityNotFoundException $e) {
        //     $this->remove();

        //     return;
        // }

        // $userAgent = $this->request->getUserAgent();
        // $uToken    = md5($user->getEmail() . $user->getPasswd() . $userAgent);
        // $userData  = [
        //     'usersId'   => $user->getId(),
        //     'userAgent' => $userAgent,
        //     'ipAddress' => $this->request->getClientAddress(true),
        // ];

        // if (strcmp($cToken, $uToken) === 0) {
        //     $remember = RememberTokens::findFirst([
        //         'usersId = ?0 AND token = ?1',
        //         'bind' => [$user->getId(), $uToken],
        //         'order' => 'createdAt DESC' // it mean only remember token
        //     ]);

        //     if ($remember) {
        //         // Check if the cookie has not expired
        //         if ((time() - $this->cookieLifetime) < $remember->getCreatedAt()) {
        //             // Register identity
        //             $this->setSession($user);
        //             $this->getEventsManager()->fire('user:successLogin', $this, $userData);

        //             return;
        //         }
        //     }
        // }

        // $this->cookies->get('RMU')->delete();
        // $this->cookies->get('RMT')->delete();
    }

    /**
     * Returns the current identity
     *
     * @return array|null
     */
    public function getAuth()
    {
        return $this->session->get('auth');
    }

    /**
     * Returns the current identity
     *
     * @return string|null
     */
    public function getName()
    {
        if (!$this->isAuthorizedVisitor()) {
            return null;
        }

        $identity = $this->session->get('auth');

        return $identity['name'];
    }
    /**
     * Returns the current identity
     *
     * @return string|null
     */
    public function getFullName()
    {
        if (!$this->isAuthorizedVisitor()) {
            return null;
        }

        $identity = $this->session->get('auth');

        return $identity['fullname'];
    }    

    /**
     * Returns the current Employee id
     *
     * @return int|null
     */
    public function getId()
    {
        if (!$this->isAuthorizedVisitor()) {
            return null;
        }

        $identity = $this->session->get('auth');

        return (int) $identity['id'];
    }


    /**
     * Gets current employee's email if any.
     *
     * @return string|null
     */
    public function getEmail()
    {
        if (!$this->isAuthorizedVisitor()) {
            return null;
        }

        $identity = $this->session->get('auth');

        return $identity['email'];
    }

    /**
     * Checking employee is have permission admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if (!$this->isAuthorizedVisitor()) {
            return false;
        }
        return $this->employeeService->isAdmin();
    }


    /**
     * Check whether the employee is authorized.
     *
     * @return bool
     */
    public function isAuthorizedVisitor()
    {

        return $this->session->has('auth');
    }

    /**
     * Removes the employee identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }

        if ($this->cookies->has('RMT')) {
            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth');
    }

    /**
     * Save employee session.
     *
     * @param \Applcon\Models\Employee $object
     */
    public function setSession($object)
    {
        $this->session->set(
            'auth',
            [
                'id'        => $object->getEmployeeId(),
                'name'      => $object->getFullName(),
                'fullname'  => $object->getFullName(),
                'email'     => $object->getEmail(),
            ]
        );
    }
}
