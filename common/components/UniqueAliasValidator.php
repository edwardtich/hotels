<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 14.08.15
 * Time: 13:15
 */

namespace common\components;

use yii\validators\Validator;

class UniqueAliasValidator extends Validator
{
    public $tables = [];

    public function validateAttribute($model, $attribute)
    {
        $results = false;

        if ($this->tables) {
            foreach ($this->tables as $tbl) {
                $query = (new \yii\db\Query())
                    ->from($tbl)
                    ->where(['alias' => $model->$attribute]);

                if ($model->id) {
                    $row = $query->andWhere('id !=' . $model->id)->count();
                } else {
                    $row = $query->count();
                }

                if ($row > 0) {
                    $results = true;
                    break;
                }
            }
        }
        if ($results) {
            $this->addError($model, $attribute, 'Данное значение уже используется.');
        }
    }
} 