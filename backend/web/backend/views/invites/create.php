<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Invites */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Invites',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Invites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invites-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
