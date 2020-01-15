<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Task;
use common\models\TaskDonation;
use common\models\TaskStatus;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * Class TaskList
 *
 * ##Задачи
 *
 * ###Список задач
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}task/list/<user_id> | user_id — идентификатор пользователя
 *
 * ###добавлена возможность дополнительного параметра при необходимости
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}task/list/<user_id>/<last_sync_date> | last_sync_date - дата(unix timestamp) начиная с которой необходимо вывести список задач
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * task_id |  Идентификатор задачи
 * fund_id |  Идентификатор фонда
 * owner_id |  Создатель задачи
 * type |  Тип задачи: wake-up, complete-in-time, be-in-time, brake-bad-habits
 * donation |  Размер доната по задаче
 * total_donation |  Сумма выплаченого доната
 * properties |  Объект, который описывает свойства задачи. Специфично для типа задачи
 * status |  Статус выполнения задачи текущим пользователем: current, done, fail.
 * updated_at | timestamp последнего создания или обновления задачи
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 *
 * @package api\components\Rest\Get
 */
class TaskList extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 800;

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /** @inheritdoc */
    public function save()
    {
        $get_params = [];
        $str = preg_replace('/[^0-9\/]/', '', Yii::$app->request->getUrl());
        $res = explode("/", $str);
        foreach ($res as $item){
            if($item) {
                $get_params[] = $item;
            }
        }

        if(count($get_params) == 1) {
            $userId = $get_params[0];
        } elseif(count($get_params) > 1) {
            $userId = $get_params[0];
            $last_sync_date = $get_params[1];
        } else {
            $userId = false;
        }
//        $userId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
        if (empty($userId)) {
            \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
        } else {
            if(empty($last_sync_date)) {
                $model = Task::find()->where(['owner_id' => $userId])->all();
            } else {
                $model = Task::find()
                    ->where(['owner_id' => $userId,])
                    ->andWhere(['>=','UNIX_TIMESTAMP(updated_at)+10800' ,$last_sync_date])
                    ->all();


            }

            if ($model) {
                $arrStatus = ArrayHelper::map(TaskStatus::find()->where(['user_id' => $userId])->asArray()->all(),'task_id','status');
                $arrTaskDonation = ArrayHelper::map(TaskDonation::find()->where(['user_id' => $userId])->asArray()->all(),'task_id','donation');
                $arrs = [];
                foreach ($model as $value) {
                    $arr['task_id'] = $value->id;
                    $arr['fund_id'] = $value->fund_id;
                    $arr['owner_id'] = $value->owner_id;
                    $arr['type'] = $value->type->name;
                    $arr['donation'] = $value->taskDonations;
                    $arr['donation'] = isset($arrTaskDonation[$value->id])?$arrTaskDonation[$value->id]:'';
                    $arr['total_donation'] = $value->donation;
                    $arr['properties'] = unserialize($value->properties);
                    $arr['status'] = (isset($arrStatus[$value->id]))?$arrStatus[$value->id]:'';
                    $arr['updated_at'] = strtotime($value->updated_at);
                    $arrs[] = $arr;
                }
                return $arrs;

            }else{
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        }

    }

}