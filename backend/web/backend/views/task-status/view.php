<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TaskStatus */

$this->title = $model->task_id;
$this->params['breadcrumbs'][] = ['label' => 'Task Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-status-view">

    <p>
        <?php echo Html::a('Update', ['update', 'task_id' => $model->task_id, 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Delete', ['delete', 'task_id' => $model->task_id, 'user_id' => $model->user_id], [
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
            'task_id',
            'user_id',
            'status',
        ],
    ]) ?>

</div>
