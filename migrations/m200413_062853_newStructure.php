<?php

use yii\db\Migration;

/**
 * Class m200413_062853_newStructure
 */
class m200413_062853_newStructure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = Yii::$app->params['tableOptions'];
        }

        $this->createTable('rooms', [
            'id' => $this->primaryKey(),
            'name' => $this->string(125)->notNull(),
            'description' => $this->string(250)->null(),
        ], $tableOptions);

        $this->createTable('booked_rooms', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(11)->notNull(),
            'user_name' => $this->string(250)->notNull(),
            'user_id' => $this->integer(11)->null(),
            'phone' => $this->string(250)->notNull(),
            'day' => 'datetime',
            'day_finish' => 'datetime',
            'day_calc' => $this->integer(11)->null(),
            'created_at' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->createIndex('idx-room_id', 'booked_rooms', 'room_id');
        $this->addForeignKey('fk-room_id', 'booked_rooms', 'room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-room_id', 'booked_rooms');
        $this->dropIndex('idx-room_id', 'booked_rooms');

        $this->dropTable('rooms');
        $this->dropTable('booked_rooms');
    }
}
