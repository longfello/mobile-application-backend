<?php

namespace backend\controllers;

use Yii;
use common\models\Sound;
use backend\models\search\SoundSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * SoundController implements the CRUD actions for Sound model.
 */
class SoundController extends Controller
{
    /**
     * @return array
     */
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
     * Lists all Sound models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SoundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $searchModel = Sound::findOne(Yii::$app->request->post('id'));
            $searchModel->name = trim(Yii::$app->request->post('filename'));
            if ($searchModel->save()) {
                $output = '';
                $out = Json::encode(['output' => $output, 'message' => '']);
                echo $out;
                return;
            } else {
                return false;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sound model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sound model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sound();
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->name = $model->sound['name'];

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Sound model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sound model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sound model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sound the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sound::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
