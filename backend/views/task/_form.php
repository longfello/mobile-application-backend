<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\ArrayHelper;
use common\models\Founds;
use common\models\User;
use common\models\TaskType;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'fund_id')->dropDownList(
        ArrayHelper::map(Founds::find()->all(), 'id', 'name')
    ) ?>
     <?php echo $form->field($model, 'owner_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username')
    ) ?>
     <?php echo $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(TaskType::find()->all(), 'id', 'name')
    ) ?>
    <?php echo $form->field($model, 'properties')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>