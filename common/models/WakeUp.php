<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 20.04.18
 * Time: 9:50
 */

namespace common\models;

use yii\base\Model;


/**
 * Class WakeUp
 * @package common\models
 */
class WakeUp extends Model
{
    /**
     * @var string
     */
    public $time;
    /**
     * @var int
     */
    public $snoose_time;
    /**
     * @var [int]
     */
    public $repeat;
    /**
     * @var string
     */
    public $proof;
    /**
     * @var sound_id
     */
    public $sound_id;
    /**
     * @var 0 | 1
     */
    public $vibration;

    public function rules()
    {
        return [

            [['time'], 'time', 'format' => 'php:H:i:s'],
            [['snoose_time'], 'integer'],
            [['repeat'], 'safe'],
            [['sound_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sound::className(), 'targetAttribute' => ['sound_id' => 'id']],
            [['vibration'], 'number', 'min' => 0, 'max' => 1],

        ];
    }

    public function attributeLabels()
    {
        return [
            'time' => 'Time',
            'snoose_time' => 'Snoose Time',
            'repeat' => 'Repeat',
            'proof' => 'Proof',
            'sound_id' => 'Sound',
            'vibration' => 'Vibration',
        ];
    }
}