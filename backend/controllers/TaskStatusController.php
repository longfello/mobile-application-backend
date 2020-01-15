<?php

namespace backend\controllers;

use Yii;
use common\models\TaskStatus;
use backend\models\search\TaskStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskStatusController implements the CRUD actions for TaskStatus model.
 */
class TaskStatusController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaskStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Finds the TaskStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $task_id
     * @param integer $user_id
     * @return TaskStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($task_id, $user_id)
    {
        if (($model = TaskStatus::findOne(['task_id' => $task_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
