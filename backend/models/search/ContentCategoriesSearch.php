<?php

namespace backend\models\search;

use backend\models\ContentCategories;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentCategoriesSearch represents the model behind the search form about `common\models\ContentCategories`.
 */
class ContentCategoriesSearch extends ContentCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_user_id', 'update_user_id', 'create_time', 'update_time'], 'integer'],
            [['title', 'description', 'img', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ContentCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>['defaultOrder'=>['create_time'=>'DESC']]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_user_id' => $this->create_user_id,
            'update_user_id' => $this->update_user_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'date', $this->date ? date_format(date_create($this->date),'Y-m-d H:i:s') : ''])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
