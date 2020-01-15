<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<!--        --><?php //echo Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'fund',
                'label' => 'Fund Name',
                'value' => 'fund.name',
            ],
            [
                'attribute' => 'owner',
                'label' => 'Owner Name',
                'value' => 'owner.username',
            ],
            [
                'attribute' => 'type',
                'label' => 'Type Name',
                'value' => 'type.name',
            ],
            [
                'attribute'=>'status',
                'label'=>'Status',
                'value' => function ($data) {
                    if (isset($data->taskStatuses[0]['status'])) {
                        return $data->taskStatuses[0]['status'];
                    }
                }

            ],
            [
                    'attribute' => 'created',
                    'label'=>'Created date',
                    'format' => ['date', 'php:d-m-Y']
            ],
            [
                    'attribute' => 'created',
                    'label'=>' Created Time',
                    'format' => ['date', 'php:H:i']
            ],
            [
                'attribute'=>'donation',
                'label'=>'paid/free',
                'value' => function ($data) {
                    return ($data->donation > 0) ? 'paid' : 'free' ;
                }
            ],
            [
                'attribute'=>'donation',
                'label'=>'Donation',
                'value' => 'donation'
            ],
            [
                'attribute' => 'fund',
               'label' => 'Fund',
               'value' => 'fund.name'
           ],

                [
               'attribute'=>'SnoozeDonation',
               'label'=>'Snooze donation',
               'value' => function ($data) {
                   $sum =\common\models\TaskDonation::find()->where(['task_id'=>$data->id,'user_id'=>$data->owner->id])->sum('donation');
                   return $sum;
                }
            ],
            [
                'attribute'=>'SnoozedQuantity',
                'label'=>'Snoozed quantity',
                'value' => function ($data) {
                    $count =\common\models\TaskDonation::find()->where(['task_id'=>$data->id,'user_id'=>$data->owner->id])->count('donation');
                   return $count;
                }
            ],
            [
                'attribute' => 'properties',
                'label' => 'Properties',
                'format' => 'raw',
                'value' => function ($data) {
                    $val = @unserialize($data->properties);
                    return \yii\helpers\VarDumper::dumpAsString($val, 10, true);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
