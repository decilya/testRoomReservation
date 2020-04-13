<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property BookedRooms[] $bookedRooms
 */
class Rooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 125],
            [['description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[BookedRooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookedRooms()
    {
        return $this->hasMany(BookedRooms::className(), ['room_id' => 'id']);
    }
}