<?php

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
            'logo_path',
            'logo_base_url:url',
            'banner_path',
            // 'banner_base_url:url',
            // 'country_id',
            // 'href',
            // 'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
