<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:58
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Habbit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habbits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habbit-view">

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
        ],
    ]) ?>

</div>