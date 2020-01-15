<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Country;


/**
 * Class DictCountry
 *
 * ##Справочники
 * ###Страны
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}dict/country  |
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * country_id | Идентификатор страны
 * name |	Название страны
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 * @package api\components\Rest\Get
 */
class DictCountry extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 400;

    /**
     * @var
     */
    public $country_id;
    /**
     * @var
     */
    public $name;

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'country_id',], 'string'],
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        $model = Country::find()->all();
        if ($model) {
            $arr = [];
            $arrs = [];
            foreach ($model as $value) {
                $arr['country_id'] = $value->id;
                $arr['name'] = $value->name;
                $arrs[] = $arr;
            }
            return $arrs;
        }else{
            \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
        }
    }

}