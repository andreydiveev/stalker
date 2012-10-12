<?php

class FightController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

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

    public function actionAttackMob(){
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


        $mob = $this->loadMob($id);

        if($mob === null){
            throw new CHttpException(404,'Игрок не найден');
        }elseif($mob->alive == 0){
            throw new CHttpException(404,'Игрок мертв');
        }

        $result = $mob->hit($weapon_type);


        switch(true){
            case $result->status == Mob::HIT_STATUS_PENDING:
                Yii::app()->user->setFlash('fighting', 'Arms is not ready...');
                break;

            case $result->status == Mob::HIT_STATUS_KILLED:
                Yii::app()->user->setFlash('fighting', 'Opponent was killed');
                break;
        }

        Yii::app()->user->logHit($result);

        if(!$mob->save()){
            print_r($opponent->getErrors());exit;
        }

        $this->redirect( Yii::app()->request->urlReferrer);
    }

    public function filters()
    {
        return array(
            'AccessControl',
            'CheckId + Attack, AttackMob',
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
        if($id == Yii::app()->user->id){
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'id = :id AND current_area = :current_area AND alive = 1';
        $criteria->params = array(
            ':id' => $id,
            ':current_area' => Yii::app()->user->getArea(),
        );
        $criteria->limit = 1;

        $model = User::model()->find($criteria);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function loadMob($id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id = :id AND area_id = :current_area AND alive = 1';
        $criteria->params = array(
            ':id' => $id,
            ':current_area' => Yii::app()->user->getArea(),
        );
        $criteria->limit = 1;

        $model = Mob::model()->find($criteria);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
