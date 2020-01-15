<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Founds */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Founds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="founds-view">

    <p>
        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'logo_path',
            'logo_base_url:url',
            'banner_path',
            'banner_base_url:url',
            'country_id',
            'href',
            'description:ntext',
        ],
    ]) ?>

</div>
