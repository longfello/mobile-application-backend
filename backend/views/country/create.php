<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 16:53
 */
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = 'Create Country';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>