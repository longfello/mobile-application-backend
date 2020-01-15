<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:46
 */
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\editable\Editable;
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
            [
                'attribute'=>'name',
                'content'=>function($data){
                    return Editable::widget([
                        'name'=>'filename',
                        'attribute' => 'name',
                        'asPopover' => true,
                        'value' => $data->name,
                        'header' => 'Name',
                        'size'=>'md',
                        'afterInput' => Html::hiddenInput('id',$data->id),
                        'options' => ['class'=>'form-control', 'placeholder'=>'Enter name...'],
                    ]);
                }
            ],
            'url:url',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>