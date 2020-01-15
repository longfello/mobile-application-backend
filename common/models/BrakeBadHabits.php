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
 * Class BrakeBadHabits
 * @package common\models
 */
class BrakeBadHabits extends Model
{

    /**
     * @var Int
     */
    public $habit_id;
    /**
     * @var timestamp
     */
    public $quit_till;
    /**
     * @var timestamp
     */
    public $verification_time;


    /**
     * @return array
     */
    public function rules()
    {
        return [

            [['quit_till','verification_time'], 'date', 'format' => 'php:U'],
            [['habit_id'], 'integer'],
            [['habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Habbit::className(), 'targetAttribute' => ['habit_id' => 'id']],

        ];
    }


}