<?php
/**
 * Copyright (c) kvk-group 2018.
 */


namespace api\components\Rest\Post;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\User;
use common\models\Task;
use Yii;


/**
 * Class TaskStatus
 *
 * ###Установить статус задаче
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}task/status/<task_id> | task_id — идентификатор задачи
 *
 *
 * Параметры запроса
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * status | current, done, fail  | + |
 * user_ids | [int] | + | user_ids — идентификаторы пользователей
 *
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * status | accepted
 *
 * ###добавлена возможность устанавливать статусы нескольким задачам
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}task/status |
 *
 * Параметры запроса (массив JSON-объектов)
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * task_id | int | + | task_id - Идентификатор задачи
 * status | current, done, fail  | + |
 * user_ids | [int] | + | user_ids — идентификаторы пользователей
 *
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * status | accepted
 *
 *  В случае ошибки  будет возвращена ошибка сохранения данных
 *
 * ##Свойства задач
 * ###wake-up:
 *
 * Ключ | Значение | Описание
 * --- | --- | ---
 * time | string - Время в формате H:i:s | Ввод времени, в которое пользователь хочет проснуться
 * snoose_time | int, количество минут | Время, на которое можно отсрочить будильник
 * repeat | [int] — массив дней недели для повторения, где 0 = воскресенье, 6 = суббота | Выбор дней недели, в которые будет срабатывать будильник
 * proof | string | Может быть словом или цифрами
 * sound_id | int | Идентификатор мелодии
 * vibration | 0 or 1 | Вибрация
 *
 *
 * ###complete-in-time:
 *
 * Ключ | Значение | Описание
 * --- | --- | ---
 * title | string | Название задачи
 * deadline | timestamp | Время и дата, до которого нужно завершить задачу
 * reminder | timestamp | Время и дата, когда нужно напомнить о задаче [optional]
 * repeat | daily, weekly, monthly, yearly | Выпадающий список с выбором периодичности задачи
 * subtask | [{name: string,checked: boolean},...] | Возможность добавлять подзадачи в виде check-box [optional]
 * note | string | Длинное описание задачи [optional]
 *
 * ###be-in-time:
 *
 * Ключ | Значение | Описание
 * --- | --- | ---
 * title | string | Название задачи
 * location | {lat: float,lng: float} | Координаты
 * deadline | timestamp | Время и дата, до которого нужно завершить задачу
 * reminder | timestamp | Время и дата, когда нужно напомнить о задаче [optional]
 * repeat | daily, weekly, monthly, yearly | Выпадающий список с выбором периодичности задачи
 * note | string | Длинное описание задачи [optional]
 *
 *
 * ###brake-bad-habits:
 *
 * Ключ | Значение | Описание
 * --- | --- | ---
 * habit_id | Int | Привычка (идентификатор)
 * quit_till | timestamp | Дата, до которой пользователь не будет совершать вредную привычку
 * verification_time | timestamp | Ввод времени, в которое будет приходить опрос, совершал ли пользователь вредную привычку
 *
 * @package api\components\Rest\Post
 */
class TaskStatus extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 1500;

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
            [['status'], 'string'],
            [['task_id', 'user_id'], 'unique', 'targetAttribute' => ['task_id', 'user_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        $statusValid = ['current', 'done', 'fail'];

        ////// если запрос к одной task
            $taskId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
            if($taskId) {
                if (is_array($this->data) && in_array($this->data['status'], $statusValid)) {
                    $task = Task::findOne(['id' => $taskId]);
                    if ($task) {
                        $status = $this->data['status'];
                        foreach ($this->data['user_ids'] as $userId) {
                            $modelStatus = \common\models\TaskStatus::findOne([
                                'task_id' => $taskId,
                                'user_id' => $userId
                            ]);
                            if ($modelStatus) {
                                $modelStatus->status = $status;
                                if ($modelStatus->save()) {
                                } else {
                                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                                }
                            } else {
                                $model = new \common\models\TaskStatus();
                                $model->task_id = $taskId;
                                $model->user_id = $userId;
                                $model->status = $status;
                                if ($model->save()) {
                                } else {
                                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                                }
                            }
                        }
                        if ($status == 'fail') {
                            foreach ($this->data['user_ids'] as $userId) {
                                $model = Task::findOne(['id' => $taskId]);
                                $modelTaskDonation = new \common\models\TaskDonation;
                                $modelTaskDonation->user_id = $userId;
                                $modelTaskDonation->task_id = $taskId;
                                $modelTaskDonation->donation = $model->donation;
                                $modelTaskDonation->save();
                            }
                        }

                        $task->updated_at = date('Y-m-d h:i:s');
                        $task->update();

                        return [
                            'status' => $status,
                        ];
                    } else {
                        \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
                    }
                }
                /////  если запрос массив объектов (обновление нескольких тасок)
            } else {
                $result = [];
                if (is_array($this->data)) {
                    foreach ($this->data as $data){
                        $taskId = $data['task_id'];
                        if(in_array($data['status'], $statusValid)){
                            $task = Task::findOne(['id' => $taskId]);
                            if ($task) {
                                $status = $data['status'];
                                foreach ($data['user_ids'] as $userId) {
                                    $modelStatus = \common\models\TaskStatus::findOne([
                                        'task_id' => $taskId,
                                        'user_id' => $userId
                                    ]);
                                    if ($modelStatus) {
                                        $modelStatus->status = $status;
                                        if ($modelStatus->save()) {
                                        } else {
                                            \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                                        }
                                    } else {
                                        $model = new \common\models\TaskStatus();
                                        $model->task_id = $taskId;
                                        $model->user_id = $userId;
                                        $model->status = $status;
                                        if ($model->save()) {
                                        } else {
                                            \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                                        }
                                    }
                                }
                                if ($status == 'fail') {
                                    foreach ($data['user_ids'] as $userId) {
                                        $model = Task::findOne(['id' => $taskId]);
                                        $modelTaskDonation = new \common\models\TaskDonation;
                                        $modelTaskDonation->user_id = $userId;
                                        $modelTaskDonation->task_id = $taskId;
                                        $modelTaskDonation->donation = $model->donation;
                                        $modelTaskDonation->save();
                                    }
                                }

                                $task->updated_at = date('Y-m-d h:i:s');
                                $task->update();

                            } else {
                                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
                            }

                            $result[] = $data['status'];
                        } else {
                            $result[] = 'no valid';
                        }

                    }
                }
                return $result;
            }

        /////////////////

    }

//    public function save()
//    {
//        $statusValid = ['current', 'done', 'fail'];
//        if (is_array($this->data) && in_array($this->data['status'], $statusValid)) {
//            $taskId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
//            $task = Task::findOne(['id' => $taskId]);
//            if ($task) {
//                $status = $this->data['status'];
//                foreach ($this->data['user_ids'] as $userId) {
//                    $modelStatus = \common\models\TaskStatus::findOne(['task_id' => $taskId, 'user_id' => $userId]);
//                    if ($modelStatus) {
//                        $modelStatus->status = $status;
//                        if ($modelStatus->save()) {
//                        } else {
//                            \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
//                        }
//                    } else {
//                        $model = new \common\models\TaskStatus();
//                        $model->task_id = $taskId;
//                        $model->user_id = $userId;
//                        $model->status = $status;
//                        if ($model->save()) {
//                        } else {
//                            \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
//                        }
//                    }
//                }
//                if ($status == 'fail') {
//                    foreach ($this->data['user_ids'] as $userId) {
//                        $model = Task::findOne(['id' => $taskId]);
//                        $modelTaskDonation = new \common\models\TaskDonation;
//                        $modelTaskDonation->user_id = $userId;
//                        $modelTaskDonation->task_id = $taskId;
//                        $modelTaskDonation->donation = $model->donation;
//                        $modelTaskDonation->save();
//                    }
//                }
//
//                $task->updated_at = date('Y-m-d h:i:s');
//                $task->update();
//
//                return [
//                    'status' => $status,
//                ];
//            } else {
//                \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
//            }
//        }
//    }
}