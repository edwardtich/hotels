<?php

namespace backend\models\search;

use Faker\Provider\DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Content;

/**
 * ContentSearch represents the model behind the search form about `backend\models\Content`.
 */
class ContentSearch extends Content
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat', 'status', 'sort', 'create_user_id', 'update_user_id', 'create_time', 'update_time'], 'integer'],
            [['title', 'alias', 'description', 'text', 'img', 'date', 'seo_title', 'seo_description', 'seo_keywords', 'categories.title'], 'safe'],
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

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['categories.title']);
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
        $query = Content::find();
        $query->joinWith(['categories categories']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['create_time' => 'DESC']]
        ]);

        $dataProvider->sort->attributes['categories.title'] = [
            'asc' => ['categories.title' => SORT_ASC],
            'desc' => ['categories.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($params['cat'])) {
            $query->where(['cat' => (int)$params['cat']]);
        }

        $query->andFilterWhere([
            'content.id' => $this->id,
            'content.cat' => $this->getAttribute('categories.title'),
            'content.status' => $this->status,
            'content.sort' => $this->sort,
            'content.create_user_id' => $this->create_user_id,
            'content.update_user_id' => $this->update_user_id,
            'content.create_time' => $this->create_time,
            'content.update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'content.title', $this->title])
            ->andFilterWhere(['like', 'content.alias', $this->alias])
            ->andFilterWhere(['like', 'content.description', $this->description])
            ->andFilterWhere(['like', 'content.text', $this->text])
            ->andFilterWhere(['like', 'content.date', $this->date ? date_format(date_create($this->date), 'Y-m-d H:i:s') : ''])
            ->andFilterWhere(['like', 'content.img', $this->img])
            ->andFilterWhere(['like', 'content.seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'content.seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'content.seo_keywords', $this->seo_keywords]);

        return $dataProvider;
    }
}
