<?php

use common\grid\EnumColumn;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\TaskStatus;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'User',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
//            'id',
//            'username',
//            'email:email',
//            [
//                'class' => EnumColumn::className(),
//                'attribute' => 'status',
//                'enum' => User::statuses(),
//                'filter' => User::statuses()
//            ],
//            'created_at:datetime',
//            'logged_at:datetime',
//            // 'updated_at',
            [
                'attribute' => 'username',
                'label' => 'user_login',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->username, ['view', 'id' => $data->id]);
                }
            ],
            [
                'attribute' => 'email',
                'label' => 'e-mail',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->email, ['view', 'id' => $data->id]);
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Reg date:',
                'format' => 'raw',
                'value' => function ($data) {
                    return Date('d-m-Y', $data->created_at);
                }
            ],
            [
                'attribute' => 'done',
                'label' => 'done tasks:',
                'format' => 'raw',
                'value' => function ($data) {
                    return TaskStatus::countByStatus($data->id,'done');
                }
            ],
            [
                'attribute' => 'failed',
                'label' => 'failed tasks:',
                'format' => 'raw',
                'value' => function ($data) {
                    return TaskStatus::countByStatus($data->id,'fail');
                }
            ],
            [
                'attribute' => 'current',
                'label' => 'current tasks:',
                'format' => 'raw',
                'value' => function ($data) {
                    return TaskStatus::countByStatus($data->id,'current');
                }
            ],
            [
                'attribute' => 'total',
                'label' => 'total tasks:',
                'format' => 'raw',
                'value' => function ($data) {
                    return TaskStatus::countAllStatus($data->id);
                }
            ],
            [
                'attribute' => 'donated',
                'label' => 'Donated',
                'format' => 'raw',
                'value' => function ($data) {
                    return Task::find()->select('donation')->where(['owner_id' =>$data->id])->sum('donation');
                }

            ],
            [
                'attribute' => 'fund',
                'label' => 'Fund - Sum',
                'format' => 'raw',
                'value' => function ($data) {
                    $list = [];
                    $model = Task::find()->where(['owner_id' =>$data->id])->all();
                    foreach ($model as $item){
                        $fund=$item->fund->name;
                        $sum = \common\models\TaskDonation::find()->where(['task_id'=>$item->id,'user_id'=>$item->owner_id])->sum('donation');
                    $list[] = Html::tag('p',($fund.' - '.$sum));
                    }
//                    $sum = \common\models\TaskDonation::find()->where(['user_id'=>$data->id])->sum('donation');
//                    $sum = ($sum)?$sum:0;
                    return implode("",$list);
                }
            ],
            [
                'attribute' => 'credit',
                'label' => 'Credit',
                'format' => 'raw',
                'value' => 'taskDonations.donation'

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
