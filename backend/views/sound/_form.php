<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:45
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Sound */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="sound-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        echo $form->field($model,'sound')->widget(
            Upload::className(),
            [
                'url' => ['/file-storage/upload'],
                'maxFileSize' => 10000000, // 10 MiB
                'acceptFileTypes' => new JsExpression('/^audio\/.*$/'),

            ]);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>