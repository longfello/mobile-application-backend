<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Sound;


/**
 * Class DictSound
 *
 * ###Мелодии
 *
 * Тип запроса | URI
 * --- | --- | ---
 * GET | {%api_url}dict/sound |
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * sound_id | Идентификатор мелодии
 * name | Название мелодии
 * url | URL мелодии
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 * @package api\components\Rest\Get
 */
class DictSound extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 600;

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];


    /** @inheritdoc */
    public function save()
    {
            $model = Sound::find()->all();
            if ($model) {
                $arr = [];
                $arrs = [];
                foreach ($model as $value) {
                    $arr['sound_id'] = $value->id;
                    $arr['name'] = $value->name;
                    $arr['url'] = $value->base_url . '/' . $value->path;
                    $arrs[] = $arr;
                }
                return $arrs;
            }else{
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }

    }

}