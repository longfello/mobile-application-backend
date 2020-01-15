<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 20.04.18
 * Time: 9:50
 */

namespace common\models;

use common\components\validators\RepeatValidate;
use yii\base\Model;


/**
 * Class BeInTime
 * @package common\models
 */
class BeInTime extends Model
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var {lat: float, lng: float}
     */
    public $location;
    /**
     * @var timestamp
     */
    public $deadline;
    /**
     * @var timestamp
     */
    public $reminder;
    /**
     * @var daily | weekly | monthly | yearly
     */
    public $repeat;
    /**
     * @var string
     */
    public $note;

    public function rules()
    {
        return [

            [['title', 'note'], 'string'],
            [['deadline', 'reminder'], 'date', 'format' => 'php:U'],
            [['repeat'], RepeatValidate::className()],
            [['location'], 'safe'],
        ];
    }


}