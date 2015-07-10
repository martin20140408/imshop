<?php

namespace im\users;

use im\users\components\UserEventsHandler;
use Yii;
use yii\base\Component;
use yii\di\Instance;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'im\users\controllers';

    /**
     * @var bool whether to enable registration.
     */
    public $enableRegistration = true;

    /**
     * @var bool whether the user have to confirm registration
     */
    public $registrationConfirmation = false;

    /**
     * @var bool whether to login user after registration
     */
    public $loginAfterRegistration = true;

    /**
     * @var string|array the url to which to redirect the user after registration
     */
    public $redirectAfterRegistration = 'success';

    /**
     * @var bool whether to enable automatic password generation.
     */
    public $passwordAutoGenerating = false;

    /**
     * @var int generated password length.
     */
    public $passwordLength = 5;

    /**
     * @var UserEventsHandler|array|string the handler object or the application component ID of the handler
     */
    public $userEventsHandler = ['class' => 'im\users\components\UserEventsHandler'];

    /**
     * @var string user model class
     */
    public $userModel = 'im\users\models\User';

    /**
     * @var string profile model class
     */
    public $profileModel = 'im\users\models\Profile';

    /**
     * @var string registration form model class
     */
    public $registrationForm = 'im\users\models\RegistrationForm';

    /**
     * @var string The prefix for user module URL.
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'user';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<id:\d+>'                    => 'profile/show',
        '<action:(login|logout)>'     => 'security/<action>',
        '<action:(register|resend)>'  => 'registration/<action>',
        'confirm/<id:\d+>/<code:\w+>' => 'registration/confirm',
        'forgot'                      => 'recovery/request',
        'recover/<id:\d+>/<code:\w+>' => 'recovery/reset',
        'settings/<action:\w+>'       => 'settings/<action>'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->userEventsHandler !== null && !is_object($this->userEventsHandler)) {
            $this->userEventsHandler = Yii::createObject($this->userEventsHandler);
        }
    }

    /**
     * Translate a message to the specified language using module translations.
     *
     * @param string $category the message category.
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code.
     * @return string the translated message.
     * @see \Yii::t()
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }

}