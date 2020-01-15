<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\InvitesSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="invites-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'task_id') ?>

    <?php echo $form->field($model, 'user_id') ?>

    <?php echo $form->field($model, 'status') ?>

    <?php echo $form->field($model, 'sended') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
