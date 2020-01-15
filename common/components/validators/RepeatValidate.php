<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 23.04.18
 * Time: 11:58
 */

namespace common\components\validators;

use yii\validators\Validator;

/**
 * Class RepeatValidate
 * @package common\components\validators
 */
class RepeatValidate extends Validator

{
    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->$attribute, ['daily', 'weekly', 'monthly', 'yearly'])) {
            $this->addError($model, $attribute, 'only: daily | weekly | monthly | yearly');
        }
    }
}