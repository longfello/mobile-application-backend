<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 09.04.18
 * Time: 17:34
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Founds */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Founds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="founds-view">

    <p>
        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute'=>'logo',
                'label'=>'Logo',
                'format'=>'raw',

                'value' => function ($data) {

                    return Html::img($data->logo_base_url.'/'.$data->logo_path, ['alt'=>'myImage','width'=>'70','height'=>'50']);
                }
            ],
            'logo_path',
            'logo_base_url:url',
            [
                'attribute'=>'banner',
                'label'=>'Banner',
                'format'=>'raw',

                'value' => function ($data) {

                    return Html::img($data->banner_base_url.'/'.$data->banner_path, ['alt'=>'myImage','width'=>'70','height'=>'50']);
                }
            ],
            'banner_path',
            'banner_base_url:url',
            'country_id',
            'country.name',
            'href',
            'description:ntext',
        ],
    ]) ?>

</div>