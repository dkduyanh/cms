<?php

namespace backend\controllers;

use backend\models\MenuForm;
use backend\models\MenuItemSearch;
use Yii;
use backend\models\main\Menu;
use backend\models\MenuSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\MenuItemForm;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BaseController
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

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findMenuModel ($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findMenuModel ($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->showFlashModelErrors($model);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findMenuModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Lists all MenuItem models.
     * @param $id
     * @return string
     */
    public function actionItems($id)
    {
        $menuModel = $this->findMenuModel($id);

        $searchItemModel = new MenuItemSearch();
        $searchItemModel->menu_id = $menuModel->id;
        $dataProvider = $searchItemModel->search(Yii::$app->request->queryParams);

        return $this->render('items', [
            'searchModel' => $searchItemModel,
            'dataProvider' => $dataProvider,
            'menuModel' => $menuModel,
        ]);
    }

    /**
     * Insert or Update menu item
     * @param $menu
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateItem($menu, $id = null)
    {
        $menuModel = $this->findMenuModel($menu);
        if($id){
            $model = $this->findItemModel($id);
            if($model->menu_id != $menuModel->id){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            $model = new MenuItemForm();
            $model->menu_id = $menuModel->id;
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['items', 'id' => $menuModel->id]);
        }

        //show error
        $this->showFlashModelErrors($model);

        return $this->render('item_form', [
            'menuModel' => $menuModel,
            'model' => $model,
        ]);
    }

    public function actionLoadItemForm($type)
    {
        $viewFile = $this->getViewPath().'/form_elements/'.$type.'.php'; //o($viewFile);
        if(!Yii::$app->request->isAjax || !is_file($viewFile)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = false;
        return $this->renderAjax('form_elements/'.$type);
        return $this->renderFile($viewFile);
    }

    /**
     * Delete menu item
     * @param $menu
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteItem($menu, $id)
    {
        $menuModel = $this->findMenuModel($menu);
        $model = $this->findItemModel($id);
        if($menuModel === null || $model === null || $menuModel->id !== $model->menu_id){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->delete()){
            $this->showFlashSuccessMessage(Yii::t('common', 'Record has been successfully created'));
        } else {
            $this->showFlashModelErrors($model);
        }

        $this->redirect(['items', 'id' => $menuModel->id]);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMenuModel ($id)
    {
        if (($model = MenuForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the MenuItem model based on its primary key value
     * @param integer $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findItemModel($id)
    {
        if (($model = MenuItemForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
