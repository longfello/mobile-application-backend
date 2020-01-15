<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-view">
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
//        'filterModel' => $searchModel,
//        'columns' => [
////            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'attribute'=>'user_login',
//                'label'=>'user_login',
//                'value' => 'owner.username',
//            ],
//            [
//                'attribute'=>'Task type',
//                'label'=>'Task type',
//                'value' => 'type.name',
//            ],
//            [
//                'attribute'=>'task_id',
//                'label'=>'task_id',
//                'value' => 'id',
//            ],
//
//            [
//                'attribute'=>'status',
//                'label'=>'Status',
//                'value' => function ($data) {
//                    if (isset($data->taskStatuses[0]['status'])) {
//                        return $data->taskStatuses[0]['status'];
//                    }
//                }
//
//            ],
//            [
//                    'attribute' => 'created',
//                    'label'=>'Created date',
//                    'format' => ['date', 'php:d-m-Y']
//            ],
//            [
//                    'attribute' => 'created',
//                    'label'=>' Created Time',
//                    'format' => ['date', 'php:H:i']
//            ],
//
//            [
//                'attribute'=>'donation',
//                'label'=>'paid/free',
//                'value' => function ($data) {
//                    return ($data->donation > 0) ? 'paid' : 'free' ;
//                }
//            ],
//            [
//                'attribute'=>'SnoozeDonation',
//                'label'=>'Snooze donation',
//                'value' => function ($data) {
//                   $sum =\common\models\TaskDonation::find()->where(['task_id'=>$data->id,'user_id'=>$data->owner->id])->sum('donation');
//                   return $sum;
//                }
//            ],
//            [
//                'attribute'=>'SnoozedQuantity',
//                'label'=>'Snoozed quantity',
//                'value' => function ($data) {
//                    $count =\common\models\TaskDonation::find()->where(['task_id'=>$data->id,'user_id'=>$data->owner->id])->count('donation');
//                    return $count;
//                }
//            ],
//            [
//                'attribute' => 'fund',
//                'label' => 'Fund',
//                'value' => 'fund.name'
//            ],
//            [
//                'attribute'=>'donation',
//                'label'=>'Donation',
//                'value' => 'donation'
//            ],
//
//        ],
    ]); ?>

</div>
