<?php

namespace Applcon\Oauth\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * \Applcon\Oauth\Forms\LoginForm
 *
 * @package Applcon\Oauth\Forms
 */
class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new Text(
            'email',
            [
                'class'       => 'text-box',
                'required'    => true,
                'autofocus'   => true,
                'placeholder' => t('Username or Email'),
            ]
        );
        $email->addValidator(new PresenceOf(['message' => t('The Username or E-Mail is required')]));
        $this->add($email);

        // Password
        $password = new Password(
            'password',
            [
                'placeholder' => t('Password'),
                'class'       => 'text-box',
                'required'    => true,
            ]
        );
        $password->addValidator(new PresenceOf(['message' => t('The password is required')]));
        $this->add($password);

        // Remember me
        $remember = new Check(
            'remember',
            [
                'value'   => 'yes',
                'checked' => 'checked',
                'id'      => 'remember-me',
            ]
        );
        $this->add($remember);

        // Submit
        $this->add(
            new Submit(
                'submit',
                [
                    'class' => 'submit-button-login',
                    'value' => t('Sign In')
                ]
            )
        );
    }

    /**
     * Prints messages for a specific element.
     * @param string $name
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
