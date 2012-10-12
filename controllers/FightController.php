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

        $error = false;

        if(!($weapon_type = Yii::app()->request->getParam('weapon_type'))){
            $error = true;
        }elseif(!is_numeric($weapon_type)){
            $error = true;
        }

        if($error){
            throw new CHttpException(404,'Оружие не найдено');
        }

        $opponent = $this->loadModel($id);

        if($opponent === null){
            throw new CHttpException(404,'Игрок не найден');
        }elseif($opponent->alive == 0){
            throw new CHttpException(404,'Игрок мертв');
        }

        $result = $opponent->hit($weapon_type);


        switch(true){
            case $result->status == User::HIT_STATUS_PENDING:
                Yii::app()->user->setFlash('fighting', 'Arms is not ready...');
                break;

            case $result->status == User::HIT_STATUS_KILLED:
                Yii::app()->user->setFlash('fighting', 'Opponent was killed');
                break;
        }

        Yii::app()->user->logHit($result);

        if(!$opponent->save()){
            print_r($opponent->getErrors());exit;
        }
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
        $model = User::model()->findByPk((int)$id, 'current_area = :user_current_area', array(':user_current_area'=>Yii::app()->user->getArea()));
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
