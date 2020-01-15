<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Habbit */

$this->title = 'Update Habbit: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Habbits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="habbit-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
