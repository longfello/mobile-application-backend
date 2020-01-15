<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Invites */

$this->title = 'Create Invites';
$this->params['breadcrumbs'][] = ['label' => 'Invites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invites-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>