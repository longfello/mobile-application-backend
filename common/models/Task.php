<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $fund_id
 * @property int $owner_id
 * @property int $type_id
 * @property double $donation
 * @property string $properties
 * @property string $created
 * @property string $updated_at
 *
 * @property Invites[] $invites
 * @property User[] $users
 * @property Founds $fund
 * @property User $owner
 * @property TaskType $type
 * @property TaskDonation[] $taskDonations
 * @property TaskStatus[] $taskStatuses
 * @property User[] $users0
 */
class Task extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fund_id', 'owner_id', 'type_id', 'properties'], 'required'],
            [['fund_id', 'owner_id', 'type_id'], 'integer'],
//            [['donation'], 'number'],
            [['properties'], 'string'],
            [['created','updated_at','donation'], 'safe'],
            [['fund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Founds::className(), 'targetAttribute' => ['fund_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['type_id' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fund_id' => 'Fund',
            'owner_id' => 'Owner',
            'type_id' => 'Type',
            'donation' => 'Donation',
            'properties' => 'Properties',
            'created' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvites()
    {
        return $this->hasMany(Invites::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('invites', ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFund()
    {
        return $this->hasOne(Founds::className(), ['id' => 'fund_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TaskType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskDonations()
    {
        return $this->hasMany(TaskDonation::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskStatuses()
    {
        return $this->hasMany(TaskStatus::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('task_status', ['task_id' => 'id']);
    }

}
