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

    public function actionStart()
    {

        if(isset($_POST['port']) && is_numeric($_POST['port'])){
            $this->layout = false;
            $out = array();
            exec('pwd', $out);
            $path = $out[0];
            exec('../project/yiic server start --port='.(int)$_POST['port'],$out);
            print_r($out);

            //print('../project/yiic server start --port='.(int)$_POST['port']);
        }

        $this->render('start');
    }
    
    public function actionInterfaces(){
	
	$this->layout = false;
	
	Yii::import('ext.server.Socket');
	
	$socket = new Socket();
	$socket->check();
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