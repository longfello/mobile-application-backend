<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SoundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sounds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sound-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Create Sound', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'path',
            'base_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
