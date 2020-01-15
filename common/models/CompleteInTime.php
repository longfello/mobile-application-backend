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
 * Class CompleteInTime
 * @package common\models
 */
class CompleteInTime extends Model
{
    /**
     * @var string
     */
    public $title;
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
     * @var [{},{}]
     */
    public $subtask;
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
            [['subtask'], 'safe'],
        ];
    }


}