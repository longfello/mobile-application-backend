<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sound */

$this->title = 'Update Sound: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sound-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
