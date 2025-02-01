<?php

use yii\db\Migration;

/**
 * Class m250106_000001_create_enums
 */
class m250106_000001_create_enums extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE role_enum AS ENUM ('ADMIN', 'USER')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP TYPE IF EXISTS role_enum");
    }
} 
