<?php
/**
 * Copyright (c) kvk-group 2018.
 */


namespace api\components\Rest\Post;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Invites;
use common\models\User;
use common\models\Task;
use Yii;


/**
 * Class TaskInvite
 *
 * ###Выслать приглашение присоединиться к задаче
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}task/invite/<task_id> | task_id — идентификатор задачи
 *
 * Параметры запроса
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * [] | массив идентификаторов пользователей | + |
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * status | Формальный параметр
 *
 * @package api\components\Rest\Post
 */
class TaskInvite extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 1100;

    /**
     * @var int
     */
    public $task_id;
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var string
     */
    public $status;
    /**
     * @var timestamp
     */
    public $sended;


    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [

            [['task_id', 'user_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        if ($this->data) {
            $taskId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
            $task = Task::findOne(['id'=>$taskId]);
            if ($task) {
                foreach ($this->data as $userId) {
                    $model = new Invites();
                    $model->task_id = $taskId;
                    $model->user_id = $userId;
                    $model->save();
                }

                $task->updated_at = date('Y-m-d h:i:s');
                $task->update();
                return [
                    'status' => 'new',
                ];

            } else {
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        }
            \Yii::$app->response->throwError(ErrorCode::AUTH_DENIED, "Auth denied");

    }
}