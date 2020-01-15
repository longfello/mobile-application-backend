<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:33
 */
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FoundsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Founds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="founds-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Create Founds', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'count',
                'label'=>'Count',
                'format'=>'raw',
                'value' => function ($data) {
                $task_id = 0;
                if (isset($data->tasks[0]['id'])) {
                    $task_id = $data->tasks[0]['id'];
                    }
                 $count =\common\models\TaskDonation::find()->where(['task_id'=>$task_id])->count('donation');
                return ($count) ? $count : 0;
                }
            ],
            [
                'attribute'=>'sum',
                'label'=>'Sum',
                'format'=>'raw',
                'value' => function ($data) {
                    $task_id = 0;
                    if (isset($data->tasks[0]['id'])) {
                        $task_id = $data->tasks[0]['id'];
                    }
                    $sum =\common\models\TaskDonation::find()->where(['task_id'=>$task_id])->sum('donation');
                    return ($sum) ? $sum : 0;
                }
            ],
            [
                'attribute'=>'logo',
                'label'=>'Logo',
                'format'=>'raw',

                'value' => function ($data) {

                    return Html::img($data->logo_base_url.'/'.$data->logo_path, ['alt'=>'myImage','width'=>'70','height'=>'50']);
                }
            ],
            [
                'attribute'=>'banner',
                'label'=>'Banner',
                'format'=>'raw',

                'value' => function ($data) {

                    return Html::img($data->banner_base_url.'/'.$data->banner_path, ['alt'=>'myImage','width'=>'70','height'=>'50']);
                }
            ],
            [
                'attribute' => 'country',
                'value' => 'country.name'
            ],
             'href',
             'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>