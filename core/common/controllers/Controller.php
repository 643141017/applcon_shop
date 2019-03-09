<?php

namespace Applcon\Controllers;

use Phalcon\Mvc\Dispatcher;

/**
 * \Applcon\Controllers\Controller
 *
 * @property \Applcon\Auth\Auth $auth
 * @property \Phalcon\Logger\Adapter\File $logger
 * @property \Applcon\Common\Library\Acl\Manager $aclManager
 *
 * @package Applcon\Controllers
 */
class Controller extends AbstractController
{

    /**
     * @var bool
     */
    protected $jsonResponse = false;

    /**
     * @var array
     */
    public $jsonMessages = [];

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Check if we need to throw a json response. For ajax calls.
     *
     * @return bool
     */
    public function isJsonResponse()
    {
        return $this->jsonResponse;
    }

    /**
     * Set a flag in order to know if we need to throw a json response.
     *
     * @return $this
     */
    public function setJsonResponse()
    {
        $this->jsonResponse = true;

        return $this;
    }

    /**
     * After execute route event
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->request->isAjax() && $this->isJsonResponse()) {
            $this->view->disable();
            $this->response->setContentType('application/json', 'UTF-8');

            $data = $dispatcher->getReturnedValue();
            if (is_array($data)) {
                $this->response->setJsonContent($data);
            }
            echo $this->response->getContent();
        }
    }

    /**
     * Set a flash message with messages from objects
     *
     * @todo Move to the trait
     * @param $object
     */
    public function displayModelErrors($object)
    {
        if (is_object($object) && method_exists($object, 'getMessages')) {
            foreach ($object->getMessages() as $message) {
                $this->flashSession->error($message);
            }
        } else {
            $this->flashSession->error(t('No object found. No errors.'));
        }
    }

    public function toggleAction($id)
    {
        $this->view->disable();
        if ($this->toggleObject($id)) {
            $this->flashSession->success(t('Entry status changed successfully'));
        } else {
            $this->flashSession->error(t('An error occurred on changing entry status'));
        }

        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    /**
     * Method to toggle objects
     *
     * @return mixed
     */
    private function toggleObject($id, $method = 'status')
    {
        $class = 'Applcon\Models\\' . ucfirst($this->router->getControllerName());

        if (!class_exists($class)) {
            return false;
        }

        $id     = $this->filter->sanitize($id, ['int']);
        $object = $class::findFirstById($id);

        if (!is_object($object)) {
            return false;
        }
        $setter = 'set' . ucfirst($method);
        $getter = 'get' . ucfirst($method);

        if (!method_exists($object, $getter) || !method_exists($object, $setter)) {
            return false;
        }

        $value = $object->$getter() == 0 ? 1 : 0;
        $object->$setter($value);

        return $object->save();
    }


    /**
     * Attempt to determine the real file type of a file.
     *
     * @param string $extension Extension (eg 'jpg')
     *
     * @return boolean
     */
    public function imageCheck($extension)
    {
        $allowedTypes = [
            'image/gif',
            'image/jpg',
            'image/png',
            'image/bmp',
            'image/jpeg',
            'image/x-icon'
        ];

        return in_array($extension, $allowedTypes);
    }


    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function indexRedirect()
    {
        return $this->response->redirect($this->getPathController());
    }

    /**
     * @todo Move to the trait
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    protected function currentRedirect()
    {
        if ($url = $this->cookies->get('urlCurrent')->getValue()) {
            $this->cookies->delete('urlCurrent');
            return $this->response->redirect($url);
        }
        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    public function getPathController()
    {
        return $this->router->getControllerName();
    }

    /**
     * The function sending log for nginx or apache, it will to analytic later
     *
     * @param $e
     */
    public function saveLogger($e)
    {

        $logger = $this->logger;
        if (is_object($e)) {
            $logger->error($e[0]->getMessage());
        }
        if (is_array($e)) {
            foreach ($e as $message) {
                $logger->error($message->getMessage());
            }
        }
        if (is_string($e)) {
            $logger->error($e);
        }
    }

    public function onConstruct()
    {
        $this->view->setVars([
            'auth'          => $this->auth->getAuth(),
            'name'          => $this->config->application->name,
            'publicUrl'     => $this->config->application->publicUrl,
            'action'        => $this->router->getActionName(),
            'controller'    => $this->router->getControllerName(),
            'baseUri'       => $this->config->application->baseUri,
            'googleAnalytic'=> $this->config->googleAnalytic
        ]);
    }
}
