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
 * Class TaskDecline
 *
 * ###Отказаться от участия в задаче
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}task/decline/<task_id> | task_id — идентификатор задачи
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * status | accepted
 *
 *  В случае ошибки  будет возвращена ошибка сохранения данных
 *
 * @package api\components\Rest\Post
 */
class TaskDecline extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 1400;

    /**
     * @var int
     */
    public $task_id;

    /**
     * @var int
     */
    public $user_id;
    /**
     * @var
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
                    $model->status = 'declined';
                    $model->save();
                    $arr = $model->errors;
                } else {
                    $modelInvites->status = 'declined';
                    $modelInvites->save();
                    $arr = $modelInvites->errors;
                }
                if (empty($arr)) {
                    return [
                        'status' => 'declined'
                    ];
                } else {
                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
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