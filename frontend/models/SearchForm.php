<?php
namespace frontend\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
class SearchForm extends Model
{
    public $text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            ['text', 'string']
        ];
    }

    public function search($params)
    {
        $query = \backend\models\Content::find();
        $query->with(['categories']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['status' => 1])
            ->andFilterWhere(['OR', ['like', 'title', $this->text],
            ['like', 'description', $this->text],
            ['like', 'seo_keywords', $this->text],
            ['like', 'text', $this->text],
        ]);


        return $dataProvider;
    }

}