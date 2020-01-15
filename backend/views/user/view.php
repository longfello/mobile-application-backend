<?php

use yii\grid\GridView;
use yii\helpers\Html;
use http\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $modelUser \common\models\User */
/* @var $countStatus */
/* @var $donated mixed */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'current_user';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">

                    <tbody>
                    <tr>
                        <td>user_login: <?php echo $modelUser->username; ?></td>
                        <td>First name: <?php echo $modelUser->userProfile->firstname ?></td>
                    </tr>
                    <tr>
                        <td>Reg date: <?php echo Date('d-m-Y', $modelUser->created_at); ?></td>
                        <td>Second name: <?php echo $modelUser->userProfile->lastname ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box">
            <div class="box-body">
                <div class="col-lg-3 col-xs-6">
                    <?php if (isset($countStatus)): ?>
                        <ul class="nav nav-stacked">
                            <li>Total tasks: <span
                                        class="pull-right badge bg-blue"><?php echo array_sum($countStatus) ?></span>
                            </li>
                            <?php foreach ($countStatus as $key => $val): ?>
                                <li><?php echo ucfirst($key) ?> <span
                                            class="pull-right badge bg-aqua"><?php echo $val ?></span></a></li>
                            <?php endforeach; ?>
                            <?php if (isset($donated)): ?>
                                <li>Donated: <span class="pull-right badge bg-green"><?php echo $donated ?></span></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'Task type',
                    'label' => 'Task type',
                    'value' => 'type.name',
                ],
                [
                    'attribute' => 'task_id',
                    'label' => 'task_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->id, ['/task/view', 'id' => $data->id]);
                    }
                ],

                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'value' => function ($data) {
                        if (isset($data->taskStatuses[0]['status'])) {
                            return $data->taskStatuses[0]['status'];
                        } else {
                            return null;
                        }
                    }

                ],
                [
                    'attribute' => 'created',
                    'label' => 'Created date',
                    'format' => ['date', 'php:d-m-Y']
                ],
                [
                    'attribute' => 'created',
                    'label' => ' Created Time',
                    'format' => ['date', 'php:H:i']
                ],

                [
                    'attribute' => 'donation',
                    'label' => 'paid/free',
                    'value' => function ($data) {
                        return ($data->donation == 0) ? 'free' : 'paid';
                    }
                ],
//                [
//                    'attribute' => 'SnoozeDonation',
//                    'label' => 'Snooze donation',
//                    'value' => function ($data) {
//
//                        if (isset($data->taskDonations[0]['donation'])) {
//                            return $data->taskDonations[0]['donation'];
//                        } else {
//                            return null;
//                        }
//                    }
//                ],
//                [
//                    'attribute' => 'SnoozedQuantity',
//                    'label' => 'Snoozed quantity',
//                    'value' => function ($data) {
//                        if (isset($data->taskDonations[0]['donation'])) {
//                            return count($data->taskDonations[0]['donation']);
//                        } else {
//                            return null;
//                        }
//                    }
//                ],
//                [
//                    'attribute' => 'fund',
//                    'label' => 'Fund',
//                    'value' => 'fund.name'
//                ],
                [
                    'attribute' => 'fund',
                    'label' => 'Fund - Sum',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $sum = \common\models\TaskDonation::find()->where(['task_id'=>$data->id,'user_id'=>$data->owner_id])->sum('donation');
                        $sum = ($sum)?$sum:0;
                        return Html::tag('p',($data->fund->name.' - '.$sum));
                    }
                ],
                [
                    'attribute' => 'donation',
                    'label' => 'Donation',
                    'value' => 'donation'
                ],

                [
                    'attribute' => 'location',
                    'label' => 'Location',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return 'no';
                    }
                ],

            ],
        ]); ?>

    </div>

</div>
