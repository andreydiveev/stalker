<?php
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.zf2.library.Zend.*'));

class BotController extends Controller
{
    public $connected;
    public  $layout = false;

	public function actionIndex()
	{
        (empty(Yii::app()->session['connected']))? Yii::app()->session['connected'] = 1:'';
        $this->connected = Yii::app()->session['connected'];



		$this->render('index');
	}

    public function actionConnect()
    {
        Yii::app()->session['connected'] = true;
        $this->redirect('/bot/index');
    }

    public function actionDisconnect()
    {
        Yii::app()->session['connected'] = false;
        $this->redirect('/bot/index');
    }

    public function actionSvalka()
    {

        if(Yii::app()->session['connected'] % 50 == 0){
            sleep(120);
        }


        sleep(36);
        Yii::app()->session['connected'] = Yii::app()->session['connected'] + 1;
        $this->redirect('/bot/index');
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