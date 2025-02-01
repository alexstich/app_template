<?php

namespace api\models\users;

use common\models\users\User as CommonUser;

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
class User extends CommonUser
{
    /**
     * @return array
     */      
    public function fields()
    {
        return [
            'id', 
            'email', 
            'access_token',
            'profile'
        ];
    }
}
