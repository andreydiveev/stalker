<?php

class ProfileController extends Controller
{
	public function actionIndex()
	{

		$this->render('index', array(
            "userArms" => User::model()
        ));
	}

    public function actionSellArms(){
        $id = Yii::app()->request->getParam('id');

        $model = UserArms::model()->findByPk($id);

        if($model === null){
            $msg = '<b>Item not found</b>';
            Yii::app()->user->setFlash('msg', $msg);
            $this->redirect('/profile');
            Yii::app()->end();
        }

        Yii::app()->user->sell($model->id);
        $this->redirect('/profile');

    }

    public function filters()
    {
        return array(
            'AccessControl + index',
            'CheckId + SellArms',
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


    public function filterCheckId($filterChain){
        if($id = Yii::app()->request->getParam('id')){
            $filterChain->run();
        }else{
            throw new CHttpException(404,'Товар не найден');
        }
    }
}