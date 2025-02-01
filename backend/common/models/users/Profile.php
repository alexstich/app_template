<?php

namespace common\models\users;

use yii\db\ActiveRecord;

/** 
 * @property int $id Идентификатор
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property int $user_id Идентификатор пользователя
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $photo_url Аватар
 * @property string $about_description Описание человека
 * @property string $goal_description Цель человека
 * @property int $age Возраст
 * @property string $gender Пол
 * @property string $country Страна
 * @property string $instagram_username Имя в Instagram
 * @property string $website_url Ссылка на сайт
 * @property string $linkedin_url Ссылка на LinkedIn
 * @property string $facebook_url Ссылка на Facebook
 * @property string $twitter_url Ссылка на Twitter
 * @property string $youtube_url Ссылка на YouTube
 * @property string $tiktok_username Имя в TikTok
 * @property string $telegram_username Имя в Telegram
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }
}