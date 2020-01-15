<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:33
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Founds */

$this->title = 'Update Founds: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Founds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="founds-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>