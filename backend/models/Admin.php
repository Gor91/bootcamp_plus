<?php

namespace backend\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $created
 * @property string $updated
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    /* @var $SCENARIO_LOGIN */
    const SCENARIO_LOGIN = 'login';

    /* @var $SCENARIO_UPDATE */
    const SCENARIO_UPDATE = 'update';

    public $reCaptcha;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['email', 'name'], 'required', 'on' => self::SCENARIO_UPDATE],
            ['email', 'email'],
            [['name', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 50],
            [['email'], 'unique', 'on' => self::SCENARIO_UPDATE],
//            [['reCaptcha'], ReCaptchaValidator2::class, 'secret' => Yii::$app->params['reCaptchaSecret'], 'uncheckedMessage' => 'Please confirm that you are not a bot.', 'on' => self::SCENARIO_LOGIN]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @param String $email
     * @return null|Admin
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['id' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash(md5($password));
    }
}
