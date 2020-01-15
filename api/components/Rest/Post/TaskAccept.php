<?php
/**
 * Copyright (c) kvk-group 2018.
 */


namespace api\components\Rest\Post;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Invites;
use common\models\Task;
use common\models\User;
use Yii;

/**
 * Class TaskAccept
 *
 * ###Присоединиться к участию в задаче
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}task/accept/<task_id> | task_id — идентификатор задачи
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * status | accepted
 *
 *  В случае ошибки  будет возвращен status false
 *
 * @package api\components\Rest\Post
 */
class TaskAccept extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 1300;

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
        if ($this->rest->user->id) {
            $taskId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
            $task = Task::findOne(['id'=>$taskId]);
            if ($task) {
                $modelInvites = Invites::findOne(['task_id' => $taskId, 'user_id' => $this->rest->user->id]);
                if ($modelInvites == null) {
                    $model = new Invites();
                    $model->task_id = $taskId;
                    $model->user_id = $this->rest->user->id;
                    $model->status = 'accepted';
                    $model->save();
                    $arr = $model->errors;
                } else {
                    $modelInvites->status = 'accepted';
                    $modelInvites->save();
                    $arr = $modelInvites->errors;
                }
                if (empty($arr)) {
                    return [
                        'status' => 'accepted'
                    ];
                } else {
                    return [
                        'status' => 'false'
                    ];
                }

                $task->updated_at = date('Y-m-d h:i:s');
                $task->update();

            } else {
                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
            }
        }
        \Yii::$app->response->throwError(ErrorCode::AUTH_DENIED, "Auth denied");

    }
}