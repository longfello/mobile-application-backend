<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Habbit;


/**
 * Class DictHabit
 *
 *
 * ###Привычки
 *
 * Тип запроса | URI
 * --- | --- | ---
 * GET | {%api_url}dict/habit |
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * habit_id | Идентификатор привычки
 * name | Название привычки
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 * @package api\components\Rest\Get
 */
class DictHabit extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 700;

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];


    /** @inheritdoc */
    public function save()
    {
        $model = Habbit::find()->all();
        if ($model) {
            $arr = [];
            $arrs = [];
            foreach ($model as $value) {
                $arr['habit_id'] = $value->id;
                $arr['name'] = $value->name;
                $arrs[] = $arr;
            }
            return $arrs;
        }else{
            \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
        }

    }

}