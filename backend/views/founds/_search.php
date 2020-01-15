<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:32
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\FoundsSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="founds-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'name') ?>

    <?php echo $form->field($model, 'logo_path') ?>

    <?php echo $form->field($model, 'logo_base_url') ?>

    <?php echo $form->field($model, 'banner_path') ?>

    <?php // echo $form->field($model, 'banner_base_url') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'href') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>