<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskStatus */

$this->title = 'Update Task Status: ' . ' ' . $model->task_id;
$this->params['breadcrumbs'][] = ['label' => 'Task Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->task_id, 'url' => ['view', 'task_id' => $model->task_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-status-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
