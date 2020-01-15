<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Founds */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="founds-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'logo_path')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'logo_base_url')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'banner_path')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'banner_base_url')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'country_id')->textInput() ?>

    <?php echo $form->field($model, 'href')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
