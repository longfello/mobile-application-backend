<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_status".
 *
 * @property int $task_id
 * @property int $user_id
 * @property string $status
 *
 * @property Task $task
 * @property User $user
 */
class TaskStatus extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_status}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id'], 'integer'],
            [['status'], 'string'],
            [['task_id', 'user_id'], 'unique', 'targetAttribute' => ['task_id', 'user_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function countByStatus($user_id,$status)
    {

       return TaskStatus::find()->where(['user_id'=>$user_id,'status'=>$status])->count();
    }

    public function countAllStatus($user_id)
    {

       return TaskStatus::find()->where(['user_id'=>$user_id])->count();
    }


}
