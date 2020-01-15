<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
/**
 * This is the model class for table "sound".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $base_url
 * @property array $sound
 */
class Sound extends \yii\db\ActiveRecord
{

    /**
     * @var array
     */
    public $sound;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sound';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'sound',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name', 'path', 'base_url'], 'required'],
            [['name', 'path', 'base_url'], 'string', 'max' => 255],
            [['sound'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'base_url' => 'Base Url',
            'sound' => 'Sound',
        ];
    }

    public function getUrl()
    {
        return $this->base_url . '/' . $this->path;
    }
}
