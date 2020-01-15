<?php
/**
 * Copyright (c) kvk-group 2018.
 */


namespace api\components\Rest\Post;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\BeInTime;
use common\models\BrakeBadHabits;
use common\models\CompleteInTime;
use common\models\Founds;
use common\models\Invites;
use common\models\Task;
use common\models\User;
use common\models\TaskType;
use common\models\WakeUp;


/**
 * Class TaskCreate
 *
 * ###Создать задачу
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}task/create
 *
 * Параметры запроса (сервер должен принимать массив JSON-объектов задач)
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * owner_id | Создатель задачи | + |
 * fund_id | Идентификатор фонда | + |
 * type | Тип задачи: wake-up, complete-in-time, be-in-time, brake-bad-habits | + |
 * donation | Размер доната по задаче | + |
 * properties | type-specific | + |
 * invite | массив идентификаторов пользователей  | + |
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * task_id | Идентификатор задачи
 *
 * В случае ошибки  будет возвращен код ошибки
 *
 *
 * @package api\components\Rest\Post
 */
class TaskCreate extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 1000;

    /**
     * @var int
     */
    public $owner_id;
    /**
     * @var int
     */
    public $fund_id;
    /**
     * @var float
     */
    public $donation;
    /**
     * @var type-specific
     */
    public $properties;
    /**
     * @var int
     */
    public $type_id;


    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['fund_id', 'owner_id', 'type_id'], 'integer'],
            [['created', 'donation', 'properties','updated_at'], 'safe'],
            [['fund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Founds::className(), 'targetAttribute' => ['fund_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        $task_ids = [];
        if ($this->data) {
            foreach ($this->data as $data) {
                if ($data) {
                    $typeId = TaskType::find()->where(['name' => $data['type']])->limit(1)->one();
                    if ($this->ValidatePropertis($data)) {
                        $model = new Task();
                        $model->owner_id = $data['owner_id'];
                        $model->fund_id = $data['fund_id'];
                        $model->type_id = $typeId->id;
                        $model->donation = $data['donation'];
                        $model->properties = serialize($data['properties']);
                        if ($model->save() && $model->id) {
                            foreach ($data['invite'] as $val) {
                                $modelInvite = new Invites();
                                $modelInvite->user_id = $val;
                                $modelInvite->task_id = $model->id;
                                $modelInvite->save();
                            }
                            $task_ids[] = $model->id;
                        } else {
                            \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                        }
                    }
                } else {
                    \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                }
            }
            return [
                'task_ids' => $task_ids,
            ];
        }else{
            \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
        }
    }

//    public function save()
//    {
//        if ($this->data) {
//            $typeId = TaskType::find()->where(['name' => $this->data['type']])->limit(1)->one();
//            if ($this->ValidatePropertis($this->data)) {
//                $model = new Task();
//                $model->owner_id = $this->data['owner_id'];
//                $model->fund_id = $this->data['fund_id'];
//                $model->type_id = $typeId->id;
//                $model->donation = $this->data['donation'];
//                $model->properties = serialize($this->data['properties']);
//                if ($model->save() && $model->id) {
//                    foreach ($this->data['invite'] as $val) {
//                        $modelInvite = new Invites();
//                        $modelInvite->user_id = $val;
//                        $modelInvite->task_id = $model->id;
//                        $modelInvite->save();
//                    }
//                    return [
//                        'task_id' => $model->id,
//                    ];
//                } else {
//                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
//                }
//            };
//        }else{
//            \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
//        }
//    }

    /**
     * @param $data
     * @return bool
     */
    public function ValidatePropertis($data)
    {
        switch ($data['type']) {
            case 'wake-up':
                if (isset($data['properties']['repeat']) && is_array($data['properties']['repeat'])) {
                    foreach ($data['properties']['repeat'] as $value) {
                        if ($value > 6) {
                            \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                        }
                    }
                }
                $modelWake = new WakeUp();
                $modelWake->attributes = $data['properties'];
                if ($modelWake->validate()) {
                    return true;
                } else {
                    \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                }
                break;
            case 'complete-in-time':
                $modelComplate = new CompleteInTime();
                $modelComplate->attributes = $data['properties'];
                if ($modelComplate->validate()) {
                    return true;
                } else {
                    \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                }
                break;
            case 'be-in-time':
                $modelBeInTime = new BeInTime();
                $modelBeInTime->attributes = $data['properties'];
                if ($modelBeInTime->validate()) {
                    return true;
                } else {
                    \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                }
                break;
            case 'brake-bad-habits':
                $modelBrakeBadHabits = new BrakeBadHabits();
                $modelBrakeBadHabits->attributes = $data['properties'];
                if ($modelBrakeBadHabits->validate()) {
                    return true;
                } else {
                    \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                }
                break;
            default:
                \Yii::$app->response->throwError(ErrorCode::VALIDATE_DATA, "VALIDATE_DATA");
                break;
        }
    }
}