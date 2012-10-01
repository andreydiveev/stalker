<?php

class FightController extends Controller
{
	public function actionIndex()
	{
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
    public function actionAttack(){
        $id = Yii::app()->request->getParam('id');

        $opponent = $this->loadModel($id);

        if($opponent === null){
            throw new CHttpException(404,'Игрок не найден');
        }

        $opponent->kill();
        $opponent->save(); /** @TODO SET KILL TIME,CHECK SAVING */
        $this->redirect( Yii::app()->request->urlReferrer);
    }


    public function filters()
    {
        return array(
            'AccessControl + index',
            'CheckId + SellArms, SellEquipment, TakeOffArms',
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
                throw new CHttpException(404,'Игрок не найден');
         }
    }

    protected function loadModel($id)
    {
        $model = User::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
