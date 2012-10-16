<?php

class MailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionTo()
	{


		$model=new UserMessage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserMessage']))
		{
            $to = Yii::app()->request->getParam('id');
            $taker = User::model()->findByPk($to);

            if($taker === null || Yii::app()->user->id == $taker->id){
                throw new CHttpException(404,'The requested page does not exist.');
            }

			$model->attributes=$_POST['UserMessage'];
            $model->from = Yii::app()->user->id;
            $model->to = $taker->id;
            $model->date = time();

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

        if($model->sender->id == Yii::app()->user->id || $model->taker->id == Yii::app()->user->id){
            $model->setDeleted();
        }else{
            throw new CHttpExeption(404, 'The requested page is not exist');
        }

        $this->redirect('/mail');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider('UserMessage', array(
            'criteria'=>array(
                'condition' => '`from` = :user OR `to` = :user AND deleted = 0',
                'params' => array(':user'=>Yii::app()->user->id),
                'order'=>'`t`.`id` DESC',
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

    public function actionIncoming()
    {
        $dataProvider=new CActiveDataProvider('UserMessage', array(
            'criteria'=>array(
                'condition'=>'`t`.`to` = :user_id AND deleted = 0',
                'params'   =>array(':user_id'=>Yii::app()->user->id),
                'order'=>'`t`.`id` DESC',
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionOutgoing()
    {
        $dataProvider=new CActiveDataProvider('UserMessage', array(
            'criteria'=>array(
                'condition'=>'`t`.`from` = :user_id AND deleted = 0',
                'params'   =>array(':user_id'=>Yii::app()->user->id),
                'order'=>'`t`.`id` DESC',
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserMessage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserMessage']))
			$model->attributes=$_GET['UserMessage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=UserMessage::model()->findByPk($id, 'deleted = 0');
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
        }
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
