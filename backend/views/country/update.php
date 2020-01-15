<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 16:54
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = 'Update Country: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="country-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>