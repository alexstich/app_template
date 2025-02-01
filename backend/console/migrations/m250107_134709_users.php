<?php

use yii\db\Migration;

/**
 * Class m250107_134709_users
 */
class m250107_134709_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->comment('Дата создания'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->comment('Дата обновления'),
            'is_admin' => $this->boolean()->notNull()->defaultValue(false)->comment('Администратор системы'),
            'email' => $this->string(512)->notNull()->comment('Email'),
            'email_verified_at' => $this->dateTime()->comment('Дата верификации email'),
            'role' => 'role_enum',
            'password_hash' => $this->string(64)->notNull()->comment('Хэш пароля'),
            'access_token' => $this->string(64)->notNull()->comment('Токен доступа Bearer'),
            'auth_key' => $this->string(64)->notNull()->comment('Ключ авторизации'),
            'email_verification_token' => $this->string(64)->comment('Токен для верификации email'),
            'password_reset_token' => $this->string(64)->comment('Токен для сброса пароля'),
        ]);

        $this->createIndex('idx-user-email', '{{%user}}', 'email', true);
        $this->createIndex('idx-user-access_token', '{{%user}}', 'access_token', true);
        $this->createIndex('idx-user-email_verification_token', '{{%user}}', 'email_verification_token', true);


        // Администратор, логин: admin@admin.com, пароль: admin
        $sql_command = <<<SQL
        INSERT INTO "user" (
            is_admin, 
            password_hash, 
            email, 
            email_verified_at,
            access_token,
            auth_key,
            role
            ) 
        VALUES (
            true, 
            '21232f297a57a5a743894a0e4a801fc3', 
            'admin@admin.com', 
            '2025-01-01 00:00:00', 
            '1234567890', 
            '1234567890', 
            'TEACHER'
            );
        SQL;

        $this->execute($sql_command);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-email', '{{%user}}');
        $this->dropIndex('idx-user-access_token', '{{%user}}');
        $this->dropIndex('idx-user-email_verification_token', '{{%user}}');
        $this->dropTable('{{%user}}');
    }
}
