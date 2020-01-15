<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskType */

$this->title = 'Update Task Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-type-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
