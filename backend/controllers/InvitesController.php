<?php

namespace backend\controllers;

use Yii;
use common\models\Invites;
use backend\models\search\InvitesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvitesController implements the CRUD actions for Invites model.
 */
class InvitesController extends Controller
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
     * Lists all Invites models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvitesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invites model.
     * @param integer $task_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($task_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($task_id, $user_id),
        ]);
    }

    /**
     * Creates a new Invites model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invites();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'task_id' => $model->task_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invites model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $task_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($task_id, $user_id)
    {
        $model = $this->findModel($task_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'task_id' => $model->task_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Invites model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $task_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($task_id, $user_id)
    {
        $this->findModel($task_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invites model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $task_id
     * @param integer $user_id
     * @return Invites the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($task_id, $user_id)
    {
        if (($model = Invites::findOne(['task_id' => $task_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
