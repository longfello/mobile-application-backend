<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Founds;
use common\models\Task;
use Yii;


/**
 * Class DictFund
 *
 * ###Фонды
 * Тип запроса | URI
 * --- | --- | ---
 * GET | {%api_url}dict/fund
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * fund_id |  Идентификатор фонда
 * name |  Название фонда
 * logo |  URL логотипа
 * banner |  URL баннера
 * country_id |  Идентификатор страны, null для интернационального
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 * ###Фонд — детальная информация
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}dict/fund/<fund_id> | где fund_id идентификатор фонда
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * fund_id |  Идентификатор фонда
 * name |  Название фонда
 * logo |  URL логотипа
 * banner |  URL баннера
 * href |  Ссылка на сайт
 * description |  Описание
 * donations | Сумма доната
 * participant | Количество участников
 * country_id |  Идентификатор страны, null для интернационального
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 *
 * @package api\components\Rest\Get
 */
class DictFund extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 500;


    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];


    /** @inheritdoc */
    public function save()
    {
        $number = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
        if (empty($number)) {
            $model = Founds::find()->all();
            if ($model) {
                $arr = [];
                $arrs = [];
                foreach ($model as $value) {
                    $arr['fund_id'] = $value->id;
                    $arr['name'] = $value->name;
                    $arr['logo'] = $value->logo_base_url . '/' . $value->logo_path;
                    $arr['banner'] = $value->banner_base_url . '/' . $value->banner_path;
                    $arr['country_id'] = $value->country_id;
                    $arrs[] = $arr;
                }
                return $arrs;
            } else {
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        } else {
            $model = Founds::findOne(['id' => $number]);
            if ($model) {
                $countParticipant = Task::find()->where(['fund_id' => $number])->count();
                $sumDonation = null;
                foreach ($model->tasks as $val) {
                    $sumDonation += $val->donation;
                }

                return [
                    'fund_id' => $model->id,
                    'name' => $model->name,
                    'logo' => $model->logo_base_url . '/' . $model->logo_path,
                    'banner' => $model->banner_base_url . '/' . $model->banner_path,
                    'href' => $model->href,
                    'description' => $model->description,
                    'donations' => $sumDonation,
                    'participant' => (int)$countParticipant,
                    'country_id' => $model->country_id,
                ];
            } else {
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        }
    }

}