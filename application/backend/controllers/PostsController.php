<?php

namespace backend\controllers;

use Yii;
use backend\models\cms\Post;
use backend\models\PostList;
use backend\models\PostForm;
use backend\models\cms\Type;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Post model.
 */
class PostsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
	    return ArrayHelper::merge( parent::behaviors(), [
		    'verbs' => [
			    'class'   => VerbFilter::className(),
			    'actions' => [
				    'delete'    => [ 'POST' ],
				    'duplicate' => [ 'POST' ],
			    ],
		    ],
	    ] );
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        $searchModel = new PostList();
        $searchModel->type_id = $type;

        $dataProvider = $searchModel->search($type, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $type
     * @param string $term
     * @return string
     */
    public function actionAjax($type, $term = '')
    {
        //$this->layout = false;
        if(!Yii::$app->request->isAjax){
           // throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new PostList();
        $searchModel->type_id = $type;
        $searchModel->title = $term;

        $dataProvider = $searchModel->search($type, []);
        return json_encode(ArrayHelper::map($dataProvider->models, 'id', 'title'));
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $typeModel = $this->findTypeModel($type);

        $model = new PostForm();
        $model->post = new Post();
        $model->post->loadDefaultValues();
        $model->post->type_id = $typeModel->id;
        $model->post->created_date = gmdate('Y-m-d H:i:s');
	    $model->post->creator_id =  Yii::$app->user->getId();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            $this->showFlashSuccessMessage(Yii::t('common', 'Record has been successfully created'));
            return $this->redirect(['view', 'id' => $model->post->id]);
        }
        //error
        $this->showFlashModelErrors($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	//load post data
    	$model = new PostForm();
        $model->post = $this->findModel($id);
        $model->post->last_modified_date = gmdate('Y-m-d H:i:s');
        $model->post->last_modifier_id =  Yii::$app->user->getId();

        //update post data
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            $this->showFlashSuccessMessage(Yii::t('common', 'Record has been successfully updated'));
            return $this->redirect(['view', 'id' => $model->post->id]);
        }

        //render
        $this->showFlashModelErrors($model);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDuplicate($id)
    {
    	$model = new PostForm();
        $model->post = $this->findModel($id);
        $clonedModel = $model->duplicate();

        $clonedModel->post->created_date = gmdate('Y-m-d H:i:s');
        $clonedModel->post->creator_id =  Yii::$app->user->getId();

        if($clonedModel->save())
        {
            $this->showFlashSuccessMessage(Yii::t('common', 'Record has been successfully created'));
            return $this->redirect(['update', 'id' => $clonedModel->post->id]);
        }

        //go back if error
        $this->showFlashModelErrors($clonedModel);
        return $this->redirect(['update', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            $this->showFlashSuccessMessage(Yii::t('common', 'Record has been successfully deleted'));
        } else {
            $this->showFlashModelErrors($model);
        }
        return $this->redirect(['index', 'type' => $model->type_id]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findTypeModel($id)
    {
        if (($model = Type::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $typeId
     * @return PostForm
     */
    protected function createModel($typeId)
    {
        $model = new PostForm();
        $model->type_id = $typeId;
        return $model;
    }

}
