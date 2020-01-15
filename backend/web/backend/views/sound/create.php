<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sound */

$this->title = 'Create Sound';
$this->params['breadcrumbs'][] = ['label' => 'Sounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sound-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
