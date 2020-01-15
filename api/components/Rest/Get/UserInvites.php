<?php
/**
 * Copyright (c) kvk-group 2018.
 */

namespace api\components\Rest\Get;

use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\Invites;
use Yii;

/**
 * Class UserInvites
 *
 * ###Приглашения
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * GET | {%api_url}user/invites/<user_id>  | Получить приглашения присоединиться к задаче
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * task_id | Идентификатор задачи |
 * sended | Timestamp когда было выслано приглашение|
 * status | new ; accepted ; declined
 *
 * В случае ошибки будет возвращен код ошибки "Не найдено"
 * @package api\components\Rest\Get
 */
class UserInvites extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 300;

    /**
     * @var string
     */
    public $status;

    /**
     * @var integer
     */
    public $task_id;

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
            [['task_id', 'sended', 'status'], 'string'],
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        $userId = preg_replace('/[^0-9]/', '', Yii::$app->request->getUrl());
        $model = Invites::findAll(['user_id' => $userId]);
        if ($model) {
            $arr = [];
            $arrs = [];
            foreach ($model as $value) {
                $arr['task_id'] = $value->task_id;
                $arr['sended'] = $value->sended;
                $arr['status'] = $value->status;
                $arrs[] = $arr;
            }
            return $arrs;
        } else {
            \Yii::$app->response->throwError(ErrorCode::NOT_FOUND);
        }
    }

}