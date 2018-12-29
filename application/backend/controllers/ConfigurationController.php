<?php

namespace backend\controllers;

use backend\models\CmsConfigurationForm;
use backend\models\ContactInfoConfigurationForm;
use backend\models\main\Configuration;
use backend\models\GeneralConfigurationForm;
use backend\models\UserConfigurationForm;
use Yii;
use backend\models\ConfigurationSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigurationController implements the CRUD actions for Configuration model.
 */
class ConfigurationController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGeneral()
    {
        $model = new GeneralConfigurationForm();
        if(!$model->hasInstalled())
        {
            $model->install();
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->showFlashSuccessMessage('Configuration saved.');
            return $this->refresh();
        }

        return $this->render('general', [
            'model' => $model
        ]);
    }

    public function actionCms()
    {
        $model = new CmsConfigurationForm();
        if(!$model->hasInstalled())
        {
            $model->install();
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->showFlashSuccessMessage('Configuration saved.');
            return $this->refresh();
        }

        return $this->render('cms', [
            'model' => $model
        ]);
    }

    public function actionContactInfo()
    {
        $model = new ContactInfoConfigurationForm();
        if(!$model->hasInstalled())
        {
            $model->install();
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->showFlashSuccessMessage('Configuration saved.');
            return $this->refresh();
        }

        return $this->render('contact-info', [
            'model' => $model
        ]);
    }

    public function actionUser()
    {
        $model = new UserConfigurationForm();
        if(!$model->hasInstalled())
        {
            $model->install();
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->showFlashSuccessMessage('Configuration saved.');
            return $this->refresh();
        }

        return $this->render('user', [
            'model' => $model
        ]);
    }

    /**
     * Lists all Configuration models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ConfigurationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Configuration model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Configuration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Configuration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Configuration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Configuration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Configuration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Configuration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configuration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
