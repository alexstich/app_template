<?php

namespace common\models\users;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/** 
 * @property $id Идентификатор
 * @property $created_at Дата создания
 * @property $updated_at Дата обновления
 * @property $is_admin Администратор системы
 * @property $email Email
 * @property $email_verified_at Дата верификации email
 * @property $role Роль в системе
 * @property $password_hash Хэш пароля
 * @property $access_token Токен доступа Bearer
 * @property $auth_key Ключ авторизации
 * @property $email_verification_token Токен для верификации email
 * @property $password_reset_token Токен для сброса пароля
 *   
 * @property Profile $profile Профиль пользователя
*/
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()
            ->where(['LIKE', 'LOWER([[email]])', strtolower($email)])
            ->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * @return void
     */
    public function generateAuthKey($password, $email)
    {
        if (empty($password) || empty($email)) {
            return;
        }

        $this->auth_key = md5($password . $email);
    }

    /**
     * @return void
     */
    public function generateAccessToken()
    {
        $this->access_token = md5(time() . $this->email);
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     *
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @return string
     */
    public static function generatePassword()
    {
        $password = "";

        for ( $i = 0; $i < 5; $i++ ){
            $password .= rand(0,9);
        }

        return $password;
    }

    /**
     * @param $email
     * @param User|null $currentUser
     * @return bool
     */
    public static function emailOccupied($email, User $currentUser = null)
    {
        if ($currentUser) {
            $occupant = self::find()
                ->where(['email' => $email])
                ->andWhere(['not', ['id' => $currentUser->id]])
                ->one();
        } else {
            $occupant = self::getByEmail($email);
        }

        return !empty($occupant);
    }

    /**
     * Find user by email
     *
     * @param String $email
     *
     * @return User|array|ActiveRecord|null
     */
    public static function getByEmail($email)
    {
        return User::find()->where(['email' => $email, "deleted" => null])->one();
    }

    /**
     * @param string $password
     */
    public function setPasswordHash($password)
    {
        $this->password_hash = md5($password);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        if ($this->password_hash !== md5($password)) {
            $this->addError("password", "Wrong password");

            return false;
        }

        return true;
    }
}

