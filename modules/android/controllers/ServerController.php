<?php
class WarningException extends Exception { 
    public function __toString() {
        return  "Warning: {$this->message} {$this->file} on line {$this->line}\n";
    }
}
 
set_error_handler("error_handler", E_ALL);
 
function error_handler($errno, $errstr) {
    if($errno == E_WARNING) {
        throw new WarningException($errstr);
    } else if($errno == E_NOTICE) {
        throw new NoticeException($errstr);
    }
}


class ServerController extends Controller
{
	public function actionIndex()
	{

        $config = Yii::app()->controller->module->_config;

        $this->render('index');
	}

    public function actionStatus()
    {
		$this->layout = false;
		
        //set_error_handler(create_function('$n,$s,$f,$l', 'throw new CustomException($n,$s,$f,$l);'), E_ALL);
		
		try{
			socket_bind(1, 1, 1);
		}catch(WarningException $e){
			echo "12313";
		}
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