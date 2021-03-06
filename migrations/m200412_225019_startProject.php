<?php

use yii\db\Migration;

/**
 * Class m200412_225019_startProject
 */
class m200412_225019_startProject extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = Yii::$app->params['tableOptions'];
        }

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'name' => $this->string(125)->notNull(),
            'surname' => $this->string(125)->notNull(),
            'patronymic' => $this->string(125)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string(20)->null(),
            'status_id' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'type' => $this->smallInteger(1)->notNull(),
            'description' => $this->string(250)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->null(),
            'last_updated_user_id' => $this->integer(11)->null(),
            'isLogin' => $this->integer(11)->null()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

}