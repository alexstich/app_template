<?php

use yii\db\Migration;

/**
 * Class m250108_134709_profile
 */
class m250108_134709_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->comment('Дата создания'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->comment('Дата обновления'),
            'user_id' => $this->integer()->notNull()->comment('Идентификатор пользователя'),
            'first_name' => $this->string(255)->notNull()->comment('Имя'),
            'last_name' => $this->string(255)->comment('Фамилия'),
            'photo_url' => $this->string(512)->comment('Аватар'),
            'about_description' => $this->text()->comment('Описание человека'),
            'goal_description' => $this->text()->comment('Цель человека'),
            'age' => $this->integer()->comment('Возраст'),
            'gender' => $this->string(16)->comment('Пол'),
            'country' => $this->string(128)->comment('Страна'),
            'instagram_username' => $this->string(128)->comment('Имя в Instagram'),
            'website_url' => $this->string(512)->comment('Ссылка на сайт'),
            'linkedin_url' => $this->string(512)->comment('Ссылка на LinkedIn'),
            'facebook_url' => $this->string(512)->comment('Ссылка на Facebook'),
            'twitter_url' => $this->string(512)->comment('Ссылка на Twitter'),
            'youtube_url' => $this->string(512)->comment('Ссылка на YouTube'),
            'tiktok_username' => $this->string(512)->comment('Имя в TikTok'),
            'telegram_username' => $this->string(512)->comment('Имя в Telegram'),
        ]);

        $this->createIndex('idx-profile-first_name', '{{%profile}}', 'first_name', true);
        $this->createIndex('idx-profile-last_name', '{{%profile}}', 'last_name', true);

        $this->addForeignKey('fk-profile-user_id', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $sql_command = <<<SQL
        INSERT INTO "profile" (user_id, first_name, last_name, photo_url, about_description, goal_description, age, gender, country, instagram_username, website_url, linkedin_url, facebook_url, twitter_url, youtube_url, tiktok_username, telegram_username) 
        VALUES (1, 'Aleksei', 'Grebenkin', null, 'I am admin of the system', 'To get 9 score in IELTS', 30, 'male', 'Russia', 'aleksei_grebenkin', 'https://www.alekseigrebenkin.com', 'https://www.linkedin.com/in/aleksei-grebenkin', 'https://www.facebook.com/aleksei.grebenkin', 'https://www.twitter.com/aleksei_grebenkin', 'https://www.youtube.com/aleksei_grebenkin', 'aleksei_grebenkin', 'aleksei_grebenkin');
        SQL;

        $this->execute($sql_command);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-profile-user_id', '{{%profile}}');
        $this->dropIndex('idx-profile-first_name', '{{%profile}}');
        $this->dropIndex('idx-profile-last_name', '{{%profile}}');
        $this->dropTable('{{%profile}}');
    }
}
