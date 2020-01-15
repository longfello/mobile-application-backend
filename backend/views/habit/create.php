<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:57
 */
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