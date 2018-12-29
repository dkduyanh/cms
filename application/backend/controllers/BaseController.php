<?php
namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Show model errors
     * @param $model
     */
    protected function showFlashModelErrors($model)
    {
        if($model instanceof Model){
            foreach($model->getErrors() as $attr => $errs)
            {
                foreach($errs as $error){
                    $this->showFlashErrorMessage($error);
                }
            }
        }
    }

    /**
     * Show flash success message
     * @param $message
     */
    protected function showFlashSuccessMessage($message)
    {
        Yii::$app->session->setFlash('success', $message);
    }

    /**
     * Show flash warning message
     * @param $message
     */
    protected function showFlashWarningMessage($message)
    {
        Yii::$app->session->setFlash('warning', $message);
    }

    /**
     * Show flash error message
     * @param $message
     */
    protected function showFlashErrorMessage($message)
    {
        Yii::$app->session->setFlash('danger', $message);
    }
    
    /**
     * Process before action
     * {@inheritDoc}
     * @see \yii\web\Controller::beforeAction()
     */
    public function beforeAction($action)
    {
    	if(Yii::$app->request->isAjax){
    		$this->layout = false;
    	}
    	return parent::beforeAction($action);
    }
}