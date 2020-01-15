<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Founds */

$this->title = 'Create Founds';
$this->params['breadcrumbs'][] = ['label' => 'Founds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="founds-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
