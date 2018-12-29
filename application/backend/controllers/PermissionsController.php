<?php

namespace backend\controllers;

use app\models\AclPermissionAssignmentForm;
use backend\models\main\AclPermission;
use backend\models\main\Role;
use backend\models\main\User;
use Yii;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AclPermissionForm;
use backend\models\AclPermissionSearch;

/**
 * PermissionsController implements the CRUD actions for AclPermission model.
 */
class PermissionsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AclPermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AclPermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    

    /**
     * Displays a single AclPermission model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AclPermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AclPermissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AclPermission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AclPermission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Update role's permissions
     * @param int $id RoleID
     */
    public function actionRole($id)
    {
        $model = new AclPermissionAssignmentForm();
        $model->assignee = Role::findOne($id);
        $model->setAttributes(Yii::$app->request->post());

       if(Yii::$app->request->isPost && $model->save())
       {

       }

        //o($permissions);
        
        return $this->render('role', [
            'model' => $model,
            'permList' => AclPermission::listAll()
        ]);
    }
    
    /**
     * Update user's permissions
     * @param int $id UserID
     */
    public function actionUser($id)
    {
        $model = new AclPermissionAssignmentForm();
        $model->assignee = User::findOne($id);
        $model->setAttributes(Yii::$app->request->post());

        if(Yii::$app->request->isPost && $model->save())
        {

        }

        //o($permissions);

        return $this->render('user', [
            'model' => $model,
            'permList' => AclPermission::listAll()
        ]);
    }
    
    /**
     * Finds the AclPermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AclPermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AclPermissionForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('acl', 'The requested page does not exist.'));
    }
    
    public function actionImport()
    {
        $controllers = $this->getModuleCommands(Yii::$app);
        foreach($controllers as $i => $controllerName){
            if(!in_array($controllerName, ['debug/default', 'debug/user', 'gii/default'])){
                $result = Yii::$app->createController($controllerName);
                if ($result !== false && $result[0] instanceof Controller) {
                    list($controller, $actionID) = $result;
                    $actions = $this->getActions($controller);
                    
                    foreach($actions as $action){
                        $model = new AclPermission();
                        $model->code = $controllerName.'/'.$action;
                        $model->name = $controllerName.'/'.$action;
                        $model->category = 'admincp/'.$controllerName;
                        $model->save();
                    }
                }
            }
        }
    }
    
    public function getActions($controller)
    {
        $actions = array_keys($controller->actions());
        $class = new \ReflectionClass($controller);
        foreach ($class->getMethods() as $method) {
            $name = $method->getName();
            if ($name !== 'actions' && $method->isPublic() && !$method->isStatic() && strncmp($name, 'action', 6) === 0) {
                $actions[] = Inflector::camel2id(substr($name, 6), '-', true);
            }
        }
        sort($actions);
        
        return array_unique($actions);
    }
    
    protected function validateControllerClass($controllerClass)
    {
        if (class_exists($controllerClass)) {
            $class = new \ReflectionClass($controllerClass);
            return !$class->isAbstract() && $class->isSubclassOf('yii\base\Controller');
        }
        
        return false;
    }
    
    protected function getModuleCommands($module)
    {
        $prefix = $module instanceof Application ? '' : $module->getUniqueId() . '/';
        
        $commands = [];
        foreach (array_keys($module->controllerMap) as $id) {
            $commands[] = $prefix . $id;
        }
        
        foreach ($module->getModules() as $id => $child) {
            if (($child = $module->getModule($id)) === null) {
                continue;
            }
            foreach ($this->getModuleCommands($child) as $command) {
                $commands[] = $command;
            }
        }
        
        $controllerPath = $module->getControllerPath();
        if (is_dir($controllerPath)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllerPath, \RecursiveDirectoryIterator::KEY_AS_PATHNAME));
            $iterator = new \RegexIterator($iterator, '/.*Controller\.php$/', \RecursiveRegexIterator::GET_MATCH);
            foreach ($iterator as $matches) {
                $file = $matches[0];
                $relativePath = str_replace($controllerPath, '', $file);
                $class = strtr($relativePath, [
                    DIRECTORY_SEPARATOR => '\\',
                    '.php' => '',
                ]);
                $controllerClass = $module->controllerNamespace . $class;
                if ($this->validateControllerClass($controllerClass)) {
                    $dir = ltrim(pathinfo($relativePath, PATHINFO_DIRNAME), DIRECTORY_SEPARATOR);
                    
                    $command = Inflector::camel2id(substr(basename($file), 0, -14), '-', true);
                    if (!empty($dir)) {
                        $command = $dir . DIRECTORY_SEPARATOR . $command;
                    }
                    $commands[] = $prefix . $command;
                }
            }
        }
        
        return $commands;
    }
}
