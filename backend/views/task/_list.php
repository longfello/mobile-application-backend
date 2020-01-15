
<div>
    <table class="table table-bordered" style="width:50%">

        <tbody>
            <tr>
                <td><strong>User_login: </strong></td><td><span><?= $model->owner->username; ?></span></td>
            </tr>
            <tr>
                <td><strong>Task type: </strong></td><td><span><?= $model->type->name; ?></span></td>
            </tr>
            <tr>
                <td><strong>Task ID: </strong></td><td><span><?= $model->id; ?></span></td>
            </tr>
            <tr>
                <td><strong>Status: </strong></td><td><span><?= isset($model->taskStatuses[0]['status']) ? $model->taskStatuses[0]['status'] : '(no set)' ?></span></td>
            </tr>
            <tr>
                <td><strong>Created Date: </strong></td><td><span><?= Yii::$app->formatte'NOWr->asDate($model->created, 'php:d-m-Y'); ?></span></td>
            </tr>
            <tr>
                <td><strong>Created Time: </strong></td><td><span><?= Yii::$app->formatter->asDate($model->created, 'php:H:i'); ?></span></td>
            </tr>
            <tr>
                <td><strong>paid/free: </strong></td><td><span><?= ($model->donation > 0)? 'paid' : 'free'; ?></span></td>
            </tr>
            <tr>
                <?= $sum = \common\models\TaskDonation::find()->where(['task_id'=>$model->id,'user_id'=>$model->owner_id])->sum('donation');?>
                <td><strong>SnoozeDonation: </strong></td><td><span><?= isset($sum) ? $sum : '(no set)' ?></span></td>
            </tr>
            <tr>
                <td><strong>SnoozedQuantity: </strong></td><td><span><?= \common\models\TaskDonation::find()->where(['task_id'=>$model->id,'user_id'=>$model->owner->id])->count('donation'); ?></span></td>
            </tr>
            <tr>
                <td><strong>Fund: </strong></td><td><span><?= $model->fund->name; ?></span></td>
            </tr>
            <tr>
                <td><strong>Donation: </strong></td><td><span><?= $model->donation; ?></span></td>
            </tr>
        </tbody>
    </table>
</div>