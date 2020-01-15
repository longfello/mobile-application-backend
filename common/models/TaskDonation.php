<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_donation".
 *
 * @property int $task_id
 * @property int $user_id
 * @property string $donation
 * @property string $created_at
 *
 * @property Task $task
 * @property User $user
 */
class TaskDonation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_donation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'donation'], 'required'],
            [['task_id', 'user_id'], 'integer'],
            [['donation'], 'number'],
            [['created_at'], 'safe'],
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
            'donation' => 'Donation',
            'created_at' => 'Created At',
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
}
