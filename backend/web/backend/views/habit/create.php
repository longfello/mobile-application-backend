<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Habbit */

$this->title = 'Create Habbit';
$this->params['breadcrumbs'][] = ['label' => 'Habbits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habbit-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
