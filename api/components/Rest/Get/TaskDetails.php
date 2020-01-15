<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Invites;
use common\models\Task;
use common\models\TaskDonation;
use common\models\TaskStatus;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Class TaskDetails
 *
 *
 * ###Информация по задаче
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}task/details/<task_id> | task_id — идентификатор задачи
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
 * statistics |  Объект статистики по задаче
 * statistics.done |  Массив участников, завершивших задачу — массив идентификаторов
 * statistics.fail |  Массив участников, проваливших задачу — массив идентификаторов
 * invites |  Список приглашений - объект
 * invites.all |  Массив идентификаторов всех приглашенных пользователей
 * invites.accepted |  Массив идентификаторов пользователей, подтвердивших участие
 * invites.declined |  Массив идентификаторов пользователей, отказавших в участие
 *
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 *
 * @package api\components\Rest\Get
 */
class TaskDetails extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 900;

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];


    /** @inheritdoc */
    public function save()
    {
        $taskId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
        if (empty($taskId)) {
            \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
        } else {
            $model = Task::find()->where(['id' => $taskId])->one();
            if ($model) {
                $modelDonation = TaskDonation::find()->where(['task_id' => $model->id, 'user_id' => $model->owner_id])->one();
                $modelStatisticDone = ArrayHelper::getColumn(TaskStatus::find()->where(['task_id' => $model->id, 'status' => 'done'])->all(), 'user_id');
                $modelStatisticFail = ArrayHelper::getColumn(TaskStatus::find()->where(['task_id' => $model->id, 'status' => 'fail'])->all(), 'user_id');
                $invitesAll = ArrayHelper::getColumn(Invites::find()->where(['task_id' => $model->id])->all(), 'user_id');
                $invitesAccepted = ArrayHelper::getColumn(Invites::find()->where(['task_id' => $model->id, 'status' => 'accepted'])->all(), 'user_id');
                $invitesDeclined = ArrayHelper::getColumn(Invites::find()->where(['task_id' => $model->id, 'status' => 'declined'])->all(), 'user_id');
                return [
                    'task_id' => $model->id,
                    'fund_id' => $model->fund_id,
                    'owner_id' => $model->owner_id,
                    'type' => $model->type->name,
                    'donation' => (isset($modelDonation->donation)) ? $modelDonation->donation : '',
                    'properties' => unserialize($model->properties),
                    'statistics' => [
                        'statistics.done' => (isset($modelStatisticDone)) ? $modelStatisticDone : [],
                        'statistics.fail' => (isset($modelStatisticFail)) ? $modelStatisticFail : [],
                    ],
                    'invites' => [
                        'invites.all' => (isset($invitesAll)) ? $invitesAll : [],
                        'invites.accepted' => (isset($invitesAccepted)) ? $invitesAccepted : [],
                        'invites.declined' => (isset($invitesDeclined)) ? $invitesDeclined : [],
                    ]
                ];
            }else{
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        }

    }

}