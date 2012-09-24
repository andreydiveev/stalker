<?php

class ProfileController extends Controller
{
	public function actionIndex()
	{

		$this->render('index', array(
            "userArms" => User::model()
        ));
	}


    public function filters()
    {
        return array(
            'AccessControl + index',
        );
    }

    public function filterAccessControl($filterChain)
    {
        // для выполнения последующих фильтров и выполнения действия вызовите метод $filterChain->run()

        if(!Yii::app()->user->isGuest){
            $filterChain->run();
        }else{
            $this->redirect('/site/login');
        }
    }
	// Uncomment the following methods and override them if needed
}