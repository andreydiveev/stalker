<?php
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.zf2.library.Zend.*'));

class BotController extends Controller
{
    public $connected;
    public  $layout = false;

	public function actionIndex()
	{
        (empty(Yii::app()->session[Yii::app()->session['nick'].'connected']))? Yii::app()->session[Yii::app()->session['nick'].'connected'] = 1:'';
        $this->connected = Yii::app()->session[Yii::app()->session['nick'].'connected'];



		$this->render('index');
	}

    public function actionConnect()
    {
        Yii::app()->session[Yii::app()->session['nick'].'connected'] = true;
        $this->redirect('/bot/index');
    }

    public function actionDisconnect()
    {
        Yii::app()->session[Yii::app()->session['nick'].'connected'] = false;
        $this->redirect('/bot/index');
    }

    public function actionSvalka()
    {

        if(Yii::app()->session[Yii::app()->session['nick'].'connected'] % 50 == 0){
            sleep(120);
        }


        sleep(36);
        Yii::app()->session[Yii::app()->session['nick'].'connected'] = Yii::app()->session[Yii::app()->session['nick'].'connected'] + 1;
        $this->redirect('/bot/index');
    }

    public function actionSetup(){
        $data = '';

        if(isset($_POST['setup'])){
            Yii::app()->session['nick'] = $_POST['setup']['nick'].' ';
            Yii::app()->session['pass'] = $_POST['setup']['pass'].' ';
            Yii::app()->session['lvl']  = $_POST['setup']['lvl'].' ';

            $this->redirect('/bot/index');
        }

        $this->render('setup', array('data'=>$data));
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