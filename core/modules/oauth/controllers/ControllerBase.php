<?php

namespace Applcon\Oauth\Controllers;

use Applcon\Models\Users;
use Applcon\Models\Karma;
use Applcon\Controllers\Controller;

/**
 * \Applcon\Oauth\Controllers\ControllerBase
 *
 * @property \Applcon\Auth\Auth $auth
 * @property \Phalcon\Config $config
 * @property \Applcon\Mail\Mail $mail
 *
 * @package Applcon\Oauth\Controllers
 */
class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->loadDefaultAssets();
    }

    /**
     * @param string $uid       to checking condition when authentication again
     * @param object $user      here is oauth
     * @param object $token     here it is token get by oauth
     * @param object $object    here is it is find in database
     * @param string $nameOauth there are google, github, facebook...
     *
     * @return mixed
     */
    public function commonOauthSave($uid, $user, $token, $object, $nameOauth)
    {

        if (!$object) {
            $object = new Users();
            //setTokenGithub or setTokenGoogle
            $uuidName  = 'setUuid' . $nameOauth;
            $tokenName = 'setToken'. $nameOauth;
            $object->$tokenName($token->accessToken);
            $object->setTokenType(Users::TOKEN_TYPE);
            //$object->setUid($uid);
            $object->$uuidName($uid);
            $object->setEmail($user->email);
            $object->setFirstname($user->firstName);
            //@ Todo later, it perfect if we do haven't delete in database
            $username = 'users' . (Users::count() + 1);
            $object->setUsername($username);
            if (empty($user->email)) {
                $object->setEmail($username .'+@applcon.com');
            }
            $object->setStatus(Users::STATUS_ACTIVE);
            $object->increaseKarma(Karma::LOGIN);
            if (!$object->save()) {
                $this->displayModelErrors($object);
                return $this->indexRedirect();
            }
        }
        //Update session id
        session_regenerate_id(true);



        //Store the user data in session
        $this->auth->setSession($object);

        //Store the user data in cookies
        $this->auth->setRememberEnvironment($object);

        //Display notification when user login
        $this->notification($object);

        return $this->currentRedirect();
    }

    protected function currentRedirect()
    {
        if ($this->cookies->has('HTTPBACK')) {
            $url = $this->cookies->get('HTTPBACK')->getValue();
            $this->cookies->delete('HTTPBACK');

            return $this->response->redirect(unserialize($url));
        }

        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    public function indexRedirect()
    {
        return $this->response->redirect('oauth/login');
    }

    /**
     * loadDefaultAssets function.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        $this->assets
            ->addCss('core/assets/css/bootstrap.min.css')
            ->addCss('core/assets/font-awesome/css/font-awesome.css')
            ->addCss('core/assets/css/animate.css')
            ->addCss('core/assets/css/style.css')
            ->addCss('oauth/assets/css/login.css')
        ;
        $this->assets
            ->addJs('core/assets/js/jquery-3.1.1.min.js')
            ->addJs('core/assets/js/bootstrap.min.js')
            ->addJs('oauth/assets/js/app.function.js')
            ->addJs('oauth/assets/js/app.js')
        ;
    }
}
