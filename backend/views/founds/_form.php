<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:31
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Founds */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="founds-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $country = Country::find()->all();?>
    <?php $countryList = ArrayHelper::map($country,'id','name');?>
    <?php $params = [
        'prompt' => 'Укажите страну'
    ];?>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'logo')->widget(
    '\trntv\filekit\widget\Upload',
    [
        'url' => ['upload'],
        'sortable' => true,
        'maxFileSize' => 10 * 1024 * 1024, // 10 MiB
        'maxNumberOfFiles' => 1,
        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ]
);?>
    <?php echo $form->field($model, 'baner')->widget(
    '\trntv\filekit\widget\Upload',
    [
        'url' => ['upload'],
        'sortable' => true,
        'maxFileSize' => 10 * 1024 * 1024, // 10 MiB
        'maxNumberOfFiles' => 1,
        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ]
);?>




    <?php  echo $form->field($model, 'country_id')->dropDownList($countryList,$params);?>

    <?php echo $form->field($model, 'href')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>