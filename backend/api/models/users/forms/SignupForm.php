<?php

namespace api\models\users\forms;

use Yii;
use yii\base\Model;
use api\models\users\User;
use api\models\users\Profile;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email is already taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs up user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $transaction = \Yii::$app->db->beginTransaction(\yii\db\Transaction::SERIALIZABLE);

        try {
            $user = new User();
            $user->email = $this->email;
            $user->setPasswordHash($this->password);
            $user->generateAccessToken();
            $user->generateAuthKey($this->password, $this->email);
            $user->role = User::ROLE_STUDENT;
            $user->is_admin = false;

            // Save the user
            $userSave = $user->save();
        
            if ($userSave) {
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->first_name = $this->username;
        
                // Save the profile
                $profileSave = $profile->save();
        
                if (!$profileSave) {
                    throw new \Exception('Failed to save profile.');
                }
            } else {
                throw new \Exception('Failed to save user.');
            }
        
            $transaction->commit();

        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            $transaction->rollBack();
            // Re-throw the exception to handle it elsewhere
            throw $e;
        }
        
        return $userSave && $profileSave ? $user : null;
    }
} 