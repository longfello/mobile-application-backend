<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_type".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 *
 * @property Task[] $tasks
 */
class TaskType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['slug'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['type_id' => 'id']);
    }
}
