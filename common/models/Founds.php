<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "founds".
 *
 * @property int $id
 * @property string $name
 * @property string $logo_path
 * @property string $logo_base_url
 * @property string $banner_path
 * @property string $banner_base_url
 * @property int $country_id
 * @property string $href
 * @property string $description
 *
 * @property Country $country
 * @property Task[] $tasks
 */
class Founds extends \yii\db\ActiveRecord
{

    /**
     * @var array
     */
    public $logo;

    /**
     * @var array
     */
    public $baner;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'founds';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            [
                'class' => UploadBehavior::className(),
                'attribute' => 'logo',
                'pathAttribute' => 'logo_path',
                'baseUrlAttribute' => 'logo_base_url',
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'baner',
                'pathAttribute' => 'banner_path',
                'baseUrlAttribute' => 'banner_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['country_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'logo_path', 'logo_base_url', 'banner_path', 'banner_base_url', 'href'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['logo', 'baner'], 'safe']
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
            'logo_path' => 'Logo Path',
            'logo_base_url' => 'Logo Base Url',
            'banner_path' => 'Banner Path',
            'banner_base_url' => 'Banner Base Url',
            'country_id' => 'Country ID',
            'href' => 'Href',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['fund_id' => 'id']);
    }
}
