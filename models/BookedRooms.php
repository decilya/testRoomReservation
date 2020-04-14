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
 * @property int|null $day_calc
 * @property int|null $creates_at
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
            [['room_id', 'user_id', 'day_calc', 'creates_at'], 'integer'],
            [['day'], 'safe'],
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
            'day_calc' => 'Кол-во дней бронирвоания',
            'creates_at' => 'Дата создания',
        ];
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