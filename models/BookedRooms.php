<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booked_rooms".
 *
 * @property int $id
 * @property int $room_id
 * @property string $user_name
 * @property int|null $user_id
 * @property string $phone
 * @property string|null $day
 * @property string|null $day_finish
 * @property int|null $day_calc
 * @property int|null $created_at
 *
 * @property Rooms $room
 */
class BookedRooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booked_rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'user_name', 'phone'], 'required'],
            [['room_id', 'user_id', 'day_calc', 'created_at'], 'integer'],
            [['day', 'day_finish'], 'safe'],
            [['user_name', 'phone'], 'string', 'max' => 250],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    public function init()
    {
        parent::init();

        $this->day_calc = 1;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Номер комнаты',
            'user_name' => 'Имя клиента',
            'user_id' => 'ID пользоваителя',
            'phone' => 'Телефон',
            'day' => 'Дата бронирования',
            'day_finish' => 'Дата окончания бронирования',
            'day_calc' => 'Кол-во дней бронирвоания',
            'created_at' => 'Дата создания',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->created_at = time();

            return true;
        }

        return false;
    }

    /**
     * Gets query for [[Room]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Rooms::className(), ['id' => 'room_id']);
    }
}