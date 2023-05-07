<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 28.01.16
 * Time: 17:04
 */

namespace common\widgets\AutoComplete;

use anmaslov\autocomplete\AutoComplete;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class MyAutoComplete extends AutoComplete
{
    public function run()
    {
        if (empty($this->data) || !is_array($this->data)) {
            throw new InvalidConfigException("You must define the 'data' property");
        }

        $this->registerAssets();
        echo Html::textInput($this->name, $this->value, $this->options);
    }
} 