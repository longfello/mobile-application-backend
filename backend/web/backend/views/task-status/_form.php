<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskStatus */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="task-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'task_id')->textInput() ?>

    <?php echo $form->field($model, 'user_id')->textInput() ?>

    <?php echo $form->field($model, 'status')->dropDownList([ 'current' => 'Current', 'done' => 'Done', 'fail' => 'Fail', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
