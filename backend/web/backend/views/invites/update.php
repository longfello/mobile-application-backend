<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Invites */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Invites',
]) . ' ' . $model->task_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Invites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->task_id, 'url' => ['view', 'task_id' => $model->task_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="invites-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
