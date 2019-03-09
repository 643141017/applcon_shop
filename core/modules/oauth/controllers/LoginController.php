<?php

namespace Applcon\Oauth\Controllers;

use Phalcon\Mvc\Model;
use Applcon\Models\Users;
use Applcon\Oauth\Forms\LoginForm;
use Phalcon\Mvc\DispatcherInterface;
use Applcon\Auth\Exception as AuthException;

/**
 * \Applcon\Oauth\Controllers\LoginController
 *
 * @package Applcon\Oauth\Controllers
 */
class LoginController extends ControllerBase
{
    /**
     * Triggered before executing the controller/action method.
     *
     * @param  DispatcherInterface $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(DispatcherInterface $dispatcher)
    {
        if ($this->auth->hasRememberMe() && !$this->request->isPost()) {
            $this->auth->loginWithRememberMe();
        }

        if ($this->auth->isAuthorizedVisitor() && !$this->request->isPost()) {
            $this->currentRedirect();
        }

        return true;
    }

    public function indexAction()
    {
        if ($this->auth->isAuthorizedVisitor()) {
            $this->view->disable();

            return $this->response->redirect('backend');
        }

        $url = $this->request->getHTTPReferer();
        if (!empty($url)) {
            $url = $this->url->get(['for' => 'login'], null, null, env('APP_URL') . '/');

            if ($this->cookies->has('HTTPBACK')) {
                $this->cookies->delete('HTTPBACK');
            }

            $this->cookies->set('HTTPBACK', serialize($url));
        }

        $form = new LoginForm;

        try {
            if ($this->request->isPost()) {
                if (!$form->isValid($this->request->getPost())) {
                    $messages = [];
                    foreach ($form->getMessages() as $message) {
                        $messages[] = $message;
                    }

                    $this->flashSession->error(implode('<br>', $messages));
                } else {
                    $this->auth->check([
                        'email'    => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => true,
                    ]);

                    $this->flashSession->success(t('Welcome back '. $this->auth->getName()));

                    return $this->currentRedirect();
                }
            }
        } catch (AuthException $e) {
            $this->response->setStatusCode(422);
            $this->flashSession->error(t($e->getMessage()));
        }

        $this->view->setVar('form', $form);
    }

    /**
     * unauthorizedAction
     *
     * @return void
     */
    public function unauthorizedAction()
    {
        $this->response->setStatusCode(401, 'Unauthorized');
        $this->view->disable();
    }

    /**
     * Method indexAction
     *
     * @return void
     */
    public function forbiddenAction($object)
    {
        $this->response->setHeader(403, 'Forbidden');
    }
    /**
     * Display notification
     */
    public function notification($object)
    {
        if ($object->getOperationMade() == Model::OP_CREATE) {
            $this->flashSession->success('Welcome ' . $object->getFullName());
        } else {
            $this->flashSession->success('Welcome back ' . $object->getFullName());
        }
    }
}
