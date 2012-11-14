<?php

class ServerController extends Controller
{
	public function actionIndex()
	{

        $config = Yii::app()->controller->module->_config;

        $this->render('index');
	}

    public function actionStatus()
    {

        print_r(Yii::app()->params['server_running']);

        $this->render('index');
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}