<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BookedRooms;

/**
 * BookedRoomsSearch represents the model behind the search form of `app\models\BookedRooms`.
 */
class BookedRoomsSearch extends BookedRooms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'room_id', 'user_id', 'day_calc', 'creates_at'], 'integer'],
            [['user_name', 'phone', 'day'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BookedRooms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'room_id' => $this->room_id,
            'user_id' => $this->user_id,
            'day' => $this->day,
            'day_calc' => $this->day_calc,
            'creates_at' => $this->creates_at,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}